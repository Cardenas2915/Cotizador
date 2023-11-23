<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index(){

        if (auth()->check()) {
            // Si el usuario ya está autenticado, redirige a la página de inicio (o a donde desees)
            return redirect()->route('home')->with('mensaje', 'Ya estás autenticado');
        }

        return view('auth.login');
    }

    public function store(Request $request){

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!auth()->attempt($request->only('email', 'password'))){
            return back()->with('mensaje','Credenciales Incorrectas');
        }

        // Si el usuario viene de la página 'miCarrito', redirige de nuevo a esa página
        
        return back()->with('mensaje','Inicio de sesion exitoso!');
        
    }
}
