<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display login page.
     * 
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle account login request
     * 
     * @param LoginRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)):
            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth $user
     * 
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user) 
    {
        if (Auth::check()) {
            $user = Auth::user();
            $posts = Post::all(); 
            if ($user->level == '1') {
                return redirect('/newsfeed/home');
            } else if ($user->level == '0') {
                if ($user->status == '0') {
                    return redirect('/newsfeed/home');
                } else {
                    Auth::logout(); // Log out the user if the account is banned
                    return redirect()->route('login.perform')->with('error', 'Account has been banned');
                }
            }
        } 
      }
    }
