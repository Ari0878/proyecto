<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetalleController extends Controller
{
    public function detalleData()
    {
        $response = Http::get('http://localhost:3001/api/detalle/');
        $data = $response->json();
        $data = array_map(function ($item) {
            return (array) $item; // Convert stdClass to array
        }, $data);
    
        // Fetch vehiculo data for each trayectoria
        foreach ($data as &$detalle) {
            $trayectoria = DB::table('trayectoria')->where('id', $detalle['trayectoria_id'])->first();
            $detalle['trayectoria'] = (array) $trayectoria; // Convert vehiculo to array
        }
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentData = array_slice($data, ($currentPage - 1) * $perPage, $perPage);

        $paginator = new LengthAwarePaginator(
            $currentData,
            count($data),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('detalle.detalleData', ['data' => $paginator]);
    }

    public function detallegetData2($id)
    {
        $response = Http::get('http://localhost:3001/api/detalle/' . $id);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['trayectoria_id'])) {
                $trayectoria = DB::table('trayectoria')->where('id', $data['trayectoria_id'])->first();
                return view('detalle.detallegetData2', compact('data', 'trayectoria'));
            } else {
                return back()->withErrors('No se encontró el vehículo asociado.');
            }
        } else {
            return back()->withErrors('Error al obtener el registro.');
        }
    }

    public function detalledeleteData($id)
    {
        $response = Http::delete('http://localhost:3001/api/detalle/' . $id);

        if ($response->successful()) {
            return redirect('/consultar-detalle')->with('message', 'Recurso eliminado correctamente');
        } else {
            return response()->json(['error' => 'Error al eliminar el recurso'], 500);
        }
    }

    public function detalleupdateData($id)
    {
        $response = Http::get('http://localhost:3001/api/detalle/' . $id);

        if ($response->successful()) {
            $data = $response->json();
            $trayectorias = DB::table('trayectoria')->get();
            return view('detalle.detalleupdateData', compact('data', 'trayectorias'));
        } else {
            return back()->withErrors(['error' => 'Error al obtener los datos para actualizar.']);
        }
    }

    public function detalleactualizar(Request $request, $id)
    {
        $request->validate([
            'latitud' => 'required',
            'longitud' => 'required',
            'altitud' => 'required',
            'descripcion' => 'required',
            'foto' => 'nullable|file|max:2048', // Acepta cualquier archivo de imagen válido
            'nombre_parada' => 'required',
            'hora_aprox' => 'required',
            'trayectoria_id' => 'required',
        ]);

        $currentUser = Http::get('http://localhost:3001/api/detalle/' . $id)->json();
        $img2 = $currentUser['foto'];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $img = $file->getClientOriginalName();
            $ldate = date('Ymd_His_');
            $img2 = $ldate . $img;
            $file->move(public_path('img'), $img2);
        }

        $response = Http::put('http://localhost:3001/api/detalle/' . $id, [
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'altitud' => $request->altitud,
            'descripcion' => $request->descripcion,
            'foto' => $img2,
            'nombre_parada' => $request->nombre_parada,
            'hora_aprox' => $request->hora_aprox,
            'trayectoria_id' => $request->trayectoria_id,
        ]);

        if ($response->successful()) {
            return redirect('/consultar-detalle')->with('success', 'Registro actualizado correctamente');
        } else {
            return back()->withErrors(['error' => 'Error al actualizar el registro.']);
        }
    }

    public function detallepostData(Request $request)
    {
        if ($request->isMethod('get')) {
            $trayectorias = DB::table('trayectoria')->get();
            return view('detalle.detallepostData', compact('trayectorias'));
        }

        $request->validate([
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'altitud' => 'required|numeric',
            'descripcion' => 'required|string',
            'foto' => 'nullable|file|max:2048', // Acepta cualquier tipo de imagen
            'nombre_parada' => 'required|string',
            'hora_aprox' => 'required',
            'trayectoria_id' => 'required|exists:trayectoria,id',
        ]);

        $img2 = 'logo_utvt.png';
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $img = $file->getClientOriginalName();
            $ldate = date('Ymd_His_');
            $img2 = $ldate . $img;
            $file->move(public_path('img'), $img2);
        }

        $response = Http::post('http://localhost:3001/api/detalle/', [
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'altitud' => $request->altitud,
            'descripcion' => $request->descripcion,
            'foto' => $img2,
            'nombre_parada' => $request->nombre_parada,
            'hora_aprox' => $request->hora_aprox,
            'trayectoria_id' => $request->trayectoria_id,
        ]);

        if ($response->successful()) {
            return redirect()->route('consultar-detalle')->with('success', 'Registro creado correctamente');
        } else {
            return back()->withErrors(['error' => 'Error al crear el registro.']);
        }
    }

    public function showForm()
    {
        $trayectorias = DB::table('trayectoria')->get();
        return view('detalle.detallepostData', compact('trayectorias'));
    }
}
