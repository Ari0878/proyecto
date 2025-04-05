<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CodePen - Navbar with tooltip on hover</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link href="{{ asset('css/header.css') }}" rel="stylesheet">
  <!-- Agregar Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome para iconos -->

 <style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap");

    body {
    overflow-x: hidden; /* Oculta la barra de desplazamiento horizontal */
    overflow-y: auto;   /* Mantiene la barra de desplazamiento vertical */
    margin: 0;  
    padding: 0;
    background: black;
    }

    ul {
      list-style: none;
      margin: 0;
      padding: 0;
      background-color:rgb(14, 82, 14);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 0.75rem;
      box-shadow: 0 10px 50px 0 rgba(5, 4, 62, 0.25);
      position: fixed;
      top: 0;
      left: 0;
      width: 82px;
      height: 100vh;
      z-index: 1000;
    }

    li:nth-child(6) {
      margin-top: 5rem;
      padding-top: 1.25rem;
      border-top: 1px solid #2ec71a;
    }

    li + li {
      margin-top: 0.75rem;
    }

    a {
      color: #FFF;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 3rem;
      height: 3rem;
      border-radius: 8px;
      position: relative;
    }

    a:hover, a:focus, a.active {
      background-color: #139807;
      outline: 0;
    }

    a:hover span, a:focus span, a.active span {
      transform: scale(1);
      opacity: 1;
    }

    a i {
      font-size: 1.375rem;
    }

    a span {
      position: absolute;
      background-color: #0b830f;
      white-space: nowrap;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      left: calc(100% + 1.5rem);
      transform-origin: center left;
      transform: scale(0);
      opacity: 0;
      transition: 0.15s ease;
    }

    a span:before {
      content: "";
      display: block;
      width: 12px;
      height: 12px;
      position: absolute;
      background-color: #30305a;
      left: -5px;
      top: 50%;
      transform: translatey(-50%) rotate(45deg);
      border-radius: 3px;
    }

    .carousel-caption {
      background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
      color: white;
      padding: 1rem;
      border-radius: 10px;
    }

    details {
      position: fixed;
      right: 1rem;
      bottom: 1rem;
      margin-top: 2rem;
      color: #05043e;
      display: flex;
      flex-direction: column;
    }

    details div {
      background-color: #fff;
      box-shadow: 0 5px 10px rgba(102, 50, 50, 0.15);
      padding: 1.25rem;
      border-radius: 8px;
      position: absolute;
      max-height: calc(100vh - 100px);
      width: 400px;
      max-width: calc(100vw - 2rem);
      bottom: calc(100% + 1rem);
      right: 0;
      overflow: auto;
      transform-origin: 100% 100%;
    }

    details div::-webkit-scrollbar {
      width: 15px;
      background-color: #fff;
    }

    details div::-webkit-scrollbar-thumb {
      width: 5px;
      border-radius: 99em;
      background-color: #ccc;
      border: 5px solid #fff;
    }

    details div > * + * {
      margin-top: 0.75em;
    }

    details div p > code {
      font-size: 1rem;
      font-family: monospace;
      color: #185adb;
      font-weight: 600;
    }

    details div pre {
      white-space: pre-line;
      background-color: #f9f9f9;
      border: 1px solid #95a3b9;
      border-radius: 6px;
      font-family: monospace;
      padding: 0.75em;
      font-size: 0.875rem;
    }

    details[open] div {
      -webkit-animation: scale 0.25s ease;
      animation: scale 0.25s ease;
    }

    @-webkit-keyframes scale {
      0% {
        transform: scale(0);
      }
      100% {
        transform: scale(1);
      }
    }

    @keyframes scale {
      0% {
        transform: scale(0);
      }
      100% {
        transform: scale(1);
      }
    }
/* Estilo para las imágenes del carrusel */
.carousel-item img {
  width: 100vw; /* Las imágenes ocupan todo el ancho de la ventana */
  height: 110vh; /* Las imágenes ocupan toda la altura de la ventana */
  object-fit: cover; /* Mantiene la proporción sin distorsionar las imágenes */
}

/* Estilo para el carrusel */
.carousel {
  margin-top: -50px; /* Ajusta el valor negativo para mover el carrusel hacia arriba */
  
}

