<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Editar Registro">
    <title>Editar sensor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

    <div class="container mt-5">

        <h2 class="mb-4">
            <i class="bi bi-pencil-square"></i> Editar sensor
        </h2>

        <!-- Formulario de actualización -->
        <form action="{{ url('/actualizar-sensor/' . $data['id']) }}" method="POST">
            @csrf
            @method('PUT') <!-- Esto convierte el formulario en una solicitud PUT -->
            
            <div class="form-group">
                <label for="latitud"><i class="bi bi-geo-alt"></i> Latitud</label>
                <input type="decimal" class="form-control" name="latitud" value="{{ $data['latitud'] }}">
            </div>
            
            <div class="form-group">
                <label for="longitud"><i class="bi bi-geo-alt"></i> Longitud</label>
                <input type="decimal" class="form-control" name="longitud" value="{{ $data['longitud'] }}">
            </div>
            
            <div class="form-group">
                <label for="altitud"><i class="bi bi-arrow-up-circle"></i> Altitud</label>
                <input type="decimal" class="form-control" name="altitud" value="{{ $data['altitud'] }}">
            </div>

            <div class="form-group">
    <label for="velocidad"><i class="bi bi-speedometer"></i> Velocidad</label>
    <input type="decimal" class="form-control" name="velocidad" value="{{ $data['velocidad'] }}">
</div>

            <div class="form-group">
                <label for="rumbo"><i class="bi bi-compass"></i> Rumbo</label>
                <input type="text" class="form-control" name="rumbo" value="{{ $data['rumbo'] }}">
            </div>
            
            <div class="form-group">
                <label for="vehiculo_id"><i class="bi bi-car"></i> Vehículo</label>
                <select class="form-control" name="vehiculo_id" required>
                    <option value="">Seleccione un vehículo</option>
                    @foreach($vehiculos as $vehiculo)
                        <option value="{{ $vehiculo->id }}" {{ $data['vehiculo_id'] == $vehiculo->id ? 'selected' : '' }}>
                            {{ $vehiculo->modelo }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Actualizar
            </button>
            <a href="{{ url('/consultar-sensor') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Cancelar
            </a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
