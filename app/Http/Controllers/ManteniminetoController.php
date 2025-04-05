<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ManteniminetoController extends Controller
{
    public function mantenimientoData()
    {
        // Obtener todos los datos de la API (sin paginación)
        $response = Http::get('http://localhost:3001/api/mantenimiento/');
        $data = $response->json(); // Asumimos que la respuesta es un array
    
        $data = array_map(function ($item) {
            return (array) $item; // Convert stdClass to array
        }, $data);
    
        // Fetch vehiculo data for each mantenimiento
        foreach ($data as &$mantenimiento) {
            $vehiculo = DB::table('vehiculo')->where('id', $mantenimiento['vehiculo_id'])->first();
            $mantenimiento['vehiculo'] = (array) $vehiculo; // Convert vehiculo to array
        }
        // Número de elementos por página
        $perPage = 5; // Puedes ajustar este valor según lo necesites
    
        // Número de la página actual (obtiene la página desde la URL)
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
    
        // Slice de los datos que se mostrarán en la página actual
        $currentData = array_slice($data, ($currentPage - 1) * $perPage, $perPage);
    
        // Crear el paginador
        $paginator = new LengthAwarePaginator(
            $currentData, // Los datos de la página actual
            count($data), // El total de los datos
            $perPage, // Elementos por página
            $currentPage, // Página actual
            ['path' => LengthAwarePaginator::resolveCurrentPath()] // Ruta para los enlaces de paginación
        );
    
        // Pasar los datos paginados a la vista
        return view('mantenimiento.mantenimientoData', ['data' => $paginator]);
    }
    
    
        public function mantenimientoData2($id){
            // Hacemos una solicitud GET a una API externa
            $response = Http::get('http://localhost:3001/api/mantenimiento/'. $id);
    
            
    
    
            // Verificamos si la solicitud fue exitosa
            if ($response->successful()) {
                $data = $response->json(); // Obtiene los datos en formato JSON
    
                if (isset($data['vehiculo_id'])) {
                    $vehiculo = DB::table('vehiculo')->where('id', $data['vehiculo_id'])->first();
                    return view('mantenimiento.mantenimientoData2', compact('data', 'vehiculo'));
                } else {
                    return back()->withErrors('No se encontró el vehículo asociado.');
                }
            } else {
                return back()->withErrors('Error al obtener el registro.');
            }
        }
    
        public function mantenimientodeleteData($id)
        {
            // Hacemos una solicitud DELETE a la API para eliminar el recurso
            $response = Http::delete('http://localhost:3001/api/mantenimiento/' . $id);
    
            // Verificamos si la solicitud fue exitosa
            if ($response->successful()) {
                return redirect('/consultar-mantenimiento')->with('message', 'Recurso eliminado correctamente');
            } else {
                return response()->json(['error' => 'Error al eliminar el recurso'], 500);
            }
        }
    
        public function mantenimientoupdateData($id)
    {
        // Obtener los datos actuales de la API
        $response = Http::get('http://localhost:3001/api/mantenimiento/' . $id);
    
        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            // Obtener los datos del mantenimiento
            $data = $response->json();
    
            // Obtener todos los vehículos
            $vehiculos = DB::table('vehiculo')->get();  // Obtén los vehículos disponibles
    
            // Retornar la vista con los datos del mantenimiento y los vehículos
            return view('mantenimiento.mantenimientoupdateData', compact('data', 'vehiculos'));
        } else {
            // Si no se encuentra el recurso
            return back()->withErrors(['error' => 'Error al obtener los datos para actualizar.']);
        }
    }
    
    
        // Método para procesar la actualización
        public function mantenimientoactualizar(Request $request, $id)
        {
            // Validar los datos del formulario
            $request->validate([
                'observaciones' => 'required',
                'hora_fecha' => 'required',
                'vehiculo_id' => 'required',
            ]);
        
            // Enviar los datos a la API para actualizar
            $response = Http::put('http://localhost:3001/api/mantenimiento/' . $id, [
                'observaciones' => $request->observaciones,
                'hora_fecha' => $request->hora_fecha,
                'vehiculo_id' => $request->vehiculo_id,
            ]);
        
            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                return redirect()->route('/consultar-mantenimiento')->with('success', 'Registro actualizado correctamente');
            } else {
                return back()->withErrors(['error' => 'Error al actualizar el registro.']);
            }
        }
    
        public function mantenimientopostData(Request $request)
    {
        if ($request->isMethod('get')) {
            // Mostrar el formulario para crear un nuevo registro
            return view('mantenimiento.mantenimientopostData');
        }
    
        // Procesar la solicitud POST
        $request->validate([
            'observaciones' => 'required',
            'hora_fecha' => 'required',
            'vehiculo_id' => 'required',
        ]);
        //dd($request->all());
        // Enviar los datos a la API
        $response = Http::post('http://localhost:3001/api/mantenimiento/', [
                'observaciones' => $request->observaciones,
                'hora_fecha' => $request->hora_fecha,
                'vehiculo_id' => $request->vehiculo_id,
        ]);
    
        if ($response->successful()) {
            return redirect()->route('/consultar-mantenimiento')->with('success', 'Registro creado correctamente');
        } else {
            return back()->withErrors(['error' => 'Error al crear el registro.']);
        }
    }
    
    
        // Vista de formulario para crear un nuevo registro (cambia el nombre de la función)
        public function showForm() {
    
            $vehiculos = DB::table('vehiculo')->get(); // Obtener todos los usuarios de la tabla
    
            return view('mantenimiento.mantenimientopostData', compact('vehiculos'));
    
        }
}
