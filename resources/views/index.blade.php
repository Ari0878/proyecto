<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <h3 class="text-center">📜 Lista de Alumnos 📜</h3>

        <!-- Botón Insertar Alumno -->
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('createUser') }}" class="btn btn-primary">Insertar Alumno</a>
        </div>
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('pdf.usuarios') }}" class="btn btn-primary">Generar PDF</a>
        </div>
        <!-- Tabla de Alumnos -->
        <div>
            
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Correo</th>
                        <th>Password</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Sexo</th>
                        <th>Activo</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data) && count($data) > 0)
                        @foreach($data as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['nombre'] }}</td>
                                <td>{{ $item['apellido_paterno'] }}</td>
                                <td>{{ $item['apellido_materno'] }}</td>
                                <td>{{ $item['correo'] }}</td>
                                <td>******</td> <!-- No mostrar la contraseña -->
                                <td>{{ \Carbon\Carbon::parse($item['fecha_nacimiento'])->format('d/m/Y') }}</td>
                                <td>
                                    @if($item['sexo'] == 'M')
                                        Masculino
                                    @elseif($item['sexo'] == 'F')
                                        Femenino
                                    @else
                                        Otro
                                    @endif
                                </td>
                                <td>
                                    @if($item['activo'] == 1)
                                        Sí
                                    @elseif($item['activo'] == 0)
                                        No
                                    @else
                                        Desconocido
                                    @endif
                                </td>
                                <td>
                                    @if($item['rol_id'] == 1)
                                        Administrador
                                    @elseif($item['rol_id'] == 2)
                                        Estudiante
                                    @elseif($item['rol_id'] == 3)
                                        Conductor
                                    @else
                                        Rol Desconocido
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10" class="text-center">No hay datos disponibles</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>