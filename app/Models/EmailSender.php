<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSender extends Model
{
    use HasFactory;
    protected $fillable=[
        'receiver_email',
        'message',
        'system_email',
        'subject'   
];
    protected $table="email_sender";
}
