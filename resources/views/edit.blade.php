<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>

<h1>Editar Usuario</h1>

<form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="{{ $usuario->nombre }}" required>
    </div>
    <div>
        <label for="apellido_paterno">Apellido Paterno:</label>
        <input type="text" name="apellido_paterno" id="apellido_paterno" value="{{ $usuario->apellido_paterno }}" required>
    </div>
    <div>
        <label for="apellido_materno">Apellido Materno:</label>
        <input type="text" name="apellido_materno" id="apellido_materno" value="{{ $usuario->apellido_materno }}" required>
    </div>
    <div>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" value="{{ $usuario->correo }}" required>
    </div>
    <div>
        <label for="PASSWORD">Contraseña:</label>
        <input type="password" name="PASSWORD" id="PASSWORD">
    </div>
    <div>
        <label for="matricula">Matrícula:</label>
        <input type="text" name="matricula" id="matricula" value="{{ $usuario->matricula }}" required>
    </div>
    <div>
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ $usuario->fecha_nacimiento }}" required>
    </div>
    <div>
        <label for="sexo">Sexo:</label>
        <select name="sexo" id="sexo" required>
            <option value="masculino" {{ $usuario->sexo == 'masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="femenino" {{ $usuario->sexo == 'femenino' ? 'selected' : '' }}>Femenino</option>
        </select>
    </div>
    <div>
        <label for="activo">Activo:</label>
        <input type="checkbox" name="activo" id="activo" {{ $usuario->activo ? 'checked' : '' }}>
    </div>
    <button type="submit">Actualizar Usuario</button>
</form>

</body>
</html>
