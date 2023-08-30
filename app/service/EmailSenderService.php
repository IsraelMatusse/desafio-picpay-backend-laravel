<?php
namespace App\service; 
use App\Models\EmailSender;
use App\Repository\EmailSenderRepo;
use Illuminate\Support\Facades\Mail;
class EmailSenderService{

    protected $emaiSenderlRepo;

    public function __construct(EmailSenderRepo $emailSenderRepo){
            $this->emaiSenderlRepo=$emailSenderRepo;
    }

    public function sendEmail(array $emailSender){
   
    $emailSender=[
        'sender_email'=> $emailSender['sender_email'],
        'system_email'=>$emailSender['system_email'],
        'subject'=>$emailSender['subject'],
        'message'=>$emailSender['message']
    ];

    Mail::send([], [], function ($message) use ($emailSender) {
        $message->to($emailSender['sender_email'])
                ->from($emailSender['system_email'])
                ->subject($emailSender['subject'])
                ->setBody($emailSender['message'], 'text/plain');
    });


    $this->emaiSenderlRepo->create($emailSender);

    }

}

?>