/* Fondo oscuro semi-transparente en las descripciones */
.carousel-caption {
  background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro con opacidad del 50% */
  color: white; /* Texto blanco para contraste */
  padding: 134px; /* Espacio alrededor del texto */
  position: absolute;
  bottom: 10px; /* Coloca el texto cerca de la parte inferior */
  left: 50%;
  transform: translateX(-50%); /* Centra el texto horizontalmente */
  text-align: center; /* Centra el texto */
  width: 100vw; /* Asegura que el fondo cubra todo el ancho */
  height: 110vh;
  top: 10px; /* Esto mueve solo el fondo oscuro hacia abajo (sin mover el texto) */
}


/* Estilo para los encabezados dentro del carrusel */
.carousel-caption h5 {
  font-size: 2rem; /* Aumenta el tamaño del encabezado */
  font-weight: bold; /* Enfatiza el encabezado */
}

/* Estilo para los párrafos dentro del carrusel */
.carousel-caption p {
  font-size: 1.2rem; /* Tamaño de texto para los párrafos */
  font-style: italic; /* Hace el texto en cursiva */
}

.carousel-indicators .active {
  background-color: rgba(235, 235, 235, 0.8); /* Indicador activo blanco con opacidad */
}

    /* Clase personalizada para hacer que el fondo ocupe todo el ancho */
    #hero {

      background-color: rgba(0, 0, 0, 0.94); /* Fondo oscuro con opacidad del 50% */
      color: white; /* Color del texto */
      padding: 40px 0; /* Padding superior e inferior */
      padding-left: 100px; 
      padding-right: 30px; 

    }


   

/* Ajustar el padding para que el contenido no se quede pegado en los bordes */
.hero-content {
  padding-left: 15px;
  padding-right: 15px;
  padding-top: 30px;  /* Agregar algo de espacio arriba */
  padding-bottom: 30px; /* Agregar algo de espacio abajo */
}



        /* Clase personalizada para hacer que el fondo ocupe todo el ancho */
        #hero2 {
          background-color: rgba(95, 159, 63, 0.94);      color: white; /* Color del texto */
      padding: 40px 0; /* Padding superior e inferior */
      padding-left: 100px; 
      padding-right: 30px; 


    }


    .card {
      border: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      background-color: rgba(238, 254, 224, 0.94);
    }

    .card:hover {
      transform: translateY(-10px); /* Efecto de elevación al pasar el mouse */
    }

    .card-body {
      padding: 20px;
    }

    .icon {
      margin-bottom: 15px;
      color: rgb(1, 49, 26); /* Color verde brillante para los iconos */
    }

    .card-text {
      font-size: 1.1rem;
      color: rgb(34, 34, 34);
    }

/* Ajustar el margen entre las columnas */
        /* Clase personalizada para hacer que el fondo ocupe todo el ancho */
            /* Clase personalizada para hacer que el fondo ocupe todo el ancho */
            #hero3 {
      background-color: rgba(95, 159, 63, 0.94); /* Fondo oscuro con opacidad del 50% */
      color: white; /* Color del texto */
      padding: 40px 0; /* Padding superior e inferior */
      padding-left: 150px; 
      padding-right: 100px;
    }
    
.row {
  padding: 40px 0; /* Padding superior e inferior */

  
}

/* Asegurarse de que el iframe se ajuste al tamaño disponible */
iframe {
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  width: 100%;
  height: 100%;
  
}

/* Para hacer el diseño más flexible en pantallas pequeñas */
@media (max-width: 390px) {
  .col-md-6 {
    width: 100%;
    padding-left: 100px; 
    padding-right: 0;
  }
}
footer {
  background-color: rgba(103, 169, 71, 0.94); /* Fondo oscuro con opacidad del 50% */
      color: white; /* Color del texto */
      padding: 40px 0; /* Padding superior e inferior */
      padding-left: 150px; 
      padding-right: 100px;
  }

  .video-responsive {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 60%; /* Ajusta el tamaño del video al 50% del contenedor, puedes cambiarlo según lo que necesites */
    max-width: 100%; /* Asegura que el video no se estire más allá de su tamaño original */
    height: auto; /* Mantiene la relación de aspecto */
}


