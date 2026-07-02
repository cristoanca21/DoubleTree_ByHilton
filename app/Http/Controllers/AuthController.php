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
            
            /** @var \App\Models\Cliente $cliente */
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
        // 1. Validación estricta de datos
        $request->validate([
            'nombre'         => 'required|string|max:100',
            'apellido'       => 'required|string|max:100',
            'email'          => 'required|email|unique:clientes,email',
            'password'       => 'required|min:8|confirmed',
            'tipo_documento' => 'required|in:DNI,Pasaporte,Carnet de extranjería',
            'dni'            => 'required|string|max:20|unique:clientes,dni',
            // Restricción: Exige el símbolo +, de 1 a 4 dígitos de prefijo, un espacio, y luego entre 8 y 11 dígitos fijos
            'telefono'       => ['nullable', 'string', 'max:20', 'regex:/^\+\d{1,4}\s\d{8,11}$/'],
            'nacionalidad'   => 'required|string|max:100',
        ], [
            // 2. Mensajes de error personalizados para guiar al usuario
            'telefono.regex' => 'El formato del teléfono es inválido o excede la cantidad de dígitos del país seleccionado.',
            'dni.unique'     => 'Este número de documento ya se encuentra registrado.',
            'email.unique'   => 'Este correo electrónico ya está en uso en el sistema.'
        ]);

        // 3. Creación del registro en la base de datos MySQL
        $cliente = Cliente::create([
            'nombre'         => $request->nombre,
            'apellido'       => $request->apellido,
            'email'          => $request->email,
            'password'       => Hash::make($request->password), // Encriptación obligatoria para que el login funcione
            'tipo_documento' => $request->tipo_documento,
            'dni'            => $request->dni,
            'telefono'       => $request->telefono,
            'nacionalidad'   => $request->nacionalidad,
            'rol'            => 'cliente',
        ]);

        // 4. Autenticación automática tras el registro
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