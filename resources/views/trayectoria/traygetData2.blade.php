<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detalle del Trayectoria">
    <title>Detalle del Trayectoria</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

    <div class="container mt-5">

        <h2 class="mb-4">
            <i class="bi bi-file-earmark-earbuds"></i> Detalle del Trayectoria
        </h2>

        <div class="card shadow-sm">
            <div class="card-header">
                <i class="bi bi-info-circle"></i>
                <strong>Información del Trayectoria</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr><th><i class="bi bi-card-text"></i> ID</th><td>{{ $data['id'] }}</td></tr>
                        <tr><th><i class="bi bi-car-front"></i> Hora de Inicio</th><td>{{ $data['hora_inicio'] }}</td></tr>
                        <tr><th><i class="bi bi-card-checklist"></i> Ruta de Inicio</th><td>{{ $data['ruta_inicio'] }}</td></tr>
                        <tr><th><i class="bi bi-calendar-check"></i> Ruta Final</th><td>{{ $data['ruta_final'] }}</td></tr>
                        <tr><th><i class="bi bi-calendar-plus"></i> Hora Final</th><td>{{ $data['hora_final'] }}</td></tr>
                        <tr><th><i class="bi bi-file-earmark-medical"></i> Vehiculo</th>
    <td>{{ $vehiculo->modelo }}</td>
                    </tbody>
                </table>
            </div>
        </div>

        <a href="{{ url('/consultar-tray') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Regresar
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
