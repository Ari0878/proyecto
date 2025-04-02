<!DOCTYPE html>
<html>
<head>
    <title>Lista de Usuarios</title>
</head>
<body>
    <h1>Lista de Usuarios</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>Fecha de Nacimiento</th>
                <th>Sexo</th>
                <th>Activo</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['nombre'] }}</td>
                    <td>{{ $item['apellido_paterno'] }}</td>
                    <td>{{ $item['apellido_materno'] }}</td>
                    <td>{{ $item['correo'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($item['fecha_nacimiento'])->format('d/m/Y') }}</td>
                    <td>
                        @if($item['sexo'] === 'masculino' || $item['sexo'] === 'Masculino')
                            Masculino
                        @elseif($item['sexo'] === 'femenino' || $item['sexo'] === 'Femenino')
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
        </tbody>
    </table>
</body>
</html>