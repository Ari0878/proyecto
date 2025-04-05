<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de gestión de alumnos">
    <title>Lista de Registros Detalles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #154c3c;
            --primary-dark: #0a3d2d;
            --secondary-color: #12100e;
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
        }

        nav a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
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

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Paginación compacta */
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-item a {
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 25px;
            background-color: #f8f9fa;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .pagination .page-item a:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .pagination .active a {
            background-color: var(--primary-color);
            color: white;
        }

        .pagination .disabled a {
            background-color: #e9ecef;
            color: #6c757d;
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
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h2 class="mb-4">Lista de Registros de detalle</h2>

        <a href="{{ url('/alta-detalle') }}" class="btn btn-primary mb-4">
            <i class="bi bi-plus-circle"></i> Agregar detalle
        </a>
        <a href="{{ route('detalleupload.excel.form') }}" class="btn btn-success mb-4">
            <i class="bi bi-upload"></i> Cargar Excel
        </a>
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('pdf.detalle') }}" class="btn btn-primary">Generar PDF</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Latitud</th>
                        <th scope="col">Longitud</th>
                        <th scope="col">Altitud</th>
                        <th scope="col">descripción</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nombre Encuentro</th>
                        <th scope="col">Hora aproximada</th>
                        <th scope="col">trayectoria_id</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($data as $detalle)
    <tr>
        <td>{{ $detalle['id'] }}</td>
        <td>{{ $detalle['latitud'] }}</td>
        <td>{{ $detalle['longitud'] }}</td>
        <td>{{ $detalle['altitud'] }}</td>
        <td>{{ $detalle['descripcion'] }}</td>
        <td>
            <img src="{{ asset('img/'.$detalle['foto']) }}" alt="Foto" style="width:80px; height:50px;">
        </td>
        <td>{{ $detalle['nombre_parada'] }}</td>
        <td>{{ $detalle['hora_aprox'] }}</td>
        <td>{{ $detalle['trayectoria']['ruta_inicio'] }}</td>
        <td>
            <div class="btn-group" role="group">
                <a href="{{ url('/actualizar-api/' . $detalle['id']) }}" 
                   class="btn btn-warning btn-sm" 
                   title="Editar detalle">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                                    
                                    <a href="{{ url('/consultar2-detalle/' . $detalle['id']) }}" 
                                       class="btn btn-primary btn-sm"
                                       title="Ver detalles">
                                        <i class="bi bi-eye"></i> Detalle
                                    </a>
                                    
                                    <a href="{{ url('/borrar-detalle/' . $detalle['id']) }}" 
                                       class="btn btn-danger btn-sm"
                                       title="Eliminar detalle">
                                        <i class="bi bi-trash"></i> Borrar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        
        <!-- Paginación compacta -->
       <!-- <div class="pagination">
            {{ $data->links() }}
        </div>-->


<!-- Paginación con botones -->
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
