<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Display register page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('auth.register');
    }

    /**
     * Handle account registration request
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = $request->all();
        $avatardefault = 'logo.jpg';
        $u = new User($user);
        $u->avatar = $avatardefault;
        $u->save();
        $mail = new MailController;
        $subject = "$u->username, Welcome to Babon world";
        $mail->sendMail($subject, $u);
        return redirect('login')->with('status','Sign up successfully');

    }
}
