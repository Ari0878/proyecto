<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;  // Usamos Http para enviar solicitudes a tu API de Node.js

class LoginController extends Controller
{
    // Función para mostrar la vista de login
    public function showLoginForm()
    {
        return view('login');  // Redirige a la vista de login
    }

// Función para manejar el login (POST)
public function login(Request $request)
{
    // Validar los datos recibidos
    $request->validate([
        'correo' => 'required|email',       // Validar que el correo tenga formato de email
        'PASSWORD' => 'required',           // Validar que la contraseña esté presente
    ]);

    // Enviar una solicitud POST a tu API de Node.js para hacer login
    $response = Http::post('http://localhost:3001/api/login', [
        'correo' => $request->correo,
        'PASSWORD' => $request->PASSWORD,
    ]);

    // Manejar la respuesta de la API
    if ($response->successful()) {
        // Si el login es exitoso, redirigir o mostrar mensaje
        return redirect()->route('login_success')->with('message', 'Login exitoso');
    } else {
        // Si el login falla, manejar el error de intento fallido o bloqueo
        $error = $response->json()['error'];

        // Verificar si el error es debido a un bloqueo temporal
        if (strpos($error, 'bloqueada temporalmente') !== false) {
            // Si el error es un bloqueo, devolver un mensaje específico
            return back()->with('error', '¡Tu cuenta está bloqueada!');  // Cambié con 'error' para usarlo en la vista
        }

        // Si no es bloqueo, es un error de contraseña incorrecta u otro
        return back()->withErrors(['error' => $error]);
    }
}


    // Función para mostrar mensaje de éxito después del login
    public function loginSuccess()
    {
        return view('login_success');  // Vista que muestra el mensaje de éxito
    }
}
