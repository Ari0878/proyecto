<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(110deg, #000000, #154c3c);
        }

        .login-container {
            display: flex;
            background-color: #ffffff;
            width: 800px;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeIn 1s ease-out;
        }

        .form-side {
            padding: 50px;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 30px;
        }

        .form-side h2 {
            font-size: 36px;
            color: #154c3c;
            margin-bottom: 30px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-align: center;
            text-transform: uppercase;
            animation: bounceIn 2s ease-out;
        }

        .input-group {
            margin-bottom: 30px;
        }

        .input-group label {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
            display: block;
        }

        .input-group input {
            width: 100%;
            padding: 10px 0;
            border: none;
            border-bottom: 2px solid #ddd;
            background: transparent;
            font-size: 16px;
            color: #333;
            border-radius: 0;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #154c3c;
            outline: none;
            box-shadow: 0 0 8px rgba(21, 76, 60, 0.4);
        }

        .submit-btn {
            padding: 14px;
            background-color: #154c3c;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #1e6951;
            transform: scale(1.05);
        }

        .link-btn {
            color: #154c3c;
            text-decoration: none;
            margin-top: 20px;
            text-align: center;
            font-size: 16px;
            transition: color 0.3s;
        }

        .link-btn:hover {
            text-decoration: underline;
            color: #1e6951;
        }

        .image-side {
            width: 50%;
            background-image: url('https://i.pinimg.com/736x/27/d1/9a/27d19a07449e05e6eceeedbe89836d02.jpg');
            background-size: cover;
            background-position: center;
            transition: transform 0.3s;
        }

        .image-side:hover {
            transform: scale(1.05);
        }

        /* Modal de error con cuenta bloqueada */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 5px;
            right: 15px;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #countdown {
            font-size: 20px;
            color: #154c3c;
            font-weight: bold;
            margin-top: 10px;
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

        @keyframes bounceIn {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.5;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Lado izquierdo con la imagen -->
        <div class="image-side"></div>

        <!-- Lado derecho con el formulario de login -->
        <div class="form-side">
            <h2>Iniciar sesión</h2>

            <!-- Formulario -->
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Campo Correo -->
                <div class="input-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" value="{{ old('correo') }}" required>
                </div>

                <!-- Campo Contraseña -->
                <div class="input-group">
                    <label for="PASSWORD">Contraseña</label>
                    <input type="password" name="PASSWORD" id="PASSWORD" required>
                </div>

                <!-- Botón de inicio de sesión -->
                <button type="submit" class="submit-btn">Iniciar sesión</button>
            </form>

            <!-- Enlace para contraseña olvidada -->
            <a href="{{ route('password.request') }}" class="link-btn">Olvidé mi contraseña</a>
        </div>
    </div>

    <!-- Modal para mostrar cuenta bloqueada -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>{{ session('error') }}</p> <!-- Muestra el mensaje de error -->
            <p id="countdown"></p> <!-- Muestra la cuenta regresiva -->
        </div>
    </div>

    <script>
        // Mostrar el modal si hay un error de cuenta bloqueada
        @if(session('error'))
            document.getElementById("myModal").style.display = "flex";
            startCountdown(5); // Inicia el contador de 5 minutos
        @endif

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        // Función para iniciar la cuenta regresiva de 5 minutos
        function startCountdown(minutes) {
            let countdownElement = document.getElementById("countdown");
            let timeLeft = minutes * 60; // Convertir a segundos

            let interval = setInterval(function() {
                let minutesLeft = Math.floor(timeLeft / 60);
                let secondsLeft = timeLeft % 60;

                // Mostrar el tiempo en el formato mm:ss
                countdownElement.textContent = `${minutesLeft}:${secondsLeft < 10 ? '0' : ''}${secondsLeft}`;

                if (timeLeft <= 0) {
                    clearInterval(interval);
                    countdownElement.textContent = "¡Puedes intentar nuevamente!";
                } else {
                    timeLeft--;
                }
            }, 1000);
        }
    </script>
</body>
</html>
