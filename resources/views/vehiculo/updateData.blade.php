<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Editar Registro">
    <title>Editar Vehiculo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

    <div class="container mt-5">

        <h2 class="mb-4">
            <i class="bi bi-pencil-square"></i> Editar Vehiculo
        </h2>

        <!-- Formulario de actualización -->
        <form action="{{ url('/actualizar-vehi/' . $data['id']) }}" method="POST">
            @csrf
            @method('PUT') <!-- Esto convierte el formulario en una solicitud PUT -->
            
            <div class="form-group">
                <label for="modelo"><i class="bi bi-car-front"></i> Modelo</label>
                <input type="text" class="form-control" name="modelo" value="{{ $data['modelo'] }}">
            </div>
            
            <div class="form-group">
                <label for="placas"><i class="bi bi-card-checklist"></i> Placas</label>
                <input type="text" class="form-control" name="placas" value="{{ $data['placas'] }}">
            </div>
            
            <div class="form-group">
                <label for="anio"><i class="bi bi-calendar"></i> Año</label>
                <input type="number" class="form-control" name="anio" value="{{ $data['anio'] }}">
            </div>

            <div class="form-group">
                <label for="anio_alta"><i class="bi bi-calendar-check"></i> Año de Alta</label>
                <input type="number" class="form-control" name="anio_alta" value="{{ $data['anio_alta'] }}">
            </div>

            <div class="form-group">
                <label for="tarjeta_circulacion"><i class="bi bi-file-earmark-person"></i> Tarjeta de Circulación</label>
                <input type="text" class="form-control" name="tarjeta_circulacion" value="{{ $data['tarjeta_circulacion'] }}">
            </div>
            
            <div class="form-group">
                <label for="sedema"><i class="bi bi-toggle-on"></i> Sedema</label>
                <select class="form-control" name="sedema" id="sedema">
                    <option value="Activo" {{ $data['sedema'] == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ $data['sedema'] == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Actualizar
            </button>
            <a href="{{ url('/consultar-vehi') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Cancelar
            </a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
