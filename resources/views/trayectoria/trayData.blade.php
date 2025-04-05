<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de gestión de alumnos">
    <title>Lista de Registros Trayectoria</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<style>
        :root {
            --primary-color: #154c3c;
            --primary-dark: #0a3d2d;
            --secondary-color: #12100e;
            --male-color:rgb(16, 161, 193);
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


    <div class="container mt-5">

        <h2 class="mb-4">Lista de Registros de las Trayectorias</h2>

        <a href="{{ url('/alta-tray') }}" class="btn btn-primary mb-4">
            <i class="bi bi-plus-circle"></i>  Agregar Trayectoria
        </a>
        <a href="{{ route('trayupload.excel.form') }}" class="btn btn-success mb-4">
            <i class="bi bi-upload"></i> Cargar Excel
        </a>

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('pdf.trayectoria') }}" class="btn btn-primary">Generar PDF</a>
        </div>
        

        <div class="table-responsive">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Hora inicial</th>
                        <th scope="col">Ruta Inicial</th>
                        <th scope="col">Hora Final </th>
                        <th scope="col">Ruta Final</th>
                        <th scope="col">Vehiculo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $trayectoria)
                    <tr>
            <td>{{ $trayectoria['id'] }}</td>
            <td>{{ $trayectoria['hora_inicio'] }}</td>
            <td>{{ $trayectoria['ruta_inicio'] }}</td>
            <td>{{ $trayectoria['hora_final'] }}</td>
            <td>{{ $trayectoria['ruta_final'] }}</td>
            <td>{{ $trayectoria['vehiculo']['modelo'] }}</td> <!-- Access vehiculo as an array -->
            <td>
                                <div class="btn-group" role="group" aria-label="Acciones de registro">

                                    <a href="{{ url('/actualizar-tray/' . $trayectoria['id']) }}" 
                                       class="btn btn-warning btn-sm" 
                                       title="Editar trayectoria">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    
                                    <a href="{{ url('/consultar2-tray/' . $trayectoria['id']) }}" 
                                       class="btn btn-primary btn-sm"
                                       title="Ver detalles">
                                        <i class="bi bi-eye"></i> Detalle
                                    </a>
                                    
                                    <a href="{{ url('/borrar-tray/' . $trayectoria['id']) }}" 
                                       class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Borrar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
    @if ($data->lastPage() > 1)
        <div class="btn-group">
            @if ($data->onFirstPage())
                <button class="btn btn-secondary" disabled>&laquo; </button>
            @else
                <a href="{{ $data->previousPageUrl() }}" class="btn btn-primary">&laquo; </a>
            @endif

            @for ($i = 1; $i <= $data->lastPage(); $i++)
                <a href="{{ $data->url($i) }}" 
                   class="btn {{ ($data->currentPage() == $i) ? 'btn-dark' : 'btn-outline-primary' }}">
                    {{ $i }}
                </a>
            @endfor

            @if ($data->hasMorePages())
                <a href="{{ $data->nextPageUrl() }}" class="btn btn-primary"> &raquo;</a>
            @else
                <button class="btn btn-secondary" disabled> &raquo;</button>
            @endif
        </div>
    @endif
</div>
</body>
</html>