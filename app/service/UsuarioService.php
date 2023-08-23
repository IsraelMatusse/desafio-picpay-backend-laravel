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
        'email'=>'required|email|unique:usuarios',
        'nome'=>'required|max:225|ctype_alpha',
        'bi' => [
            'required',
            'string',
            function ($bi, $value, $fail) {
                if (strlen($value) !== 9) {
                    $fail("$bi must be exactly 9 characters.");
                }
            },
        ],
        
                'user_type' => [
            'required',
            Rule::in(['customer', 'seller']),
            function ($user_type, $value, $fail) {
                if (strcasecmp($value, 'customer') !== 0 && strcasecmp($value, 'seller') !== 0) {
                    $fail("$user_type must be 'customer' or 'seller'.");
                }
            },
        ],

    ];
       $messages=[
                    'email.required'=>'The email field is required',
                    'nome.required'=>'O nome e obrigatorio'
       ];
        $validator= Validator::make($data, $rules, $messages);
        if($validator->fails()){
            throw ValidationException::withMessages($validator->errors()->all());
        }
        return $this->usuarioRepository->create($data);

    }

    public function findUsuarioById($id){
        return $this->usuarioRepository->findById($id);
        
    }
    public function findAll(){
        return $this->usuarioRepository->findAll();
    }
    public function findByEmail($email){
        return $this->usuarioRepository->findByEmail($email);
    }

   
}




?>