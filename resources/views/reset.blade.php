<!-- resources/views/reset.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #0a3d2d, #154c3c);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        h1 {
            font-size: 28px;
            color: #154c3c;
            text-align: center;
            margin-bottom: 20px;
            animation: slideUp 1s ease-out forwards;
        }

        .message {
            margin-bottom: 20px;
            font-size: 16px;
            color: #333;
            opacity: 0;
            animation: fadeInMessage 1s forwards 0.5s;
            text-align: left;
            line-height: 1.6;
            font-weight: 500;
        }

        .message span {
            font-weight: bold;
            color: #154c3c;
            font-size: 18px;
        }

        .message p {
            margin-bottom: 10px;
            padding: 8px;
            background-color: #f0f9f2;
            border-radius: 8px;
            border-left: 5px solid #154c3c;
            margin-left: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
            display: block;
            opacity: 0;
            animation: fadeInInput 1s forwards 1s;
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
            opacity: 0;
            animation: fadeInInput 1s forwards 1.5s;
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
            opacity: 0;
            animation: fadeInButton 1s forwards 2s;
        }

        .submit-btn:hover {
            background-color: #1e6951;
            transform: scale(1.05);
        }

        .error-message, .success-message {
            color: #e74c3c;
            font-size: 14px;
            text-align: center;
            opacity: 0;
            animation: fadeInMessage 1s forwards 2.5s;
        }

        .success-message {
            color: #27ae60;
        }

        /* Animaciones */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInMessage {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInInput {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInButton {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

    </style>
</head>
<body>

    <div class="form-container">
        <h1>Restablecer Contraseña</h1>

        <!-- Mensaje explicativo -->
        <div class="message">
            <p>¡Hola! Para restablecer tu contraseña, por favor ingresa el <span>token</span> que se te ha enviado a tu correo electrónico.</p>
            <p>Si no has recibido el correo, por favor revisa tu bandeja de entrada o la carpeta de spam.</p>
        </div>

        <!-- Mensajes de éxito o error -->
        @if (session('message'))
            <div class="success-message">
                <p>{{ session('message') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario para ingresar nueva contraseña -->
        <form action="{{ url('/reset-password') }}" method="POST">
            @csrf

            <!-- Campo para el token -->
            <div class="input-group">
                <label for="token">Token:</label>
                <input type="text" id="token" name="token" required>
            </div>

            <!-- Campo para la nueva contraseña -->
            <div class="input-group">
                <label for="newPassword">Nueva Contraseña:</label>
                <input type="password" id="newPassword" name="newPassword" required minlength="6">
            </div>
            <div>
                <button type="submit" class="submit-btn">Restablecer Contraseña</button>
            </div>
            <br>

            <!-- Botón que redirige a la ruta 'altaUsers' -->
            <div class="input-group">
                <button type="button" class="submit-btn" onclick="window.location.href='{{ route('login') }}'">Incio de Sesión</button>
            </div>



        </form>
    </div>

</body>
</html>