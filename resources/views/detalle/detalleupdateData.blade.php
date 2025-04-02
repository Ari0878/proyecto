<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Editar Registro">
    <title>Editar detalles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

    <div class="container mt-5">
        <h2 class="mb-4">
            <i class="bi bi-pencil-square"></i> Editar detalles
        </h2>

        <form action="{{ url('/actualizar-api/' . $data['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="latitud"><i class="bi bi-geo-alt"></i> Latitud</label>
                <input type="text" class="form-control" name="latitud" value="{{ $data['latitud'] }}" required>
            </div>
            
            <div class="form-group">
                <label for="longitud"><i class="bi bi-geo-alt"></i> Longitud</label>
                <input type="text" class="form-control" name="longitud" value="{{ $data['longitud'] }}" required>
            </div>
            
            <div class="form-group">
                <label for="altitud"><i class="bi bi-geo-alt"></i> Altitud</label>
                <input type="text" class="form-control" name="altitud" value="{{ $data['altitud'] }}" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion"><i class="bi bi-card-text"></i> Descripción</label>
                <textarea class="form-control" name="descripcion" required>{{ $data['descripcion'] }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="foto"><i class="bi bi-image"></i> Foto</label>
                <input type="file" class="form-control" name="foto" accept="image/*">
                <div class="form-text">Por favor, sube solo imágenes en formato JPEG.</div>
            </div>
            
            <div class="form-group">
                <label for="nombre_parada"><i class="bi bi-signpost"></i> Nombre de Encuentro</label>
                <input type="text" class="form-control" name="nombre_parada" value="{{ $data['nombre_parada'] }}" required>
            </div>
            
            <div class="form-group">
                <label for="hora_aprox"><i class="bi bi-clock"></i> Hora Aproximada</label>
                <input type="time" class="form-control" name="hora_aprox" value="{{ $data['hora_aprox'] }}" required>
            </div>
            
            <div class="form-group">
                <label for="trayectoria_id"><i class="bi bi-map"></i> Trayectoria</label>
                <select class="form-select" name="trayectoria_id" required>
                    <option value="">Seleccione una trayectoria</option>
                    @foreach ($trayectorias as $trayectoria)
                        <option value="{{ $trayectoria->id }}" {{ $data['trayectoria_id'] == $trayectoria->id ? 'selected' : '' }}>
                            {{ $trayectoria->ruta_inicio }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">
                <i class="bi bi-save"></i> Actualizar
            </button>
            <a href="{{ url('/consultar-detalle') }}" class="btn btn-secondary mt-3">
                <i class="bi bi-x-circle"></i> Cancelar
            </a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