</style>
</head>
<body>
  <!-- Navbar -->
  <ul>
    <li>
      <a href="#">
        <i class="ai-home"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li>
      <a href="#">
        <i class="ai-image"></i>
        <span>Images</span>
      </a>
    </li>  
    <li>
      <a href="#">
        <i class="ai-file"></i>
        <span>Files</span>
      </a>
    </li>
    <li>
      <a href="#">
        <i class="ai-game-controller"></i>
        <span>Games</span>
      </a>
    </li>  
    <li>
      <a href="#">
        <i class="ai-book-open"></i>
        <span>Books</span>
      </a>
    </li>
    <li>
      <a href="#">
        <i class="ai-bell"></i>
        <span>Notifications</span>
      </a>
    </li>
    <li>  
      <a href="#">
        <i class="ai-gear"></i>
        <span>Settings</span>
      </a>
    </li>
    <li>
      <a href="{{route('login')}}">

        <i class="ai-person"></i>
        <span>Inicio de Sesión</span>
      </a>
    </li>
  </ul>

<!-- Carrusel de imágenes -->
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('img/imagen1.jpg') }}" alt="Imagen 1">
            <div class="carousel-caption d-none d-md-block">
                <h5>Seguimiento en Vivo</h5>
                <p class="inf" style="color: antiquewhite;">Consulta la ubicación del CuervoBus en tiempo real.</p>
                <!-- Video -->
                <video id="miVideo" class="video-responsive" autoplay muted loop>
                    <source src="{{ asset('img/ruta.mp4') }}" type="video/mp4">
                    Tu navegador no soporta el formato de video.
                </video>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/imagen2.jpg') }}" alt="Imagen 2">
            <div class="carousel-caption d-none d-md-block">
                <h5 style="color: white;">Rutas Óptimas</h5>
                <p class="inf" style="color: white;">Elige la mejor ruta para tu viaje y evita retrasos.</p>
                <!-- Video -->
                <video id="miVideo" class="video-responsive" autoplay muted loop>
                    <source src="{{ asset('img/aniversario.mp4') }}" type="video/mp4">
                    Tu navegador no soporta el formato de video.
                </video>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/imagen3.jpg') }}" alt="Imagen 3">
            <div class="carousel-caption d-none d-md-block">
                <h5 style="color: white;">Rutas Óptimas</h5>
                <p class="inf" style="color: white;">Elige la mejor ruta para tu viaje y evita retrasos.</p>
                <!-- Video -->
                <video id="miVideo" class="video-responsive" autoplay muted loop>
                    <source src="{{ asset('img/cuervo.mp4') }}" type="video/mp4">
                    Tu navegador no soporta el formato de video.
                </video>
            </div>
        </div>
    </div>

    <!-- Indicadores del carrusel -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
</div>
<!-- Contenedor principal con color de fondo ocupando el ancho completo -->
<div class="container-fluid p-0">
  <div id="hero2" class="hero-content">
    <h1 class="display-4 text-center mb-4">¿Cómo Funciona CuervoBus?</h1>

    <!-- Fila con tarjetas -->
    <div class="row px-3"> <!-- Aquí añadimos el padding izquierdo y derecho -->

      <!-- Card 1: Ubicación -->
      <div class="col-md-3 mb-4">
        <div class="card h-100 d-flex align-items-stretch">
          <div class="card-body text-center">
            <div class="icon"><i class="fas fa-map-marker-alt fa-3x"></i></div>
            <p class="card-text">Con nuestra aplicación, puedes ver la ubicación del bus en tiempo real y recibir notificaciones cuando esté cerca de tu parada.</p>
          </div>
        </div>
      </div>

      <!-- Card 2: Notificaciones -->
      <div class="col-md-3 mb-4">
        <div class="card h-100 d-flex align-items-stretch">
          <div class="card-body text-center">
            <div class="icon"><i class="fas fa-bell fa-3x"></i></div>
            <p class="card-text">Gracias a la tecnología de rastreo en vivo, nunca más tendrás que adivinar cuándo llegará tu transporte. Solo abre la aplicación y sigue el recorrido en un mapa interactivo.</p>
          </div>
        </div>
      </div>

      <!-- Card 3: Seguridad -->
      <div class="col-md-3 mb-4">
        <div class="card h-100 d-flex align-items-stretch">
          <div class="card-body text-center">
            <div class="icon"><i class="fas fa-shield-alt fa-3x"></i></div>
            <p class="card-text">Además, CuervoBus te brinda mayor seguridad al permitirte compartir tu ubicación con amigos o familiares y recibir alertas sobre cualquier cambio en la ruta.</p>
          </div>
        </div>
      </div>

      <!-- Card 4: Tranquilidad -->
      <div class="col-md-3 mb-4">
        <div class="card h-100 d-flex align-items-stretch">
          <div class="card-body text-center">
            <div class="icon"><i class="fas fa-smile fa-3x"></i></div>
            <p class="card-text">Viaja tranquilo, con información precisa y actualizada al alcance de tu mano.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Contenedor principal con color de fondo ocupando el ancho completo -->
