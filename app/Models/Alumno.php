<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
   

    // Nombre de la tabla
    protected $table = 'alumno';

    // Definir la clave primaria explícitamente
    protected $primaryKey = 'id_alumno';

    // Si tu clave primaria no es autoincremental, puedes desactivar el auto incremento:
    // public $incrementing = false;

    // Definir los campos que pueden ser llenados masivamente
    protected $fillable = [
        'matricula',
        'alumno',
        'app',
        'apm',
        'grupo',
        'email',
        'fecha_nacimiento',
        'sexo',
        'activo',
    ];
    
    // Campos que deben ser tratados como booleanos
    protected $casts = [
        'activo' => 'boolean',
    ];
}
