<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() 
    {
    if (!auth()->check()) {
        return redirect()->route('login.show'); // Redirect to the login page if the user is not authenticated
      }
    // Redirect to the newsfeed/home page if the user is authenticated
    return redirect()->route('newsfeed.home');
      }
    }
