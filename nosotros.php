<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - Concesionarios Manzano</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .nav-item .fas.fa-heart {
            color: red; /* Cambiar el color del corazón */
            font-size: 1.5rem; /* Ajustar el tamaño del ícono */
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: lightgray;
        }
        h2{
            text-align: center;
        }
        header { 
            background: url('./images/equipo.webp') no-repeat center/cover; 
            color: white; 
            padding: 3rem 0; 
            text-align: center; 
            background-position: center 30%;
        }

        nav {
            background-color: #004A99;
        }
        nav a {
            color: white;
            font-weight: bold;
            padding: 15px 20px;
            display: inline-block;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #0066CC;
            border-radius: 5px;
        }

        main {
            padding: 3rem;
            text-align: center;
        }
        section {
            margin-bottom: 3rem;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .imagenes-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .imagenes-container img,
        .imagenesValores img,
        main img {
            width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .whatsapp-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            color: white;
            padding: 15px;
            border-radius: 50%;
            font-size: 28px;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .whatsapp-btn:hover { background-color: #1ebe57; }
        /* Estilos del carrusel */
        .carousel-item img {
            width: 400px;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
        .whatsapp-btn {
            position: fixed;
            bottom: 80px;
            right: 20px;
            background-color: #25D366;
            color: white;
            padding: 15px;
            border-radius: 50%;
            font-size: 28px;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .whatsapp-btn:hover { background-color: #1ebe57; }
        footer {
            background: url('./images/taller.jpg') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
            background-position: center 30%;
            color: darkblue;
        }
        footer p{
            color:darkblue;
        }
        h1, h2 {
            color: darkblue;
        }
        .titulo{
        background-color: rgba(0, 0, 0, 0.6); /* Fondo negro semitransparente */
        padding: 0.5em 1em;
        border-radius: 8px;
        display: inline-block;
        color: white;
        }
    </style>
</head>
<body>

<header>
    <h1><span class="titulo">Concesionarios Manzano</span></h1>
    <p>Conoce más sobre nosotros</p>
</header>
<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario Manzano</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        Concesionarios Manzano
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="nosotros.php">Nosotros</a></li>
                        <li><a class="dropdown-item" href="trabajaConNosotros.php">Trabaja con Nosotros</a></li>
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <li><a class="dropdown-item" href="comparator.php">Compara los Coches</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="nav-item"><a href="vehiculos.php" class="nav-link">Vehículos km0</a></li>
                <li class="nav-item"><a href="vehiculosUsuarios.php" class="nav-link">Vehículos de Usuarios</a></li>
                <li class="nav-item"><a href="financiacion.php" class="nav-link">Financiación</a></li>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item"><a href="subeTuCoche.php" class="nav-link">Sube tu coche</a></li>
                    <li class="nav-item">
                        <a href="favoritos.php" class="nav-link">
                            <i class="fas fa-heart"></i>
                        </a>
                    </li>
                
                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="registro.php" class="nav-link">Registro</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                    <li class="nav-item">
                        <a href="adminDashboard.php" class="btn btn-warning nav-link">Panel Admin</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Sección de imágenes -->
<section>
    <h2>Nuestras Instalaciones</h2>
    <div class="imagenes-container">
        <div><img src="./images/instalacion1.jpeg" alt="Instalación 1"></div>
        <div><img src="./images/instalacion2.jpeg" alt="Instalación 2"></div>
        <div><img src="./images/instalacion3.jpeg" alt="Instalación 3"></div>
        <div><img src="./images/instalacion4.jpeg" alt="Instalación 4"></div>
    </div>
</section>
<!-- Sección de nuestros valores -->
<main>
    <section>
        <h2>¿Quiénes Somos?</h2>
        <p>En <strong>Concesionarios Manzano</strong> nos dedicamos a ofrecer una amplia variedad de vehículos nuevos y de segunda mano con la mejor calidad y al mejor precio. Contamos con más de 20 años de experiencia en el sector, lo que nos ha permitido consolidarnos como una de las opciones más confiables y preferidas por nuestros clientes.</p>
        <img src="./images/quienesSomos.jpg" style="object-position: center 10%;" alt="">
        <h3>Nuestra Misión</h3>
        <p>Brindar a nuestros clientes vehículos que se adapten a sus necesidades y presupuesto, ofreciendo un servicio personalizado y un trato cercano. Nos importa tu satisfacción, por eso nos aseguramos de que cada vehículo que ofrecemos esté en las mejores condiciones.</p>
        <img src="./images/IA.png" style="object-position: center 35%;" alt="">
        <h3>Nuestros Valores</h3>
        <ul>
            <li><strong>Compromiso:</strong> Estamos comprometidos con cada cliente, ofreciendo un servicio excepcional y vehículos de calidad.</li>
            <li><strong>Transparencia:</strong> Actuamos con honestidad en todo momento, desde el momento en que te asesores hasta la entrega del vehículo.</li>
            <li><strong>Innovación:</strong> Siempre buscamos nuevas formas de mejorar la experiencia de compra y postventa de nuestros clientes.</li>
            <li><strong>Confianza:</strong> Queremos que nuestros clientes confíen en nosotros como su opción preferida cuando se trata de comprar un coche.</li>
        </ul>
            <img src="./images/compromiso.jpg" alt="">
        <h3>Nuestro Equipo</h3>
        <p>Contamos con un equipo altamente cualificado y apasionado por el mundo del motor. Desde nuestros asesores hasta nuestro equipo de taller, trabajamos con dedicación para ofrecerte el mejor servicio.</p>
        <section>
        <h2>Conoce a nuestro equipo</h2>
        <<div id="carouselEquipo" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="./images/equipo1.jpg" class="d-block mx-auto" alt="Miembro del equipo 1">
        </div>
        <div class="carousel-item">
            <img src="./images/equipo2.jpg" class="d-block mx-auto" alt="Miembro del equipo 2">
        </div>
        <div class="carousel-item">
            <img src="./images/equipo3.jpg" class="d-block mx-auto" alt="Miembro del equipo 3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselEquipo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselEquipo" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>
    </section>
        <h3>Visítanos</h3>
        <p>Nos encantaría que nos visitaras. Nuestro concesionario está ubicado en el centro de la ciudad, donde podrás conocer a nuestro equipo, ver nuestra amplia oferta de vehículos y recibir asesoramiento personalizado.</p>
    </section>
</main>
<!-- Botón de WhatsApp -->
<a href="https://wa.me/608602302" class="whatsapp-btn" target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>
<footer>
    <p>&copy; 2025 Concesionario Manzano. Todos los derechos reservados.</p>
    <p>Telefono de contacto +34 608 60 23 02</p>
    <p><a href="politicaPrivacidad.php">Política de Privacidad</a> | <a href="politicaCookies.php">Política de Cookies</a></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="fR533L_q2EJkWgWU9cATj";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body>
</html>
