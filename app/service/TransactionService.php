<?php 

namespace App\service;
use Carbon\Carbon;
use App\Models\Transacao;
use App\Repository\TransactionRepository;
use App\service\UsuarioService;
use App\Models\Usuario;
use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\utils\GenerateCodes;

class TransactionService{

    protected $transactionRepository;
    protected $usuarioService;
    protected $generateCodes;
    protected $emailSenderService;
    
    

    public function __construct(TransactionRepository $transactionRepository, UsuarioService $usuarioService, EmailSenderService $emailSenderService){
        $this->transactionRepository=$transactionRepository;
        $this->usuarioService=$usuarioService;
        $this->emailSenderService=$emailSenderService;
       
    }


    public function create(array $data){

    $generateCodes= new GenerateCodes();

   $sender=$this->usuarioService->findUsuarioById($data['sender_id']); 
   $receiver=$this->usuarioService->findUsuarioById($data['receiver_id']);
    if($sender->id==$receiver->id){
        throw ValidationException::withMessages([
            'sender_id' => 'The user cant send money to his account',
        ])  ;
    }

    if ($sender->balance < $data['amount'] || $sender->user_type !== 'costumer') {
        throw ValidationException::withMessages([
            'amount' => 'Your ballance doesnt accept this transaction or the user is not a costumer.',
        ]);
    }

    //check the response from the external api
    $response= Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
    if($response->successful()){
    $responseData=json_decode($response->body());
    if($responseData->message==="Autorizado"){
        // Deduct amount from sender and add to receiver
        $sender->balance -= $data['amount'];
        $receiver->balance += $data['amount'];
    }else{
        throw ValidationException::withMessages([
           'Transacao nao foi autorizada.',
        ]);
    }
    }else{
        throw ValidationException::withMessages([
            'Nao foi possivel obter uma resposta no momento',
        ]);
    }


    // Update user balances
    $this->usuarioService->updateUsuario(['balance' => $sender->balance], $sender->id);
    $this->usuarioService->updateUsuario(['balance' => $receiver->balance], $receiver->id);

    // Prepare transaction data
    $transactionData = [
        'sender_id' => $sender->id,
        'receiver_id' => $receiver->id,
        'amount' => $data['amount'],
        'status' => 'success',
        'type' => 'c2b',
        'transaction_reference'=>$generateCodes->generateTransactionReference() 
    ];
    $systemEmail="devmathusse451@gmail.com";
    $subject="Transferencia";
    $amount=$data['amount'];
    $message="Caro cliente, acaba de receber o valor de $amount  mt na sua conta";

    //sending notification to the receiver
    $emailSender=[
        'sender_email'=> $receiver->email,
        'system_email'=>$systemEmail,
        'subject'=>$subject,
        'message'=>$message
    ];
    $this->emailSenderService->sendEmail($emailSender);

    // Create and return the transaction
    return $this->transactionRepository->create($transactionData);
}

    public function index(){
        return $this->transactionRepository->all();
    }
    public function find($id){
        return $this->transactionRepository->findById($id);
    }
        
    }


?>