<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transacao extends Model
{
    protected $fillable=[
            'amount',
            'status',
            'type',
            'transaction_reference',
            'sender_id', 'receiver_id'
    ];

    public function sender()
    {
        return $this->belongsTo(Usuario::class, 'sender_id');
    }
    
    public function receiver()
    {
        return $this->belongsTo(Usuario::class, 'receiver_id');
    }

    protected $table="transactions";

    use HasFactory;

}
