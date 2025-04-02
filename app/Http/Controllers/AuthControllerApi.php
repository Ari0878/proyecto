<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthControllerApi extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // Muestra el formulario de login
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'correo' => 'required|email',
            'PASSWORD' => 'required|string|min:6',
        ]);

        // Realizamos la solicitud a la API externa para el login
        $response = Http::post('http://localhost:3001/api/login', $validated);

        // Depuración: Ver la respuesta de la API externa
        dd($response->json());  // Comenta esta línea cuando ya no la necesites

        if ($response->successful()) {
            // Si el login es exitoso, redirigimos a la página de usuarios
            return redirect()->route('altaUsers')->with('success', 'Login exitoso');
        } else {
            // Si el login falla, volvemos a la página de login con un error
            return redirect()->route('login')->with('error', 'Correo o contraseña incorrectos');
        }
    }

    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['correo' => 'required|email']);

        // Realizamos la solicitud a la API externa para enviar el código de verificación
        $response = Http::post('http://localhost:3001/api/forgot-password', [
            'correo' => $request->correo,
        ]);

        if ($response->successful()) {
            Session::flash('message', 'Correo enviado. Revisa tu bandeja de entrada para obtener el código de verificación.');
            return redirect()->route('password.reset', ['correo' => $request->correo]);
        } else {
            return redirect()->back()->withErrors(['correo' => $response->json()['error']]);
        }
    }

    public function showResetPasswordForm(Request $request, $correo)
    {
        return view('auth.passwords.reset', ['correo' => $correo]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'reset_code' => 'required|digits:6',
            'password' => 'required|confirmed|min:8',
        ]);

        // Realizamos la solicitud a la API externa para restablecer la contraseña
        $response = Http::post('http://localhost:3001/api/reset-password', [
            'correo' => $request->correo,
            'resetCode' => $request->reset_code,
            'newPassword' => $request->password,
        ]);

        if ($response->successful()) {
            Session::flash('message', 'Contraseña actualizada exitosamente.');
            return redirect()->route('login');
        } else {
            return redirect()->back()->withErrors(['reset_code' => $response->json()['error']]);
        }
    }
}