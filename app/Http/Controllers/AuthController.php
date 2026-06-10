<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credenciales = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('cliente')->attempt($credenciales, $request->remember)) {
            $request->session()->regenerate();
            $cliente = Auth::guard('cliente')->user();

            if ($cliente->esAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('cliente.dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegistro()
    {
        return view('auth.registro');
    }

    public function registro(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:100',
            'apellido'      => 'required|string|max:100',
            'email'         => 'required|email|unique:clientes,email',
            'password'      => 'required|min:8|confirmed',
            'tipo_documento'  => 'required|string|max:20',
            'dni'           => 'required|string|max:20',
            'nacionalidad'  => 'required|string|max:100',
        ]);

        $cliente = Cliente::create([
            'nombre'       => $request->nombre,
            'apellido'     => $request->apellido,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'tipo_documento' => $request->tipo_documento,
            'dni'          => $request->dni,
            'nacionalidad' => $request->nacionalidad,
            'rol'          => 'cliente',
        ]);

        Auth::guard('cliente')->login($cliente);

        return redirect()->route('cliente.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('cliente')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}