<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulario de Trayectoria">
    <title>Formulario de Trayectoria</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<style>
        :root {
            --primary-color: #154c3c;
            --primary-dark: #0a3d2d;
            --secondary-color: #12100e;
            --male-color: #154c3c;
            --female-color: #dc3545;
        }

        nav {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 1rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            margin: 0 0.5rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
            display: inline-block;
            position: relative;
        }

        nav a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateY(-2px);
        }

        nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #fff;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        nav a:hover::after {
            width: 70%;
        }

        .table {
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead {
            background-color: var(--primary-color);
            color: white;
        }

        .btn {
            border-radius: 20px;
            padding: 0.4rem 1rem;
            margin: 0 0.2rem;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }
        
        h2 {
            color: var(--primary-color);
            margin: 2rem 0;
            font-weight: 600;
        }

        .gender-male {
            color: var(--male-color);
            font-weight: 500;
        }

        .gender-female {
            color: var(--female-color);
            font-weight: 500;
        }

        .gender-icon {
            margin-right: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .alert {
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            nav {
                text-align: center;
                padding: 0.5rem;
            }
            
            nav a {
                display: block;
                margin: 0.5rem auto;
                padding: 0.5rem 1rem;
            }

            .table-responsive {
                margin-bottom: 1rem;
            }
        }
    </style>
<body>

    <div class="container">

        <div class="card shadow">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="bi bi-car-front"></i> Formulario de Trayectoria
                </h1>
            </div>
            <div class="card-body">

                <!-- Formulario de registro -->
                <form action="{{ route('alta-tray') }}" method="POST">
                    @csrf <!-- Protección CSRF -->

                    <div class="mb-3">
                        <label for="hora_inicio" class="form-label">
                            <i class="bi bi-badge-hd"></i> Hora De Inicio
                        </label>
                        <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="ruta_inicio" class="form-label">
                            <i class="bi bi-card-checklist"></i> Ruta de Inicio
                        </label>
                        <input type="text" class="form-control" name="ruta_inicio" id="ruta_inicio" value="{{ old('ruta_inicio') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="ruta_final" class="form-label">
                            <i class="bi bi-calendar"></i> Ruta Final
                        </label>
                        
                        <input type="text" class="form-control" name="ruta_final" id="ruta_final" value="{{ old('ruta_final') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="hora_final" class="form-label">
                            <i class="bi bi-calendar-check"></i> Hora Final
                        </label>
                        
                        <input type="time" class="form-control" name="hora_final" id="hora_final"  value="{{ old('hora_final') }}" required>
                    </div>

                    <div class="mb-3">
                    <select class="form-select" name="vehiculo_id" id="vehiculo_id" required>
                            <option value="">Seleccione un Vehiculo</option>
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
                        <a href="{{ url('consultar-tray') }}" class="btn btn-dark">
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
