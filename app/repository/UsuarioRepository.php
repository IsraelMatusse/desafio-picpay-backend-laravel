<?php

namespace App\Repository;

use App\Models\Usuario;

class UserRepository{

public function create (array $data){
    return Usuario::create($data);
}

public function findById($id){
    return Usuario::find($id);
}
public function deleteById($id){
    $Usuario=$this->findById($id);
    if($Usuario){
    $Usuario->delete();
    }
    return null;
}
public function updateById($id){
   $Usuario=$this->findById($id);
   if($Usuario){
    $Usuario->delete();
   }
   return null;
}
}

?>
