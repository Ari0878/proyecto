<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de gestión de sensores">
    <title>Lista de Sensores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<style>
    :root {
        --primary-color: #154c3c;
        --primary-dark: #0a3d2d;
        --secondary-color: #12100e;
        --male-color: rgb(16, 161, 193);
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
        width: 100%; /* Asegura que la tabla ocupe el 100% del ancho */
    }

    .table thead {
        background-color: var(--primary-color);
        color: white;
    }

    .table th,
    .table td {
        white-space: nowrap; /* Evita que el texto se divida en varias líneas */
        padding: 0.75rem; /* Aumenta el padding para mejor legibilidad */
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
            overflow-x: auto; /* Permite el desplazamiento horizontal en dispositivos pequeños */
        }

        .table th,
        .table td {
            font-size: 0.9rem; /* Reduce el tamaño de la fuente en dispositivos pequeños */
        }
    }
</style>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Sensores</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Latitud</th>
                        <th scope="col">Longitud</th>
                        <th scope="col">Altitud</th>
                        <th scope="col">Velocidad</th>
                        <th scope="col">Rumbo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['latitud'] }}</td>
                            <td>{{ $item['longitud'] }}</td>
                            <td>{{ $item['altitud'] }}</td>
                            <td>{{ $item['velocidad'] }}</td>
                            <td>{{ $item['rumbo'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>