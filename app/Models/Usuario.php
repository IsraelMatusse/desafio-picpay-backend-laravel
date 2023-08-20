<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'bi',
        'balance',
        'user-type'
    ];
    public static $rules = [
        'email' => 'required|email|unique:Usuario',
        'email'=>'required|bi|unique:Usuario'
    ];
}
