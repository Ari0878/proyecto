<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Editar Registro">
    <title>Editar mantenimiento</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

    <div class="container mt-5">

        <h2 class="mb-4">
            <i class="bi bi-pencil-square"></i> Editar mantenimiento
        </h2>

        <!-- Alerta de errores -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de actualización -->
        <form action="{{ url('/actualizar-mantenimiento/' . $data['id']) }}" method="POST">
            @csrf
            @method('PUT') <!-- Esto convierte el formulario en una solicitud PUT -->
            
            <div class="form-group">
                <label for="observaciones"><i class="bi bi-geo-alt"></i> Observaciones</label>
                <input type="text" class="form-control" name="observaciones" id="observaciones" value="{{ old('observaciones', $data['observaciones']) }}">
            </div>
            
            <div class="form-group">
                <label for="hora_fecha"><i class="bi bi-geo-alt"></i> Hora Fecha</label>
                <input type="datetime-local" class="form-control" name="hora_fecha" id="hora_fecha" value="{{ old('hora_fecha', \Carbon\Carbon::parse($data['hora_fecha'])->format('Y-m-d\TH:i')) }}">
            </div>

            <div class="form-group">
                <label for="vehiculo_id"><i class="bi bi-car-front"></i> Vehículo</label>
                <select class="form-select" name="vehiculo_id" id="vehiculo_id" required>
                    <option value="">Seleccione un Vehículo</option>
                    @foreach ($vehiculos as $vehiculo)
                        <option value="{{ $vehiculo->id }}" {{ old('vehiculo_id', $data['vehiculo_id']) == $vehiculo->id ? 'selected' : '' }}>
                            {{ $vehiculo->modelo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Actualizar
            </button>
            <a href="{{ url('/consultar-mantenimiento') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Cancelar
            </a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
