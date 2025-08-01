<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail($subject, $user)
    {
        $data = array('name'=>$user->username);
        Mail::send('mail', $data, function($message) use ($subject, $user){
            $message->from('babonsocialnetworking@gmail.com','Team Babon');
            $message->to($user->email, $user->username);
            $message->subject($subject);
        });
    }

    public function sendMailSupport($subject, $ticket,$answer)
    {
        $data = array('name'=>$ticket->users->username, 'answer'=>$ticket->answer);
        Mail::send('mailanswer', $data, function($message) use ($subject, $ticket){
            $message->from('babonsocialnetworking@gmail.com','Team Babon');
            $message->to($ticket->users->email, $ticket->users->username);
            $message->subject($subject);
        });
    }

}
