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
    
    

    public function __construct(TransactionRepository $transactionRepository, UsuarioService $usuarioService){
        $this->transactionRepository=$transactionRepository;
        $this->usuarioService=$usuarioService;
       
    }

 

    public function create(array $data){

    $generateCodes= new GenerateCodes();
    $currentDate= new DateTime();
    $currentDateString = $currentDate->format('Y-m-d'); 

   $sender=$this->usuarioService->findUsuarioById($data['sender_id']); 
   $receiver=$this->usuarioService->findUsuarioById($data['receiver_id']);
    if($sender->id==$receiver->id){
        throw ValidationException::withMessages([
            'sender_id' => 'Usuário não pode enviar dinheiro para a propria conta',
        ])  ;
    }

    if ($sender->balance < $data['amount'] || $sender->user_type !== 'costumer') {
        throw ValidationException::withMessages([
            'amount' => 'Usuário não tem saldo suficiente ou não é um cliente.',
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