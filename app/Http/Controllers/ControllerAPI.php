<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ControllerAPI extends Controller
{
   //-------------------   LISTA DE ALUMNOS --------------------------------------------------------
        public function getData()
        {
            //Hacemos una solicitud GET a una API externa
            $response = Http::get ('http://localhost:3001/api/registros/');

            //Verificamos si la solicitud fue exitosa
            if($response->successful()){
                $data = $response -> json();//Obtiene los datos en formatos json
                //return view ('getData')->with(['data' => $data]);
                return view ('getData', compact('data'));//Paasamos los datos a una vista
            }else{
                return response () -> json (['error' => "Error al construir la API"], 500);
            }
        }

     //-------------------   CONSULTA DE ALUMNOS POR ID  ------------------------------------------------------
        public function getData2($id_alumno)
        {
            //Hacemos una solicitud GET a una API externa
            $response = Http :: get('http://localhost:3001/api/registros/' .$id_alumno);
            //Verificamos si la solicitud fue exitosa
            if ($response -> successful()){
                $data = $response -> json (); //Obtiene los datos en formato json 
                //return view ('getData2')->with(['data' => $data]);
                return view ('getData2', compact('data'));//Paasamos los datos a una vista
            }else{
                    return response () -> json (['error' => "Error al contruir la API"], 500);
                }

        }

     //-------------------   VISTA DEL FORMULARIO DE ALUMNOS   ------------------------------------------------
        public function altaData(){
            return view('altaData');
        }
     //-------------------   FUNCION PARA REGISTRAR A UN NUEVO ALUMNO  ----------------------------------------
        public function postData(Request $request){
            $validated = $request->validate([
                'matricula' => 'required',
                'alumno' => 'required|string',
                'app' => 'required|string',
                'apm' => 'required|string',
                'grupo' => 'required|string',
                'email' => 'required|email',
                'fecha_nacimiento' => 'required|date',
                'sexo' => 'required|string',
                'activo' => 'required|boolean',
            ]);

            $response = Http::post('http://localhost:3001/api/registros/',$validated);

            if($response->successful()){
                return redirect('consultar-api');
            } else {
                return response()->json(['error'=> 'Error al insertar datos'], 500);
            }
        }

    //-------------------- Función para mostrar el formulario de edición con los datos del alumno
    public function editarData($id_alumno)
    {
        // Hacemos una solicitud GET para obtener los datos del alumno por su ID
        $response = Http::get('http://localhost:3001/api/registros/' . $id_alumno);

        // Verificamos si la solicitud fue exitosa
        if ($response->successful()) {
            $data = $response->json();  // Obtenemos los datos en formato json
            return view('editarData', compact('data'));  // Pasamos los datos a la vista de edición
        } else {
            return response()->json(['error' => "Error al obtener los datos del alumno"], 500);
        }
    }

    // -------------------Función para manejar la actualización del alumno
    public function updateData(Request $request, $id_alumno)
    {
        // Validamos los datos del formulario
        $validated = $request->validate([
            'matricula' => 'required',
            'alumno' => 'required|string',
            'app' => 'required|string',
            'apm' => 'required|string',
            'grupo' => 'required|string',
            'email' => 'required|email',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|string',
            'activo' => 'required|boolean',
        ]);

        // Hacemos una solicitud PUT a la API para actualizar el alumno
        $response = Http::put('http://localhost:3001/api/registros/' . $id_alumno, $validated);

        if ($response->successful()) {
            // Si la actualización es exitosa, redirigimos al listado de alumnos
            return redirect('consultar-api')->with('success', 'Alumno actualizado correctamente.');
        } else {
            return response()->json(['error' => 'Error al actualizar los datos del alumno'], 500);
        }
    }

    public function deleteData($id_alumno)
    {
        // Hacemos una solicitud DELETE a la API para eliminar el recurso
        $response = Http::delete('http://localhost:3001/api/registros/' . $id_alumno);
        
        // Verificamos si la solicitud fue exitosa
        if ($response->successful()) {
            // Redirigimos a la página de consulta con un mensaje de éxito
            return redirect('consultar-api')->with('success', 'Alumno eliminado correctamente.');
        } else {
            return redirect('consultar-api')->with('error', 'Error al eliminar al alumno');
        }
    }


}
   

