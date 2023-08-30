<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSender extends Model
{
    use HasFactory;
    protected $fillable=[
        'sender_email',
        'message',
        'sistem_email',
        'subject'   
];
    protected $table="email_sender";
}
