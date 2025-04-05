<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulario de mantenimiento de Sensor">
    <title>Formulario de mantenimiento de Sensor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #154c3c;
            --primary-dark: #0a3d2d;
            --secondary-color: #12100e;
        }

        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin-top: 40px;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            font-size: 1.2rem;
            text-align: center;
            padding: 1rem;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card shadow">
            <div class="card-header">
                <i class="bi bi-car-front"></i> Formulario de mantenimiento de Sensor
            </div>
            <div class="card-body">
                <form action="{{ route('enviar.mantenimiento') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="observaciones" class="form-label">
                            <i class="bi bi-geo-alt-fill"></i> Observaciones
                        </label>
                        <input type="text" class="form-control" name="observaciones" id="observaciones" value="{{ old('observaciones') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="hora_fecha" class="form-label">
                            <i class="bi bi-alt"></i> hora_fecha
                        </label>
                        <input type="datetime-local" class="form-control" name="hora_fecha" id="hora_fecha" value="{{ old('hora_fecha') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="vehiculo_id" class="form-label">
                            <i class="bi bi-truck"></i> Vehículo
                        </label>
                        <select class="form-select" name="vehiculo_id" id="vehiculo_id" required>
                            <option value="">Seleccione un Vehículo</option>
                            @foreach ($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id }}" {{ old('vehiculo_id') == $vehiculo->id ? 'selected' : '' }}>
                                    {{ $vehiculo->modelo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Registrar
                        </button>
                        <a href="{{ url('consultar-mantenimiento') }}" class="btn btn-dark">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
