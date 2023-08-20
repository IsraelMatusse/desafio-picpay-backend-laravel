<?php
namespace App\service;
use App\Repository\UsuarioRepository;

class UsuarioService{

    protected $UsarioRepository;

    public function __construct(UsuarioRepository $userRepository){
        $this->usuarioRepository=$usuarioRepository;
    }
    public function createUsuario(array $usuarioData){
    return $this->usuarioRepository->create($usuarioData);
    }

    public function findUsuarioById($id){
        return $this->usuarioRepository->findById($id);
        
    }

}




?>