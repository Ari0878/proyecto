<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Http\Request;

class TrayectoriaController extends Controller
{
    public function trayData(Request $request)
    {
        // Fetch data from the API
        $response = Http::get('http://localhost:3001/api/trayectoria/');
        $data = $response->json(); // Decode JSON response
    
        // Convert each item in the data to an array
        $data = array_map(function ($item) {
            return (array) $item; // Convert stdClass to array
        }, $data);
    
        // Fetch vehiculo data for each trayectoria
        foreach ($data as &$trayectoria) {
            $vehiculo = DB::table('vehiculo')->where('id', $trayectoria['vehiculo_id'])->first();
            $trayectoria['vehiculo'] = (array) $vehiculo; // Convert vehiculo to array
        }
    
        // Paginate the data
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentData = array_slice($data, ($currentPage - 1) * $perPage, $perPage);
    
        // Create the paginator
        $paginator = new LengthAwarePaginator(
            $currentData,
            count($data),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    
        // Pass the paginated data to the view
        return view('trayectoria.trayData', ['data' => $paginator]);
    }
    


public function traygetData2($id)
{
    // Fetch data from the API
    $response = Http::get('http://localhost:3001/api/trayectoria/' . $id);

    // Check if the request was successful
    if ($response->successful()) {
        $data = $response->json();

        // Ensure vehiculo_id exists in the response
        if (isset($data['vehiculo_id'])) {
            $vehiculo = DB::table('vehiculo')->where('id', $data['vehiculo_id'])->first();
            return view('trayectoria.traygetData2', compact('data', 'vehiculo'));
        } else {
            return back()->withErrors('No se encontró el vehículo asociado.');
        }
    } else {
        return back()->withErrors('Error al obtener el registro.');
    }
}


    public function traydeleteData($id)
    {
        // Hacemos una solicitud DELETE a la API para eliminar el recurso
        $response = Http::delete('http://localhost:3001/api/trayectoria/' . $id);

        // Verificamos si la solicitud fue exitosa
        if ($response->successful()) {
            return redirect('/consultar-tray')->with('message', 'Recurso eliminado correctamente');
        } else {
            return response()->json(['error' => 'Error al eliminar el recurso'], 500);
        }
    }

    public function trayupdateData($id)
    {
        // Obtener los datos actuales de la API
        $response = Http::get('http://localhost:3001/api/trayectoria/' . $id);
    
        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            // Obtener los datos de la trayectoria
            $data = $response->json();
    
            // Obtener todos los vehículos
            $vehiculos = DB::table('vehiculo')->get();
    
            // Retornar la vista con los datos de la trayectoria y los vehículos
            return view('trayectoria.trayupdateData', compact('data', 'vehiculos'));
        } else {
            // Si no se encuentra el recurso
            return back()->withErrors(['error' => 'Error al obtener los datos para actualizar.']);
        }
    }

    // Método para procesar la actualización
    public function trayactualizar(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'hora_inicio' => 'required',
            'ruta_inicio' => 'required',
            'ruta_final' => 'required',
            'hora_final' => 'required',
            'vehiculo_id' => 'required|exists:vehiculo,id', // Ensure vehiculo_id is required and exists
        ]);
    
        // Enviar los datos a la API para actualizar
        $response = Http::put('http://localhost:3001/api/trayectoria/' . $id, [
            'hora_inicio' => $request->hora_inicio,
            'ruta_inicio' => $request->ruta_inicio,
            'ruta_final' => $request->ruta_final,
            'hora_final' => $request->hora_final,
            'vehiculo_id' => $request->vehiculo_id, // Include vehiculo_id in the request
        ]);
    
        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            return redirect()->route('consultar-tray')->with('success', 'Registro actualizado correctamente');
        } else {
            return back()->withErrors(['error' => 'Error al actualizar el registro.']);
        }
    }

    public function traypostData(Request $request)
{
    if ($request->isMethod('get')) {
        // Obtener todos los vehículos de la base de datos
        $vehiculos = DB::table('vehiculo')->get();
        return view('trayectoria.traypostData', compact('vehiculos'));
    }

    // Procesar la solicitud POST
    $request->validate([
        'hora_inicio' => 'required',
        'ruta_inicio' => 'required',
        'ruta_final' => 'required',
        'hora_final' => 'required',
        'vehiculo_id' => 'required|exists:vehiculo,id', // Validar que el vehiculo_id exista
    ]);

    // Enviar los datos a la API
    $response = Http::post('http://localhost:3001/api/trayectoria/', [
        'hora_inicio' => $request->hora_inicio,
        'ruta_inicio' => $request->ruta_inicio,
        'ruta_final' => $request->ruta_final,
        'hora_final' => $request->hora_final,
        'vehiculo_id' => $request->vehiculo_id, // Incluir vehiculo_id
    ]);

    // Verificar si la solicitud fue exitosa
    if ($response->successful()) {
        return redirect()->route('consultar-tray')->with('success', 'Registro creado correctamente');
    } else {
        return back()->withErrors(['error' => 'Error al crear el registro.']);
    }
}


    // Vista de formulario para crear un nuevo registro (cambia el nombre de la función)
    public function showForm() {

        $vehiculos = DB::table('vehiculo')->get(); // Obtener todos los usuarios de la tabla

        return view('trayectoria.traypostData', compact('vehiculos'));

    }
}
