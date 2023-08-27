<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Usuario extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'bi',
        'balance',
        'user_type'
    ];

    public function sentTransactions()
    {
        return $this->hasMany(Transacao::class, 'sender_id');
    }
    
    public function receivedTransactions()
    {
        return $this->hasMany(Transacao::class, 'receiver_id');
    }
  
}
