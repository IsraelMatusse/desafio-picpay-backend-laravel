<?php
namespace App\Repository;
use App\Models\EmailSender;

class EmailSenderRepo{

    function create(array $data){
      return EmailSender::create($data);
    }

    function findAll(){
       return EmailSender::All();
    }
    function findById($id){
        return EmailSender::find($id);
    }
}


?>