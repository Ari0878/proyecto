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

        .error-message, .success-message {
            color: #e74c3c;
            font-size: 14px;
            text-align: center;
        }

        .success-message {
            color: #27ae60;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #154c3c;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #1e6951;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="form-container">
        <h2>Restablecer Contraseña</h2>
        
        @if (session('message'))
            <div class="success-message mb-4">
                {{ session('message') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="input-group">
                <label for="correo">Correo Electrónico</label>
                <input id="correo" type="email" name="correo" value="{{ old('correo') }}" required autocomplete="correo" autofocus class="@error('correo') border-red-500 @enderror">
                @error('correo')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="submit-btn">
                Verificar código
            </button>
        </form>
        <a href="{{ route('login') }}" class="back-link">Volver al Login</a>
    </div>
</body>
</html>