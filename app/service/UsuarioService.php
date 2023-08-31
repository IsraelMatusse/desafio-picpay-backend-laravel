<?php
namespace App\service;
use App\Repository\UsuarioRepository;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LogicException;
use App\Validators\FieldsValidator;
use PhpParser\Node\Expr\Cast\Double;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UsuarioService{

    protected $usuarioRepository;
    protected $fieldsValidator;

    public function __construct(UsuarioRepository $usuarioRepository, FieldsValidator $fieldsValidator){
        $this->usuarioRepository=$usuarioRepository;
        $this->fieldsValidator=$fieldsValidator;
    }
    public function createUsuario(array $data ):Usuario{
        $rules=[
            'email'=>['required', 'emai', 'unique:usuarios'],
            'name'=>['required','max:225','regex:/^[A-Za-z\s]+$/'],
            'bi' => ['required', 'string', 'unique:usuarios' ,'max:9', 'min:9'],
            'password'=>'required','string', 'max:15min','min:5'];

            $messages=[
                'email.unique'=>'email deve ser nulo',
                'email.email'=>'Introduza um email valido',
                'bi.unique'=>'O numero de bi deve ser unico',
                'bi.required'=>'O numero do documento e obrigatorio',
                'password.max'=>'O tamanho maximo de password sao 15 caracteres',
                'password.min'=>'O tamanho minimo de password sao caracteres',
                'bi.min'=>'O numero de Bi esta incompleto',
                'bi.max'=>'Ultrapassou o numero maximo de digitos do bi'

            ];
            $validator= Validator::make($data, $rules, $messages);
            if($validator->fails()){
                throw ValidationException::withMessages($validator->errors()->all());
            }
        return $this->usuarioRepository->create($data);
    }

    public function findAll(){
        return $this->usuarioRepository->findAll();
    }


    public function findUsuarioById($id){
        return $this->usuarioRepository->findById($id);  
    }
  

    public function updateUsuario(array $data, $userId)
    {
        $user = Usuario::findOrFail($userId);
        $user->update($data);

        return $user;
    }

   
}




?>