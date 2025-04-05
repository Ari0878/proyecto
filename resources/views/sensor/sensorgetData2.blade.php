<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detalle del Trayectoria">
    <title>Detalle de Sensor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

    <div class="container mt-5">

        <h2 class="mb-4">
            <i class="bi bi-file-earmark-earbuds"></i> Detalle del Sensor
        </h2>

        <div class="card shadow-sm">
            <div class="card-header">
                <i class="bi bi-info-circle"></i>
                <strong>Información del Sensor</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr><th><i class="bi bi-card-text"></i> ID</th><td>{{ $data['id'] }}</td></tr>
                        <tr><th><i class="bi bi-car-front"></i> Latitud</th><td>{{ $data['latitud'] }}</td></tr>
                        <tr><th><i class="bi bi-card-checklist"></i> Longitud</th><td>{{ $data['longitud'] }}</td></tr>
                        <tr><th><i class="bi bi-calendar-check"></i> Altitud</th><td>{{ $data['altitud'] }}</td></tr>
                        <tr><th><i class="bi bi-calendar-plus"></i> Velocidad</th><td>{{ $data['velocidad'] }}</td></tr>
                        <tr><th><i class="bi bi-file-earmark-medical"></i> Rumbo</th><td>{{ $data['rumbo'] }}</td></tr>
                        <tr><th><i class="bi bi-file-earmark-medical"></i> Vehiculo</th>
    <td>{{ $vehiculo->modelo }}</td>
                    </tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <a href="{{ url('/consultar-sensor') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Regresar
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
