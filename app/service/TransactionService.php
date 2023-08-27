<?php 

namespace App\service;
use Carbon\Carbon;
use App\Models\Transacao;
use App\Repository\TransactionRepository;
use App\service\UsuarioService;
use App\Models\Usuario;
use DateTime;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class TransactionService{

    protected $transactionRepository;
    protected $usuarioService;

    public function __construct(TransactionRepository $transactionRepository, UsuarioService $usuarioService){
        $this->transactionRepository=$transactionRepository;
        $this->usuarioService=$usuarioService;
    }

 

    public function create(array $data){
    $currentDate= new DateTime();
    $currentDateString = $currentDate->format('Y-m-d'); 

   $sender=$this->usuarioService->findUsuarioById($data['sender_id']); 
    $receiver=$this->usuarioService->findUsuarioById($data['receiver_id']);
    if($data['sender_id']==$data['receiver_id']){
        throw ValidationException::withMessages([
            'sender_id' => 'Usuário não pode enviar dinheiro para a propria conta',
        ])  ;
    }

    if ($sender->balance < $data['amount'] || $sender->user_type !== 'costumer') {
        throw ValidationException::withMessages([
            'amount' => 'Usuário não tem saldo suficiente ou não é um cliente.',
        ]);
    }

    // Deduct amount from sender and add to receiver
    $sender->balance -= $data['amount'];
    $receiver->balance += $data['amount'];

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
        'transaction_reference'=>"$currentDateString.c2b.$sender->id.$receiver->id"
        // Other transaction data
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