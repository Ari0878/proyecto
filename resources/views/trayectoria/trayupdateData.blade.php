<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Editar Registro">
    <title>Editar Trayectoria</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">
            <i class="bi bi-pencil-square"></i> Editar Trayectoria
        </h2>

        <!-- Formulario de actualización -->
        <form action="{{ url('/actualizar-tray/' . $data['id']) }}" method="POST">
            @csrf
            @method('PUT') <!-- Esto convierte el formulario en una solicitud PUT -->
            
            <div class="form-group">
                <label for="hora_inicio"><i class="bi bi-car-front"></i> Hora de Inicio</label>
                <input type="time" class="form-control" name="hora_inicio" value="{{ $data['hora_inicio'] }}">
            </div>
            
            <div class="form-group">
                <label for="ruta_inicio"><i class="bi bi-card-checklist"></i> Ruta de Inicio</label>
                <input type="text" class="form-control" name="ruta_inicio" value="{{ $data['ruta_inicio'] }}">
            </div>
            
            <div class="form-group">
                <label for="ruta_final"><i class="bi bi-calendar"></i> Ruta Final</label>
                <input type="text" class="form-control" name="ruta_final" value="{{ $data['ruta_final'] }}">
            </div>

            <div class="form-group">
                <label for="hora_final"><i class="bi bi-calendar-check"></i> Hora Final</label>
                <input type="time" class="form-control" name="hora_final" value="{{ $data['hora_final'] }}">
            </div>

            <!-- Campo para seleccionar el vehículo -->
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
            <a href="{{ url('/consultar-tray') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Cancelar
            </a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>