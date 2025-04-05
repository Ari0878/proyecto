<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulario de Detalles">
    <title>Formulario de Detalles</title>
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
                <i class="bi bi-car-front"></i> Formulario de Detalles
            </div>
            <div class="card-body">
                <form action="{{ route('alta-detalle') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="latitud" class="form-label"><i class="bi bi-geo-alt-fill"></i> Latitud</label>
                        <input type="decimal" class="form-control" name="latitud" id="latitud" value="{{ old('latitud') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="longitud" class="form-label"><i class="bi bi-geo-alt-fill"></i> Longitud</label>
                        <input type="decimal" class="form-control" name="longitud" id="longitud" value="{{ old('longitud') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="altitud" class="form-label"><i class="bi bi-alt"></i> Altitud</label>
                        <input type="decimal" class="form-control" name="altitud" id="altitud" value="{{ old('altitud') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label"><i class="bi bi-card-text"></i> Descripción</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" required>{{ old('descripcion') }}</textarea>
                    </div>
                    <div class="mb-3">
                    <label for="foto" class="form-label"><i class="bi bi-camera"></i> Foto (Solo JPEG)</label>
                    <input type="file" class="form-control" name="foto" id="foto" accept=".jpg, .jpeg" required>
                    <div class="form-text">Por favor, sube solo imágenes en formato JPEG.</div>
                    </div>
                    <div class="mb-3">
                        <label for="nombre_parada" class="form-label"><i class="bi bi-signpost"></i> Nombre de la Parada</label>
                        <input type="text" class="form-control" name="nombre_parada" id="nombre_parada" value="{{ old('nombre_parada') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="hora_aprox" class="form-label"><i class="bi bi-clock"></i> Hora Aproximada</label>
                        <input type="time" class="form-control" name="hora_aprox" id="hora_aprox" value="{{ old('hora_aprox') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="trayectoria_id" class="form-label"><i class="bi bi-truck"></i> Trayectoria</label>
                        <select class="form-select" name="trayectoria_id" id="trayectoria_id" required>
                            <option value="">Seleccione una Trayectoria</option>
                            @foreach ($trayectorias as $trayectoria)
                                <option value="{{ $trayectoria->id }}" {{ old('trayectoria_id') == $trayectoria->id ? 'selected' : '' }}>
                                    {{ $trayectoria->ruta_inicio}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                        <a href="{{ url('consultar-detalle') }}" class="btn btn-dark"><i class="bi bi-x-circle"></i> Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
