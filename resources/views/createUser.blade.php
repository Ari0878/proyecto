<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0a3d2d, #154c3c);
            color: #fff;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            margin-top: 50px;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h2 {
            font-size: 28px;
            color: #154c3c;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        .form-group input, .form-group select {
            border-radius: 6px;
            padding: 10px;
            font-size: 16px;
            color: #333;
            border: 2px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: #154c3c;
            box-shadow: 0 0 5px rgba(21, 76, 60, 0.4);
        }

        .btn-primary {
            background-color: #154c3c;
            color: white;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 6px;
            transition: background-color 0.3s, transform 0.3s;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #1e6951;
            transform: scale(1.05);
        }

        .alert {
            font-size: 16px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Crear Nuevo Usuario</h2>

        <!-- Mensajes de éxito o error -->
        <div id="alert" class="alert d-none" role="alert"></div>

        <form action="{{ route('updateUser') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido_paterno">Apellido Paterno</label>
                <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
            </div>
            <div class="form-group">
                <label for="apellido_materno">Apellido Materno</label>
                <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="PASSWORD">Contraseña</label>
                <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" required minlength="6">
            </div>
            <div class="form-group">
                <label for="matricula">Matrícula</label>
                <input type="text" class="form-control" id="matricula" name="matricula" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>



            <div class="form-group">
    <label for="sexo">Sexo</label>
    <select class="form-control" id="sexo" name="sexo" required>
        <option value="M">Masculino</option>
        <option value="F">Femenino</option>
    </select>
</div>

            <div class="form-group">
                <label for="activo">Activo</label>
                <select class="form-control" id="activo" name="activo" required>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>

            <!-- Campo para seleccionar el rol -->
            <div class="form-group">
                <label for="rol">Rol</label>
                <select class="form-control" id="rol" name="rol" required>
                    <option value="Administrador">Administrador</option>
                    <option value="Estudiante">Estudiante</option>
                    <option value="Conductor">Conductor</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Registrar Usuario</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <script>
        // Manejo de los mensajes de éxito o error
        @if(session('success'))
            $('#alert').removeClass('d-none').addClass('alert-success').text("{{ session('success') }}");
        @elseif(session('error'))
            $('#alert').removeClass('d-none').addClass('alert-danger').text("{{ session('error') }}");
        @endif
    </script>
</body>

</html>
