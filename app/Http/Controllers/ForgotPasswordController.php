<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ForgotPasswordMail;


class ForgotPasswordController extends Controller
{
    /**
     * Mostrar la vista con el formulario de olvido de contraseña.
     *
     * @return \Illuminate\View\View
     */
    public function getForgotPasswordForm()
    {
        // Mostrar la vista con el formulario
        return view('password');
    }

    /**
     * Procesar la solicitud de restablecimiento de contraseña.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLink(Request $request)
    {
        // Validar el correo electrónico
        $request->validate([
            'correo' => 'required|email',
        ]);

        $correo = $request->correo;

        // Hacer una solicitud POST a la API que tienes en Node.js
        $response = Http::post(env('API_URL'), [
            'correo' => $correo,
        ]);
        

        // Comprobar si la respuesta es exitosa
        if ($response->successful()) {
            return back()->with('message', 'Correo enviado. Revisa tu bandeja de entrada para restablecer la contraseña.');
        }

        // Si hubo un error en la API (por ejemplo, usuario no encontrado)
        $error = $response->json()['error'] ?? 'Error al procesar la solicitud';

        return back()->withErrors(['correo' => $error]);
    }

    public function resetPasswordForm()
    {
        // Mostrar la vista con el formulario
        return view('reset');
    }

    public function resetPassword(Request $request)
    {
        // Validar los datos
        $request->validate([
            'token' => 'required',
            'newPassword' => 'required|min:6',
        ]);
    
        // Obtener el token y la nueva contraseña del formulario
        $token = $request->token;
        $newPassword = $request->newPassword;
    
        // Hacer una solicitud POST a la API de Node.js para resetear la contraseña
        $response = Http::post(env('API_URL_RESET_PASSWORD'), [
            'token' => $token,
            'newPassword' => $newPassword,
        ]);
    
        // Comprobar si la respuesta es exitosa
        if ($response->successful()) {
            // Si la respuesta es exitosa, mostrar mensaje de éxito
            return back()->with('message', 'Contraseña actualizada exitosamente.');
        }
    
        // Si hubo un error en la API
        $error = $response->json()['error'] ?? 'Error al procesar la solicitud';
        return back()->withErrors(['error' => $error]);
    }
    
    

    
}
