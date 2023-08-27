<?php

namespace App\Repository;

use App\Models\Usuario;

class UsuarioRepository {

public function create (array $data){
    return Usuario::create($data);
}


public function findAll(){
    return Usuario::all();
}

public function findById($id){
    return Usuario::findOrFail($id);
}


public function deleteById($id){
    $Usuario=$this->findById($id);
    if($Usuario){
    $Usuario->delete();
    }
    return null;
}
public function update(array $data){
    $Usuario->edit($data);
  
}
}

?>
