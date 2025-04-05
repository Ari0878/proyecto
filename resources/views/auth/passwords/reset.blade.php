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
            background: linear-gradient(135deg, #0a3d2d, #154c3c);
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

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="form-container">
        <h2>Restablecer Contraseña</h2>
        @if (session('message'))
            <div class="success-message mt-4 text-green-600 text-center">
                {{ session('message') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="correo" value="{{ $correo }}">
            <div class="input-group">
                <label for="reset_code">Verificar Código</label>
                <input id="reset_code" type="text" class="@error('reset_code') border-red-500 @enderror" name="reset_code" required autofocus>
                @error('reset_code')
                    <p class="error-message mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" class="@error('password') border-red-500 @enderror" name="password" required>
                @error('password')
                    <p class="error-message mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="input-group">
                <label for="password-confirm">Confirmar Contraseña</label>
                <input id="password-confirm" type="password" name="password_confirmation" required>
            </div>
            <button type="submit" class="submit-btn">Restablecer Contraseña</button>
        </form>
        <a href="{{ route('login') }}" class="link-btn">Volver al Login</a>
    </div>
</body>
</html>
