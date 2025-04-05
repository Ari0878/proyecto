<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class VehiculoController extends Controller
{
    public function getData(Request $request)
    {
        $response = Http::get('http://localhost:3001/api/vehiculo/');
        $data = $response->json(); // Asumimos que la respuesta es un array
    
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
        return view('vehiculo.getData', ['data' => $paginator]);
    }
    

    public function getData2($id)
    {
        try {
            $response = Http::get("http://localhost:3001/api/vehiculo/{$id}");
            if ($response->successful()) {
                $data = $response->json();
                return view('vehiculo.getData2', compact('data'));
            }
            return back()->withErrors('Error al obtener el registro.');
        } catch (\Exception $e) {
            return back()->withErrors('Error de conexión con la API.');
        }
    }

    public function deleteData($id)
    {
        try {
            $response = Http::delete("http://localhost:3001/api/vehiculo/{$id}");
            if ($response->successful()) {
                session()->flash('message', 'Recurso eliminado correctamente');
                return redirect('/consultar-vehi');
            }
            return response()->json(['error' => 'Error al eliminar el recurso'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error de conexión con la API'], 500);
        }
    }

    public function updateData($id)
    {
        try {
            $response = Http::get("http://localhost:3001/api/vehiculo/{$id}");
            if ($response->successful()) {
                $data = $response->json();
                return view('vehiculo.updateData', compact('data'));
            }
            return back()->withErrors(['error' => 'Error al obtener los datos para actualizar.']);
        } catch (\Exception $e) {
            return back()->withErrors('Error de conexión con la API.');
        }
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'modelo' => 'required',
            'placas' => 'required',
            'anio' => 'required|numeric',
            'anio_alta' => 'required|numeric',
            'tarjeta_circulacion' => 'required',
            'sedema' => 'required|in:Activo,Inactivo',
        ]);

        try {
            $response = Http::put("http://localhost:3001/api/vehiculo/{$id}", $request->only([
                'modelo', 'placas', 'anio', 'anio_alta', 'tarjeta_circulacion', 'sedema'
            ]));

            if ($response->successful()) {
                session()->flash('success', 'Registro actualizado correctamente');
                return redirect('/consultar-vehi');
            }
            return back()->withErrors(['error' => 'Error al actualizar el registro.']);
        } catch (\Exception $e) {
            return back()->withErrors('Error de conexión con la API.');
        }
    }

    public function postData(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('vehiculo.postData');
        }

        $request->validate([
            'modelo' => 'required',
            'placas' => 'required',
            'anio' => 'required|numeric',
            'anio_alta' => 'required|numeric',
            'sedema' => 'required|in:Activo,Inactivo',
            'tarjeta_circulacion' => 'required',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        try {
            $response = Http::post('http://localhost:3001/api/vehiculo/', $request->only([
                'modelo', 'placas', 'anio', 'anio_alta', 'sedema', 'tarjeta_circulacion', 'usuario_id'
            ]));

            if ($response->successful()) {
                session()->flash('success', 'Registro creado correctamente');
                return redirect('/consultar-vehi');
            }
            return back()->withErrors(['error' => 'Error al crear el registro.']);
        } catch (\Exception $e) {
            return back()->withErrors('Error de conexión con la API.');
        }
    }

    public function showForm()
    {
        $usuarios = DB::table('usuarios')->get(); // Obtener todos los usuarios de la tabla

    return view('vehiculo.postData', compact('usuarios'));

    }
}
