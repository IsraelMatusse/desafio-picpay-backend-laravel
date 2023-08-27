<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\service\TransactionService;
use Illuminate\Support\Arr;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService){
       $this-> transactionService=$transactionService;
    }

    public function index(){
        $this->transactionService->index();
    }

    public function store(Request $request){

        $data=$request->all();
        $transaction=$this->transactionService->create($data);
        return response()->json(['message' => 'transacao realizada com sucesso', 'data' => $transaction], 201); 

    }



        
    
}
