<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Usuario</title>
</head>
<body>

<h1>Detalles del Usuario</h1>

<table>
    <tr>
        <th>ID</th>
        <td>{{ $usuario->id }}</td>
    </tr>
    <tr>
        <th>Nombre</th>
        <td>{{ $usuario->nombre }}</td>
    </tr>
    <tr>
        <th>Apellido Paterno</th>
        <td>{{ $usuario->apellido_paterno }}</td>
    </tr>
    <tr>
        <th>Apellido Materno</th>
        <td>{{ $usuario->apellido_materno }}</td>
    </tr>
    <tr>
        <th>Correo</th>
        <td>{{ $usuario->correo }}</td>
    </tr>
    <tr>
        <th>Matrícula</th>
        <td>{{ $usuario->matricula }}</td>
    </tr>
    <tr>
        <th>Fecha de Nacimiento</th>
        <td>{{ $usuario->fecha_nacimiento }}</td>
    </tr>
    <tr>
        <th>Sexo</th>
        <td>{{ $usuario->sexo }}</td>
    </tr>
    <tr>
        <th>Activo</th>
        <td>{{ $usuario->activo ? 'Sí' : 'No' }}</td>
    </tr>
</table>

</body>
</html>
