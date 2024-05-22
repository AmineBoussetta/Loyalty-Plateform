<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'string|required|email',
            'password' => 'string|required'
        ]);

        $userCredential = $request->only('email', 'password');
        if (Auth::attempt($userCredential)) {
            $route = $this->redirectDash();
            return redirect($route);
        } else {
            return back()->with('error', 'Username & Password is incorrect');
        }

    }
    public function index()
    {
        $route = $this->redirectDash();
        return redirect($route);
    }
    public function redirectDash()
    {
        $redirect = '';

        if (Auth::user() && Auth::user()->role == 1) {
            $redirect = 'home';
        } else if (Auth::user() && Auth::user()->role == 2) {
            $redirect = 'home_gerant';
        } else if (Auth::user() && Auth::user()->role == 3) {
            $redirect = 'home_caissier';
        }
        else if (Auth::user() && Auth::user()->role == 4) {
            $redirect = 'home_client';
        }

        return $redirect;
    }
}