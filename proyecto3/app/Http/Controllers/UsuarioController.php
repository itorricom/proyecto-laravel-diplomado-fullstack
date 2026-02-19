<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function login()
    {
        //$password = Hash::make('12345678');
        //echo $password;
        return view('auth.login');
    }
    public function verificarLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credenciales =[
            'email' => $request->email,
            'password' => $request->password,
            'estado' => 'S',
        ];

        if(Auth::attempt($credenciales)){

            $usuario = Auth::user();
            $data_session = [
                'status' => true,
                'nombre' => $usuario->username,
                'mensaje' => 'Bienvenido al sistema',
            ];

            Session::put('data_session', $data_session);

            return redirect()->intended('/dashboard');
        }
        return back()->withErrors([
            'email' => 'Las credenciales no son correctas o el usuario está bloqueado.',
        ]);
    }
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }

    public function verificador(){
        return "Prueba de entrada al sistema";
    }

    public function dashboard(){
        return view('dashboard');
    }
}