<div class="container-fluid p-0">
  <div id="hero" class="hero-content">
    <h1 class="display-4 text-center mb-4">¡Sigue CuervoBus en Tiempo Real!</h1>
    <p class="lead text-center mb-4">Consulta la ubicación en vivo, evita largas esperas y planifica mejor tus viajes.</p>
    <p class="text-center mb-4">Con nuestra plataforma, puedes conocer la ruta exacta del CuervoBus, recibir notificaciones cuando se acerque a tu parada y ver horarios actualizados en todo momento.</p>
    <p class="text-center mb-4">Viajar con CuervoBus es fácil, seguro y eficiente. Nunca más te quedarás esperando sin saber cuándo llegará tu transporte.</p>
    <p class="text-center mb-4">Descubre la mejor forma de moverte con comodidad y confianza.</p>
  </div>
</div>

<!-- Contenedor para texto y mapa -->
<div class="container-fluid p-0">
  <div id="hero3" class="row">
    <h1 class="display-4 text-center mb-4">Rutas en Tiempo Real</h1>

    <!-- Columna izquierda para el texto -->
    <div class="col-sm-12 col-md-6">
      <h3 class="lead text-center mb-4">Ruta 1: Terminal a UTVT por Lerma</h3>
      <p class="text-center mb-4">Esta ruta conecta la Terminal de Toluca con la Universidad Tecnológica del Valle de Toluca (UTVT), pasando por Lerma. Con una duración aproximada de 45 minutos, es una opción rápida y eficiente para estudiantes que necesitan un traslado confiable.</p>
      <p class="text-center mb-4">Durante el recorrido, CuervoBus atraviesa puntos estratégicos como centros comerciales y zonas residenciales, facilitando el acceso a más usuarios.</p>
      <p class="text-center mb-4">Consulta la disponibilidad de unidades en tiempo real y evita largas esperas en la parada.</p>
    </div>

    <!-- Columna derecha para el mapa -->
    <div class="col-sm-12 col-md-6">
      <iframe src="https://www.google.com/maps/embed?pb=!1m40!1m12!1m3!1d240984.35972983015!2d-99.71733976045037!3d19.309283176970432!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m25!3e6!4m5!1s0x85cd8985039da443%3A0xf661510a6f3085b8!2sTerminal%20Toluca%2C%20%23101%20Interior%20101%2C%20Felipe%20Berriozabal%2C%20Valle%20Verde%2C%2050140%20Toluca%20de%20Lerdo%2C%20M%C3%A9x.!3m2!1d19.2779254!2d-99.6436087!4m5!1s0x85cdf5a816da49e5%3A0x7010b5db74b94d2a!2sLas%20Plazas%20Outlet%20Lerma%20Manzana%20002%2C%20La%20Merced%20O%20el%20Calvario%2C%2052006%20Lerma%20de%20Villada%2C%20M%C3%A9x.!3m2!1d19.2841184!2d-99.49955659999999!4m5!1s0x85cdf5fedbb3148b%3A0xee2f3a6c6713cd80!2sSanta%20Mar%C3%ADa%20Atarasquillo%2C%2052044%20M%C3%A9x.!3m2!1d19.326926699999998!2d-99.4610719!4m5!1s0x85d20a1464000001%3A0x1c254456341588a0!2sUniversidad%20Tecnol%C3%B3gica%20del%20Valle%20de%20Toluca%2C%20Manzana%20035%2C%2052044%20Santa%20Mar%C3%ADa%20Atarasquillo%2C%2052044%20M%C3%A9x.!3m2!1d19.3404149!2d-99.47601979999999!5e0!3m2!1ses-419!2smx!4v1740952178768!5m2!1ses-419!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</div>

