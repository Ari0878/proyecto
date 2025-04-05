<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;



class ExcelController extends Controller
{
    public function showUploadForm()
    {
        return view('excel.upload'); // Ruta de la vista: resources/views/excel/upload.blade.php
    }

    public function upload(Request $request)
{
    // Validar que el archivo sea un Excel
    $validator = Validator::make($request->all(), [
        'file' => 'required|mimes:xlsx,xls',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Obtener el archivo
    $file = $request->file('file');

    try {
        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();

        // Definir los nombres de las columnas esperadas
        $expectedColumns = ['modelo', 'placas', 'anio', 'anio_alta', 'sedema', 'tarjeta_circulacion', 'usuario_id'];

        // Validar los nombres de las columnas
        $headerRow = [];
        foreach ($sheet->getRowIterator() as $row) {
            if (empty($headerRow)) {
                foreach ($row->getCellIterator() as $cell) {
                    $headerRow[] = $cell->getValue();
                }
                break; // Solo necesitamos la primera fila
            }
        }

        // Comparar las columnas
        if ($headerRow !== $expectedColumns) {
            return redirect()->back()->with('error', 'Los nombres de las columnas no coinciden con los esperados: ' . implode(', ', $expectedColumns));
        }

        // Recorrer las filas del archivo
        $data = [];
        $firstRow = true; // Bandera para omitir la primera fila

        foreach ($sheet->getRowIterator() as $row) {
            if ($firstRow) {
                $firstRow = false;
                continue; // Saltamos la primera fila (encabezados)
            }

            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }
            $data[] = $rowData;
        }

        // Validar que los datos no estén vacíos
        if (empty($data)) {
            return redirect()->back()->with('error', 'El archivo Excel está vacío o no tiene el formato correcto.');
        }

        // Enviar los datos a la API
        $response = Http::post('http://localhost:3001/api/endpoint', [
            'data' => $data,
        ]);

        if ($response->successful()) {
            // Guardar en la base de datos (tabla "vehiculo")
            $this->saveToDatabase($data);

            return redirect()->back()->with('success', 'Datos enviados y procesados correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al enviar los datos a la API: ' . $response->body());
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al procesar el archivo Excel: ' . $e->getMessage());
    }
}

    private function saveToDatabase($data)
    {
        foreach ($data as $row) {
            // Validar que la fila tenga suficientes columnas
            if (count($row) < 7) {
                continue; // Saltar filas incompletas
            }

            // Insertar los datos en la tabla "vehiculo"
            DB::table('vehiculo')->insert([
                'modelo'            => $row[0], 
                'placas'            => $row[1], 
                'anio'              => is_numeric($row[2]) ? intval($row[2]) : null, 
                'anio_alta'         => is_numeric($row[3]) ? intval($row[3]) : null, 
                'sedema'            => $row[4], 
                'tarjeta_circulacion' => $row[5], 
                'usuario_id'        => is_numeric($row[6]) ? intval($row[6]) : null, 
            ]);            
        }
    }


    ////////////////////////////Trayectoria//////////////////////////

    public function showUploadFormtray()
    {
        return view('excel.trayupload'); // Ruta de la vista: resources/views/excel/trayupload.blade.php
    }
    
    public function trayupload(Request $request)
    {
        // Validar que el archivo sea un Excel
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Obtener el archivo
        $file = $request->file('file');
    
        try {
            // Cargar el archivo Excel
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
    
            // Definir los nombres de las columnas esperadas
            $expectedColumns = ['hora_inicio', 'ruta_inicio', 'ruta_final', 'hora_final', 'vehiculo_id'];
    
            // Validar los nombres de las columnas
            $headerRow = [];
            foreach ($sheet->getRowIterator() as $row) {
                if (empty($headerRow)) {
                    foreach ($row->getCellIterator() as $cell) {
                        $headerRow[] = $cell->getValue();
                    }
                    break; // Solo necesitamos la primera fila
                }
            }
    
            // Comparar las columnas
            if ($headerRow !== $expectedColumns) {
                return redirect()->back()->with('error', 'Los nombres de las columnas no coinciden con los esperados: ' . implode(', ', $expectedColumns));
            }
    
            // Recorrer las filas del archivo
            $data = [];
            $firstRow = true; // Bandera para omitir la primera fila
    
            foreach ($sheet->getRowIterator() as $row) {
                if ($firstRow) {
                    $firstRow = false;
                    continue; // Saltamos la primera fila (encabezados)
                }
    
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }
    
            // Validar que los datos no estén vacíos
            if (empty($data)) {
                return redirect()->back()->with('error', 'El archivo Excel está vacío o no tiene el formato correcto.');
            }
    
            // Enviar los datos a la API
            $response = Http::post('http://localhost:3001/api/trayectoria-endpoint', [
                'data' => $data,
            ]);
    
            if ($response->successful()) {
                // Guardar en la base de datos (tabla "vehiculo")
                $this->traysaveToDatabase($data);
    
                return redirect()->back()->with('success', 'Datos enviados y procesados correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al enviar los datos a la API: ' . $response->body());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar el archivo Excel: ' . $e->getMessage());
        }
    }

    
    private function traysaveToDatabase($data)
    {
        foreach ($data as $row) {
            // Validar que la fila tenga suficientes columnas
            if (count($row) < 5) { // Cambiado a 5 porque solo necesitamos 5 columnas
                continue; // Saltar filas incompletas
            }
    
            // Insertar los datos en la tabla "trayectoria"
            DB::table('trayectoria')->insert([
                'hora_inicio'    => !empty($row[0]) ? $row[0] : '00:00:00',  // Valor por defecto si está vacío (asegúrate de usar formato TIME)
                'ruta_inicio'    => !empty($row[1]) ? $row[1] : 'Desconocida', // Valor por defecto si está vacío
                'ruta_final'     => !empty($row[2]) ? $row[2] : 'Desconocida', // Valor por defecto si está vacío
                'hora_final'     => !empty($row[0]) ? $row[0] : '00:00:00',  // Validar formato TIME, valor por defecto si es inválido
                'vehiculo_id'     => isset($row[4]) && is_numeric($row[4]) ? intval($row[4]) : 0,  // Validar que sea numérico
            ]);            
        }
    }


    ////////////////////////////Sensor///////////////////////////////


    public function showUploadFormsensor()
    {
        return view('excel.sensorupload'); // Ruta de la vista: resources/views/excel/trayupload.blade.php
    }
    
    public function sensorupload(Request $request)
    {
        // Validar que el archivo sea un Excel
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Obtener el archivo
        $file = $request->file('file');
    
        try {
            // Cargar el archivo Excel
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
    
            // Definir los nombres de las columnas esperadas
            $expectedColumns = ['latitud', 'longitud', 'altitud', 'velocidad','rumbo', 'vehiculo_id'];
    
            // Validar los nombres de las columnas
            $headerRow = [];
            foreach ($sheet->getRowIterator() as $row) {
                if (empty($headerRow)) {
                    foreach ($row->getCellIterator() as $cell) {
                        $headerRow[] = $cell->getValue();
                    }
                    break; // Solo necesitamos la primera fila
                }
            }
    
            // Comparar las columnas
            if ($headerRow !== $expectedColumns) {
                return redirect()->back()->with('error', 'Los nombres de las columnas no coinciden con los esperados: ' . implode(', ', $expectedColumns));
            }
    
            // Recorrer las filas del archivo
            $data = [];
            $firstRow = true; // Bandera para omitir la primera fila
    
            foreach ($sheet->getRowIterator() as $row) {
                if ($firstRow) {
                    $firstRow = false;
                    continue; // Saltamos la primera fila (encabezados)
                }
    
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }
    
            // Validar que los datos no estén vacíos
            if (empty($data)) {
                return redirect()->back()->with('error', 'El archivo Excel está vacío o no tiene el formato correcto.');
            }
    
            // Enviar los datos a la API
            $response = Http::post('http://localhost:3001/api/sensor-endpoint', [
                'data' => $data,
            ]);
    
            if ($response->successful()) {
                // Guardar en la base de datos (tabla "vehiculo")
                $this->sensorsaveToDatabase($data);
    
                return redirect()->back()->with('success', 'Datos enviados y procesados correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al enviar los datos a la API: ' . $response->body());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar el archivo Excel: ' . $e->getMessage());
        }
    }
    
    private function sensorsaveToDatabase($data)
    {
        foreach ($data as $row) {
            // Validar que la fila tenga suficientes columnas
            if (count($row) < 6) { // Cambiado a 5 porque solo necesitamos 5 columnas
                continue; // Saltar filas incompletas
            }
    
            // Insertar los datos en la tabla "sensor"
            DB::table('sensor')->insert([
                'latitud'      => isset($row[0]) && is_numeric($row[0]) ? floatval($row[0]) : 0.0, // Validar que sea decimal
                'longitud'     => isset($row[1]) && is_numeric($row[1]) ? floatval($row[1]) : 0.0, // Validar que sea decimal
                'altitud'      => isset($row[2]) && is_numeric($row[2]) ? floatval($row[2]) : 0.0, // Validar que sea decimal
                'velocidad'    => isset($row[3]) && is_numeric($row[3]) ? floatval($row[3]) : 0.0, // Validar que sea decimal
                'rumbo'        => !empty($row[4]) ? $row[4] : 'Desconocido', // Validar que no esté vacío (VARCHAR)
                'vehiculo_id'  => isset($row[5]) && is_numeric($row[5]) ? intval($row[5]) : 0, // Validar que sea BIGINT
            ]);                    
        }
    }


    ///////////////////////////Mantenimiento-Sensor////////////////////////////////////




    public function showUploadFormdetalle()
    {
        return view('excel.mantenimientoupload'); // Ruta de la vista: resources/views/excel/trayupload.blade.php
    }
    
    public function mantenimientoupload(Request $request)
    {
        // Validar que el archivo sea un Excel
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Obtener el archivo
        $file = $request->file('file');
    
        try {
            // Cargar el archivo Excel
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
    
            // Definir los nombres de las columnas esperadas
            $expectedColumns = ['observaciones', 'hora_fecha', 'vehiculo_id'];
    
            // Validar los nombres de las columnas
            $headerRow = [];
            foreach ($sheet->getRowIterator() as $row) {
                if (empty($headerRow)) {
                    foreach ($row->getCellIterator() as $cell) {
                        $headerRow[] = $cell->getValue();
                    }
                    break; // Solo necesitamos la primera fila
                }
            }
    
            // Comparar las columnas
            if ($headerRow !== $expectedColumns) {
                return redirect()->back()->with('error', 'Los nombres de las columnas no coinciden con los esperados: ' . implode(', ', $expectedColumns));
            }
    
            // Recorrer las filas del archivo
            $data = [];
            $firstRow = true; // Bandera para omitir la primera fila
    
            foreach ($sheet->getRowIterator() as $row) {
                if ($firstRow) {
                    $firstRow = false;
                    continue; // Saltamos la primera fila (encabezados)
                }
    
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }
    
            // Validar que los datos no estén vacíos
            if (empty($data)) {
                return redirect()->back()->with('error', 'El archivo Excel está vacío o no tiene el formato correcto.');
            }
    
            // Enviar los datos a la API
            $response = Http::post('http://localhost:3001/api/mantenimiento-endpoint', [
                'data' => $data,
            ]);
    
            if ($response->successful()) {
                // Guardar en la base de datos (tabla "vehiculo")
                $this->mantenimientosaveToDatabase($data);
    
                return redirect()->back()->with('success', 'Datos enviados y procesados correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al enviar los datos a la API: ' . $response->body());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar el archivo Excel: ' . $e->getMessage());
        }
    }
    
    private function mantenimientosaveToDatabase($data)
    {
        foreach ($data as $row) {
            // Validar que la fila tenga suficientes columnas
            if (count($row) < 6) { // Cambiado a 5 porque solo necesitamos 5 columnas
                continue; // Saltar filas incompletas
            }
    
            DB::table('mantenimiento')->insert([
                'observaciones' => !empty($row[0]) ? $row[0] : 'Sin observaciones',
                'hora_fecha'    => !empty($row[1]) ? $row[1] : now(),
                'vehiculo_id'   => isset($row[2]) && is_numeric($row[2]) ? intval($row[2]) : 0,
            ]);                   
        }
    }
    ////////////////////////////////Detalles///////////////////////////////////
    public function detalleshowUploadForm()
    {
        return view('excel.detalleupload'); // Ruta de la vista
    }

    public function detalleupload(Request $request)
    {
        // Validar que el archivo sea un Excel
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtener el archivo
        $file = $request->file('file');

        try {
            // Cargar el archivo Excel
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();

            // Definir los nombres de las columnas esperadas
            $expectedColumns = ['latitud', 'longitud', 'altitud', 'descripcion', 'foto', 'nombre_encuentro', 'hora_aproximada', 'trayectoria_id'];

            // Validar los nombres de las columnas
            $headerRow = [];
            foreach ($sheet->getRowIterator() as $row) {
                if (empty($headerRow)) {
                    foreach ($row->getCellIterator() as $cell) {
                        $headerRow[] = $cell->getValue();
                    }
                    break; // Solo necesitamos la primera fila
                }
            }

            // Comparar las columnas
            if ($headerRow !== $expectedColumns) {
                return redirect()->back()->with('error', 'Los nombres de las columnas no coinciden con los esperados: ' . implode(', ', $expectedColumns));
            }

            // Recorrer las filas del archivo
            $data = [];
            $firstRow = true; // Bandera para omitir la primera fila

            foreach ($sheet->getRowIterator() as $row) {
                if ($firstRow) {
                    $firstRow = false;
                    continue; // Saltamos la primera fila (encabezados)
                }

                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }

            // Validar que los datos no estén vacíos
            if (empty($data)) {
                return redirect()->back()->with('error', 'El archivo Excel está vacío o no tiene el formato correcto.');
            }

            // Enviar los datos a la API
            $response = Http::post('http://localhost:3001/api/detalle-endpoint', [
                'data' => $data,
            ]);

            if ($response->successful()) {
                // Guardar los datos en la base de datos
                $this->detallesaveToDatabase($data);

                return redirect()->back()->with('success', 'Datos enviados y procesados correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al enviar los datos a la API: ' . $response->body());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar el archivo Excel: ' . $e->getMessage());
        }
    }

    private function detallesaveToDatabase($data)
{
    DB::beginTransaction();  // Iniciar transacción

    try {
        foreach ($data as $row) {
            // Validar que la fila tenga suficientes columnas
            if (count($row) < 9) { // Cambiado a 9 porque ahora tenemos 9 columnas
                continue; // Saltar filas incompletas
            }

            // Aquí almacenamos el nombre de la imagen (asumimos que ya está en formato JPEG)
            $imageName = $this->getImageName(!empty($row[4]) ? $row[4] : null);

            // Insertar los datos en la base de datos
            DB::table('detalle')->insert([
                'latitud'          => !empty($row[0]) ? $row[0] : null,
                'longitud'         => !empty($row[1]) ? $row[1] : null,
                'altitud'          => !empty($row[2]) ? $row[2] : null,
                'descripcion'      => !empty($row[3]) ? $row[3] : 'Sin descripción',
                'foto'             => $imageName, // Guardar solo el nombre de la imagen (en formato JPEG)
                'nombre_encuentro' => !empty($row[5]) ? $row[5] : 'Sin nombre de encuentro',
                'hora_aproximada'  => !empty($row[6]) ? $row[6] : now(), // Si hora_aproximada está vacía, usar la hora actual
                'trayectoria_id'   => isset($row[7]) && is_numeric($row[7]) ? intval($row[7]) : null, // Asegurarse de que trayectoria_id es válido
            ]);
        }

        DB::commit();  // Confirmar la transacción si todo va bien
    } catch (\Exception $e) {
        DB::rollback();  // Revertir los cambios si ocurre un error
        throw $e;  // Lanzar la excepción para manejarla más tarde
    }
}

// Función para obtener solo el nombre de la imagen
private function getImageName($imagePath)
{
    // Si la ruta de la imagen no es válida o está vacía, retornar un valor por defecto
    if (empty($imagePath) || !file_exists(public_path('images/' . $imagePath))) {
        return 'sin_imagen.jpg'; // Valor predeterminado si no se encuentra la imagen
    }

    // Extraer solo el nombre del archivo (sin la ruta completa)
    return basename($imagePath);
}
}