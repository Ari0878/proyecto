<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserControllerApi extends Controller
{
    //-------------------   LISTA DE USUARIOS --------------------------------------------------------
    public function getUsers()
    {
        // Hacemos una solicitud GET a la API externa para obtener los usuarios
        $response = Http::get('http://localhost:3001/api/usuarios');
    
        if ($response->successful()) {
            $data = $response->json(); // Obtiene los datos en formato json
            return view('index', compact('data')); // Pasamos los datos a la vista
        } else {
            return redirect()->route('index')->with('error', 'Error al obtener los usuarios: ' . $response->json()['error']);
        }
    }

    //-------------------   CONSULTA DE USUARIO POR ID  ------------------------------------------------------
    public function getUserById($id_usuario)
{
    // Hacemos una solicitud GET a la API externa para obtener el usuario por ID
    $response = Http::get('http://localhost:3001/api/usuarios/' . $id_usuario);

    if ($response->successful()) {
        $data = $response->json(); // Obtiene los datos en formato json
        return view('show', compact('data')); // Pasamos los datos a la vista
    } else {
        return redirect()->route('index')->with('error', 'Error al obtener el usuario: ' . $response->json()['error']);
    }
}
    //-------------------   VISTA PARA CREAR UN NUEVO USUARIO ----------------------------------------
    public function createUser()
    {
        return view('createUser');
    }

//-------------------   FUNCION PARA REGISTRAR UN NUEVO USUARIO ----------------------------------------
public function updateUser(Request $request)
{
    // Validar los campos
    $validated = $request->validate([
        'nombre' => 'required|string',
        'apellido_paterno' => 'required|string',
        'apellido_materno' => 'required|string',
        'correo' => 'required|email',
        'PASSWORD' => 'required|string|min:6',
        'matricula' => 'required|string',
        'fecha_nacimiento' => 'required|date',
        'sexo' => 'required|string',
        'activo' => 'required|boolean',
        'rol_id' => 'required|integer', // Cambia "rol" por "rol_id"
    ]);

    // Realizar la solicitud POST al API para registrar el usuario
    $response = Http::post('http://localhost:3001/api/usuarios', $validated);

    // Verificar si la respuesta del API fue exitosa
    if ($response->successful()) {
        // Si es exitoso, redirigir al índice con mensaje de éxito
        return redirect()->route('index')->with('success', 'Usuario creado exitosamente.');
    } else {
        // Si no es exitoso, redirigir con un mensaje de error
        return redirect()->route('index')->with('error', 'Error al insertar el usuario.');
    }
}

    //-------------------   FUNCION PARA EDITAR UN USUARIO ----------------------------------------
    public function edit($id_usuario)
    {
        $response = Http::get('http://localhost:3001/api/usuarios/' . $id_usuario);

        if ($response->successful()) {
            $data = $response->json(); // Obtenemos los datos del usuario
            return view('edit', compact('data')); // Pasamos los datos a la vista
        } else {
            return response()->json(['error' => 'Error al obtener el usuario para editar'], 500);
        }
    }

    //-------------------   FUNCION PARA ACTUALIZAR UN USUARIO ----------------------------------------
    public function update(Request $request, $id_usuario)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'correo' => 'required|email',
            'PASSWORD' => 'required|string|min:6',
            'matricula' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|string',
            'activo' => 'required|boolean',
        ]);

        // Encriptar la nueva contraseña
        $validated['PASSWORD'] = Hash::make($validated['PASSWORD']);

        $response = Http::put('http://localhost:3001/api/usuarios/' . $id_usuario, $validated);

        if ($response->successful()) {
            return redirect()->route('index')->with('success', 'Usuario actualizado correctamente.');
        } else {
            return response()->json(['error' => 'Error al actualizar el usuario'], 500);
        }
    }

    //-------------------   FUNCION PARA ELIMINAR UN USUARIO ----------------------------------------
    public function destroy($id_usuario)
    {
        $response = Http::delete('http://localhost:3001/api/usuarios/' . $id_usuario);
    
        if ($response->successful()) {
            return redirect()->route('index')->with('success', 'Usuario eliminado correctamente.');
        } else {
            return redirect()->route('index')->with('error', 'Error al eliminar el usuario: ' . $response->json()['error']);
        }
    }
}
