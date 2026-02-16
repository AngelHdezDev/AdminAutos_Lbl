<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'correo' => ['required', 'email'],
            'contra' => ['required'],
        ]);

      
        $authData = [
            'correo' => $credentials['correo'],
            'password' => $credentials['contra'], 
        ];

        
        if (Auth::attempt($authData)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

     
        return back()->withErrors([
            'correo' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }
}