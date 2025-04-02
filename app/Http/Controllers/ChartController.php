<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class VehiculoController extends Controller
{
    public function getData()
    {
        // Obtener datos de vehículos desde la API
        $client = new Client();
        $response = $client->get('http://tu-api.com/vehiculo'); // Cambia la URL por la de tu API
        $data = json_decode($response->getBody(), true);

        // Procesar los datos para la gráfica
        $chartData = $this->processVehicleDataForChart($data);

        // Pasar los datos a la vista
        return view('vehiculo.getData', [
            'data' => $data, // Datos para la tabla
            'chartData' => $chartData // Datos para la gráfica
        ]);
    }

    private function processVehicleDataForChart($data)
    {
        $processedData = [];

        // Contar vehículos por modelo
        foreach ($data as $vehicle) {
            if (!isset($processedData[$vehicle['modelo']])) {
                $processedData[$vehicle['modelo']] = 0;
            }
            $processedData[$vehicle['modelo']]++;
        }

        return $processedData;
    }
}