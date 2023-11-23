<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    

    public function index(){

        if (auth()->check()) {
            // Si el usuario ya está registrado, redirige a la página de inicio 
            return redirect()->route('home')->with('mensaje', 'Ya estás registrado');
        }

        return view ('auth.register');
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|max:30',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|min:5|confirmed'
        ]);
        
        User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'cliente'
        ]);

        return redirect()->route('home')->with('mensaje', 'Registro Existoso');
    }
}
