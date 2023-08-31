<?php

namespace App\Repository;

use App\Models\Usuario;
use Illuminate\Support\Arr;

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
    $usuario=$this->findById($id);
    if($usuario){
        Usuario::destroy($id);
    }
   
}
public function update(array $data, $usuarioId){
    $usuario=Usuario::findOrFail($usuarioId);
    $usuario->update($data);
    return $usuario;
}
}

?>
