<?php

namespace App\Repository;
use App\Models\Transacao;
class TransactionRepository{

    public function create(Array $data){
        return Transacao::create($data);
    }

    public function all(){
        return Transacao::all();
    }

    public function findById($id){
        return Transacao::find($id);
    }

}


?>