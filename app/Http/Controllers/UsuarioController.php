<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function verificarLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credenciales = [
            'email' => $request->email,
            'password' => $request->password,
            'estado' => 'A',
        ];

        if(Auth::guard('web')->attempt($credenciales)){
            $usuario = Auth::user();
            
            // Actualizar último acceso
            Usuario::where('id', $usuario->id)->update([
                'ultimo_acceso' => now()
            ]);

            $data_session = [
                'status' => true,
                'nombre' => $usuario->nombre ?? $usuario->username,
                'email' => $usuario->email,
                'mensaje' => 'Bienvenido al sistema',
            ];

            Session::put('data_session', $data_session);

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas o el usuario está inactivo.',
        ])->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
