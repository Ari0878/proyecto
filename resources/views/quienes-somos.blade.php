<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuervoBus</title>
    <link rel="icon" href="{{ asset('img/logo.jpg') }}" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* Estilos generales */
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #0a3d2d, #154c3c);
            font-family: 'Poppins', sans-serif;
            color: #333;
            line-height: 1.6;
        }

        h1, h2, h3 {
            font-weight: 700;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2.5rem;
            color: rgb(3, 78, 54);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 2rem;
            color: rgb(3, 78, 54);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        h3 {
            font-size: 1.75rem;
            color: rgb(3, 78, 54);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        p {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 20px;
            text-align: justify; /* Justificar el texto */
        }
        .inf{
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        a {
            color:rgb(6, 71, 4);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color:rgb(6, 71, 4);
        }

        /* Estilos del header */
        header {
            background: linear-gradient(135deg, #0a3d2d, #154c3c);
            padding: 25px 0;
        }

        header ul {
            list-style: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        header ul li {
            margin: 0 20px;
        }

        header ul li a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            transition: color 0.3s ease;
        }

        header ul li a:hover {
            color: #81c784;
        }

        /* Estilos del carrusel */
        .carousel {
            max-width: 100%;
            margin: 0 auto;
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0);
        }

        .carousel-inner {
            border-radius: 0px;
            overflow: hidden;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            border-radius: 5px;
            transition: transform 0.5s ease;
        }

        .carousel-item img:hover {
            transform: scale(1.05);
        }

        .carousel-indicators button {
            background-color: blanchedalmond;
        }

        .carousel-indicators .active {
            background-color: white;
        }

        /* Estilos del contenido principal */
        .container {
            padding: 0;
            max-width: 100%;
        }

        #hero, #routes {
            width: 100%;
            border-radius: 0;
            margin: 0;
            padding: 40px 20px;
        }

        #hero {
            background-color: rgb(233, 233, 233);
        }

        #routes {
            background-color: rgb(233, 233, 233);
            margin-top: 20px;
        }

        .caracteristicas {
            background-color: transparent;
            padding: 20px;
            margin-top: 20px;
        }

        .caracteristicas h2 {
            color: white;
        }

        .caracteristicas ul {
            list-style: none;
            padding-left: 0;
        }

        .caracteristicas ul li {
            font-size: 1.1rem;
            color: white;
            margin-bottom: 10px;
        }

        /* Estilos del footer */
        footer {
            background: linear-gradient(135deg, #0a3d2d, #154c3c);
            padding: 20px 0;
            color: white;
            text-align: center;
        }

        footer a {
            color: #81c784;
            text-decoration: none;
            margin: 0 10px;
        }

        footer a:hover {
            color: #4caf50;
        }

        /* Botón flotante */
        .btn-floating {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color:rgb(37, 133, 105);
            border: none;
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-floating:hover {
            background: linear-gradient(135deg, #0a3d2d, #154c3c)
        }

        /* Estilos de los botones */
        .btn-primary {
            background-color:rgb(37, 133, 105);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin: 10px 0;
            float: right; /* Alineación a la derecha */
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0a3d2d, #154c3c);
        }

        /* Responsive */
        @media (max-width: 767px) {
            header ul {
                flex-direction: column;
                align-items: flex-start;
            }

            header ul li {
                margin-bottom: 10px;
            }

            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.75rem;
            }

            h3 {
                font-size: 1.5rem;
            }

            p {
                font-size: 1rem;
            }

            #hero, #routes {
                padding: 20px;
            }

            .btn-primary {
                float: none; /* Centrar botones en móviles */
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <header id="header">
        <ul>
            <li class="logo-container">
                <!--<img src="{{ asset('img/logo.jpg') }}" class="logo">-->
            </li>
            <li><a href="/">Inicio</a></li>
            <li><a href="/quienes-somos">¿Quiénes somos?</a></li>
            <li><a href="/servicios">Servicios</a></li>
            <li><a href="/contacto">Contacto</a></li>
            <li><a href="{{route('login')}}">Inicio de Sesión</a></li>
        </ul>
    </header>

    <!-- Carrusel de imágenes -->
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/imagen1.jpg') }}" class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Seguimiento en Vivo</h5>
                    <p style="color:antiquewhite;" class="inf">Consulta la ubicación del CuervoBus en tiempo real.</p>
                </div>
                
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/imagen2.jpg') }}" class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Horarios Actualizados</h5>
                    <p style="color:antiquewhite;" class="inf">Revisa los horarios y frecuencia de cada ruta.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/imagen3.jpg') }}" class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <h5 style="color: black;">Rutas Óptimas</h5>
                    <p style="color: black;" class="inf">Elige la mejor ruta para tu viaje y evita retrasos.</p>
                </div>
            </div>
        </div>

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="container">
        <div id="hero">
            <h1>¡Sigue CuervoBus en Tiempo Real!</h1>
            <p>Consulta la ubicación en vivo, evita largas esperas y planifica mejor tus viajes.</p>
            <p>Con nuestra plataforma, puedes conocer la ruta exacta del CuervoBus, recibir notificaciones cuando se acerque a tu parada y ver horarios actualizados en todo momento.</p>
            <p>Viajar con CuervoBus es fácil, seguro y eficiente. Nunca más te quedarás esperando sin saber cuándo llegará tu transporte.</p>
            <p>Descubre la mejor forma de moverte con comodidad y confianza.</p>
        </div>

        <div id="how-it-works" style="padding: 25px;">
            <h2 style="color:rgb(255, 255, 255);">¿Cómo Funciona CuervoBus?</h2>
            <p style="color:rgb(237, 240, 239);">Con nuestra aplicación, puedes ver la ubicación del bus en tiempo real y recibir notificaciones cuando esté cerca de tu parada.</p>
            <p style="color:rgb(237, 240, 239);">Gracias a la tecnología de rastreo en vivo, nunca más tendrás que adivinar cuándo llegará tu transporte. Solo abre la aplicación y sigue el recorrido en un mapa interactivo.</p>
            <p style="color:rgb(237, 240, 239);">Además, CuervoBus te brinda mayor seguridad al permitirte compartir tu ubicación con amigos o familiares y recibir alertas sobre cualquier cambio en la ruta.</p>
            <p style="color:rgb(237, 240, 239);">Viaja tranquilo, con información precisa y actualizada al alcance de tu mano.</p>
        </div>

        <div id="routes">
            <h2 style="color:rgb(3, 78, 54);">Rutas en Tiempo Real</h2>
            <h3 style="color:rgb(3, 78, 54);">Ruta 1: Terminal a UTVT por Lerma</h3>
            <p>Esta ruta conecta la Terminal de Toluca con la Universidad Tecnológica del Valle de Toluca (UTVT), pasando por Lerma. Con una duración aproximada de 45 minutos, es una opción rápida y eficiente para estudiantes que necesitan un traslado confiable.</p>
            <p>Durante el recorrido, CuervoBus atraviesa puntos estratégicos como centros comerciales y zonas residenciales, facilitando el acceso a más usuarios.</p>
            <p>Consulta la disponibilidad de unidades en tiempo real y evita largas esperas en la parada.</p>
            <a href="https://www.google.com/maps/dir/Terminal,+Toluca/Plaza+Outlet+Lerma,+Lerma,+Estado+de+México/SantaMariaAtarasquillo+Lerma/UTVT+Lerma/@19.3851,-99.5611,12z/data=!3m1!4b1" target="_blank" class="btn btn-primary">
                <i class="bi bi-map"></i> Ver Ruta 1
            </a> <br><br>
            <h3 style="color:rgb(3, 78, 54);">Ruta 2: Terminal a UTVT por Xonacatlán</h3>
            <p>La ruta alternativa atraviesa Xonacatlán y conecta la Terminal de Toluca con la UTVT. Es una excelente opción para quienes buscan un recorrido diferente o residen en zonas cercanas a este trayecto.</p>
            <p>Con una duración aproximada de 55 minutos, esta ruta ofrece una alternativa conveniente en caso de congestión en la ruta principal. Además, pasa por puntos clave que facilitan el acceso a más pasajeros.</p>
            <p>Consulta el estado del tráfico en tiempo real y elige la mejor opción para tu viaje.</p>
            <a href="https://www.google.com/maps/dir/Terminal+Toluca,+%23101+Interior+101,+Felipe+Berriozabal,+Valle+Verde,+50140+Toluca+de+Lerdo,+M%C3%A9x./19.317681,-99.6299495/BP/Universidad+Tecnol%C3%B3gica+del+Valle+de+Toluca,+MZ+035,+Santa+Mar%C3%ADa+Atarasquillo,+Estado+de+M%C3%A9xico/@19.3233018,-99.5964585,14292m/data=!3m2!1e3!5s0x85cd8a3d4fd08821:0x73e875c3a28f445e!4m21!4m20!1m5!1m1!1s0x85cd8985039da443:0xf661510a6f3085b8!2m2!1d-99.6436087!2d19.2779254!1m0!1m5!1m1!1s0x85d20b5b7633ecc1:0x276c521301201281!2m2!1d-99.521422!2d19.404373!1m5!1m1!1s0x85d20a1464000001:0x1c254456341588a0!2m2!1d-99.4760198!2d19.3404149!3e9?entry=ttu&g_ep=EgoyMDI1MDIxOC4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="btn btn-primary">
                <i class="bi bi-map"></i> Ver Ruta 2
            </a>
            <p>Consulta las rutas y paradas más cercanas desde tu ubicación.</p>
        </div>

        <div class="caracteristicas" style="padding: 25px;" id="carecteristica">
            <h2 style="color:rgb(255, 255, 255);">Características Clave</h2>
            <ul style="list-style: none; padding-left: 0;">
                <li style="color:rgb(237, 240, 239);">✔️ Seguimiento en vivo del CuervoBus</li>
                <li style="color:rgb(237, 240, 239);">✔️ Notificaciones en tiempo real sobre la llegada de tu bus</li>
                <li style="color:rgb(237, 240, 239);">✔️ Horarios y frecuencia actualizada de rutas</li>
                <li style="color:rgb(237, 240, 239);">✔️ Estimaciones de tiempo de llegada a tu parada</li>
                <li style="color:rgb(237, 240, 239);">✔️ Opciones para elegir la ruta más rápida o cómoda</li>
            </ul>
        </div>

        <a href="#header" class="btn-floating">
            <i class="bi bi-arrow-up"></i>
        </a>
    </div>

    <footer>
        <p>© 2025 Lumina Terra - Todos los derechos reservados</p>
        <div class="social-media">
            <a href="#hero">Inicio</a> | 
            <a href="#how-it-works">¿Cómo Funciona?</a> | 
            <a href="#routes">Rutas</a> <br>
            <a href="#">Facebook</a> |
            <a href="#">Twitter</a> |
            <a href="#">Instagram</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>