<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;

class PdfController extends Controller
{
    public function generarPdf()
    {
        // Obtén los datos de la base de datos o de la API
        $data = Http::get('http://localhost:3001/api/usuarios')->json();

        // Genera el PDF
        $pdf = Pdf::loadView('pdf.usuarios', compact('data'));

        // Descarga el PDF
        return $pdf->download('usuarios.pdf');
    }

    public function generarPdfvehiculo()
    {

        $data = Http::get('http://localhost:3001/api/vehiculo')->json();

        $pdf = Pdf::loadView('pdf.vehiculo', compact('data'));
    
        return $pdf->download('vehiculo.pdf');
    }

    public function generarPdftrayectoria()
    {

        $data = Http::get('http://localhost:3001/api/trayectoria')->json();

        $pdf = Pdf::loadView('pdf.trayectoria', compact('data'));
    
        return $pdf->download('trayectoria.pdf');
    }

    public function generarPdfsensor()
    {

        $data = Http::get('http://localhost:3001/api/sensor')->json();

        $pdf = Pdf::loadView('pdf.sensor', compact('data'));
    
        return $pdf->download('sensor.pdf');
    }

    public function generarPdfmantenimiento()
    {

        $data = Http::get('http://localhost:3001/api/mantenimiento')->json();

        $pdf = Pdf::loadView('pdf.mantenimiento', compact('data'));
    
        return $pdf->download('mantenimiento.pdf');
    }

    public function generarPdfdetalle()
    {

        $data = Http::get('http://localhost:3001/api/detalle')->json();

        $pdf = Pdf::loadView('pdf.detalle', compact('data'))
          ->setPaper('A4', 'landscape');  // Establecer tamaño A4 y orientación horizontal

        return $pdf->download('detalle.pdf');
        
    }
}