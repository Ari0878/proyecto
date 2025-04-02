<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Excel Detalle</title>
    <!-- Bootstrap CSS (opcional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Cargar archivo Excel de Detalles</h1>

        <!-- Formulario para cargar el archivo -->
        <form action="{{ route('detalleupload.excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Selecciona un archivo Excel:</label>
                <input type="file" class="form-control" id="file" name="file" accept=".xlsx, .xls" required>
            </div>
            <button type="submit" class="btn btn-primary">Subir archivo</button>
        </form>

        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-4">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ url('/consultar-detalle') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Regresar
        </a>
    </div>
    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>