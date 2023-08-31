<?php

namespace App\Http\Controllers;

use App\service\EmailSenderService;
use Illuminate\Http\Request;


class EmailSenderController extends Controller
{
    protected $emailSenderService;

    public function __construct(EmailSenderService $emailSenderService){
        $this->emailSenderService=$emailSenderService;
    }

    public function store(Request $request){

        $data=$request->all();
        $email=$this->emailSenderService->sendEmail($data);
        return response()->json(['message' => 'Email enviado com sucesso', 'data' => $email], 201); 


    }

}
