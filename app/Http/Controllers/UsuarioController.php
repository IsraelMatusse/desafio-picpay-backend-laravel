<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\UsuarioService;
use App\Http\Controllers\JsonResponse;

class UsuarioController extends Controller
{
   protected $usuarioService;
   public function __construct(UsuarioService $usuarioService){
    $this->usuarioService=$usuarioService;
   }

    public function index(){
        return $this->usuarioService->findAll();
    }
    public function store(Request $request){

        $data=$request->all();
        $usuario=$this->usuarioService->createUsuario($data);
        return response()->json(['message' => 'Usuário criado com sucesso', 'data' => $usuario], 201); 
    }

    public function show($id){
        return $this->usuarioService->findUsuarioById($id);
    }
}