<!-- Contenedor para texto y mapa -->
<div class="container-fluid p-0">
  <div id="hero3" class="row">
    <!-- Columna derecha para el mapa -->
    <div class="col-sm-12 col-md-6">
      <iframe src="https://www.google.com/maps/embed?pb=!1m36!1m8!1m3!1d240937.36259496363!2d-99.559814!3d19.341149!3m2!1i1024!2i768!4f13.1!4m25!3e0!4m5!1s0x85cd8985039da443%3A0xf661510a6f3085b8!2sTerminal%20Toluca%2C%20%23101%20Interior%20101%2C%20Felipe%20Berriozabal%2C%20Valle%20Verde%2C%2050140%20Toluca%20de%20Lerdo%2C%20M%C3%A9x.!3m2!1d19.2779254!2d-99.6436087!4m5!1s0x85d275feea6bd4df%3A0x8596dd30f934838a!2sVia%20Jos%C3%A9%20L%C3%B3pez%20Portillo%20685%2C%20Delegaci%C3%B3n%20San%20Lorenzo%20Tepaltitl%C3%A1n%20I%2C%20Delegaci%C3%B3n%20San%20Lorenzo%20Tepaltitl%C3%A1n%2C%2050010%20Santa%20Cruz%20Atzcapotzaltongo%2C%20M%C3%A9x.!3m2!1d19.3176654!2d-99.6300351!4m5!1s0x85d20b5b7633ecc1%3A0x276c521301201281!2sBP%2C%20Carrt.Naucalpan-Toluca%20Esq.Carrt-Amomo-Xona-Ixtla%2C%2052060%20Xonacatl%C3%A1n%2C%20M%C3%A9x.!3m2!1d19.404373!2d-99.521422!4m5!1s0x85d20a1464000001%3A0x1c254456341588a0!2sUniversidad%20Tecnol%C3%B3gica%20del%20Valle%20de%20Toluca%2C%20Manzana%20035%2C%2052044%20Santa%20Mar%C3%ADa%20Atarasquillo%2C%20M%C3%A9x.!3m2!1d19.3404149!2d-99.47601979999999!5e0!3m2!1ses!2smx!4v1740960899012!5m2!1ses!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <!-- Columna izquierda para el texto -->
    <div class="col-sm-12 col-md-6">
      <h3 class="lead text-center mb-4">Ruta 2: Terminal a UTVT por Xonacatlán</h3>
      <p class="text-center mb-4">La ruta alternativa atraviesa Xonacatlán y conecta la Terminal de Toluca con la UTVT. Es una excelente opción para quienes buscan un recorrido diferente o residen en zonas cercanas a este trayecto.</p>
      <p class="text-center mb-4">Con una duración aproximada de 55 minutos, esta ruta ofrece una alternativa conveniente en caso de congestión en la ruta principal. Además, pasa por puntos clave que facilitan el acceso a más pasajeros.</p>
      <p class="text-center mb-4">Consulta el estado del tráfico en tiempo real y elige la mejor opción para tu viaje.</p>
    </div>

  </div>
</div>

<!-- Elfsight WhatsApp Chat | Untitled WhatsApp Chat -->
<script src="https://static.elfsight.com/platform/platform.js" async></script>
<div class="elfsight-app-6acafe96-91d4-4e06-8271-40c2fe0d6dbb" data-elfsight-app-lazy></div>

<!-- Contenedor principal con color de fondo ocupando el ancho completo -->
<div class="container-fluid p-0">
  <div id="hero" class="hero-content">
    <p class="text-center mb-4">© 2025 Lumina Terra - Todos los derechos reservados</p>
  </div>
</div>

<!-- Scripts -->
<script src="https://unpkg.com/akar-icons-fonts"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>