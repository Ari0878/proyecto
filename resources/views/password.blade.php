    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Restablecer Contraseña</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
        <style>
            body {
                font-family: 'Roboto', sans-serif;
                background: linear-gradient(135deg, #0a3d2d, #154c3c); /* Fondo con el degradado de verde oscuro */
            }

            .login-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .form-container {
                background-color: #ffffff;
                padding: 30px 40px;
                border-radius: 12px;
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 400px;
            }

            .form-container h2 {
                font-size: 24px;
                font-weight: bold;
                color: #154c3c;
                text-align: center;
                margin-bottom: 24px;
                letter-spacing: 1px;
                text-transform: uppercase;
            }

            .input-group {
                margin-bottom: 24px;
            }

            .input-group label {
                font-size: 16px;
                color: #333;
                margin-bottom: 8px;
                display: block;
            }

            .input-group input {
                width: 100%;
                padding: 12px 10px;
                border: 2px solid #ddd;
                border-radius: 6px;
                font-size: 16px;
                color: #333;
                background: transparent;
                transition: border-color 0.3s ease;
            }

            .input-group input:focus {
                border-color: #154c3c;
                outline: none;
                box-shadow: 0 0 8px rgba(21, 76, 60, 0.4);
            }

            .submit-btn {
                background-color: #154c3c;
                color: white;
                width: 100%;
                padding: 12px;
                border: none;
                border-radius: 6px;
                font-size: 18px;
                font-weight: bold;
                cursor: pointer;
                transition: background-color 0.3s, transform 0.3s;
            }

            .submit-btn:hover {
                background-color: #1e6951;
                transform: scale(1.05);
            }

            .link-btn {
                color: #154c3c;
                text-decoration: none;
                text-align: center;
                display: block;
                margin-top: 15px;
                font-size: 14px;
                transition: color 0.3s;
            }

            .link-btn:hover {
                text-decoration: underline;
                color: #1e6951;
            }

            .error-message, .success-message {
                color: #e74c3c;
                font-size: 14px;
                text-align: center;
            }

            .success-message {
                color: #27ae60;
            }
        </style>
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen">

        <div class="form-container">
            <h2>Restablecer Contraseña</h2>

            <!-- Formulario de olvido de contraseña -->
            <form action="{{ url('/forgot-password') }}" method="POST">
                @csrf <!-- CSRF Token para proteger contra ataques CSRF -->
                
                <div class="input-group">
                    <label for="correo" class="text-sm">Correo electrónico</label>
                    <input type="email" name="correo" id="correo" class="w-full p-2 border rounded" placeholder="Tu correo" required>
                </div>
                
                <button type="submit" class="submit-btn">
                    Enviar enlace para restablecer
                </button>
            </form>

            <!-- Enlace para ingresar con una nueva contraseña -->
            <div class="mt-3 text-center">
                <a href="{{ route('reset') }}" class="link-btn">
                    Haz clic aquí para ingresar con una nueva contraseña
                </a>
            </div>


            <!-- Mensajes de error si los hay -->
            @if ($errors->any())
                <div class="error-message mt-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Mensaje de éxito -->
            @if (session('message'))
                <div class="success-message mt-4">
                    {{ session('message') }}
                </div>
            @endif
        </div>

    </body>
    </html>
