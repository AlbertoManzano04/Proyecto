<?php
session_start(); // Iniciar la sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidad - Concesionarios Manzano</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nav-item .fas.fa-heart {
            color: red; /* Cambiar el color del corazón */
            font-size: 1.5rem; /* Ajustar el tamaño del ícono */
        }
        body {
            background-color: lightgray;
        }
        header {
            background: url('./images/concesionario1.jpg') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        footer {
            background: url('./images/contacto1.avif') no-repeat center/cover;
            color: darkblue;
            font-weight: bold;
            padding: 2rem 0;
            text-align: center;
        }
        nav {
            background-color: #004A99; /* Fondo azul */
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            padding: 15px 20px;
            display: inline-block;
        }
        nav a:hover {
            background-color: #0066CC;
            border-radius: 5px;
        }
        main {
            padding: 2rem;
        }
        section {
            margin-bottom: 2rem;
            text-align: justify;
        }
    </style>
</head>
<body>

<header>
    <h1>Política de Privacidad - Concesionarios Manzano</h1>
</header>

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
<!-- Contenido principal -->
<main>
    <section>
        <h2>Introducción</h2>
        <p>En Concesionarios Manzano, respetamos tu privacidad y estamos comprometidos con la protección de tus datos personales. Esta política de privacidad tiene como objetivo explicarte cómo recopilamos, utilizamos y protegemos tus datos cuando visitas nuestro sitio web.</p>
    </section>

    <section>
        <h2>Información que recopilamos</h2>
        <p>Recopilamos la siguiente información cuando interactúas con nuestro sitio web:</p>
        <ul>
            <li><strong>Datos personales:</strong> Nombre, correo electrónico, número de teléfono, entre otros, que proporcionas a través de formularios en nuestro sitio web.</li>
            <li><strong>Datos de navegación:</strong> Información sobre tu dispositivo, dirección IP, tipo de navegador, páginas visitadas, etc., a través de cookies y tecnologías similares.</li>
        </ul>
    </section>

    <section>
        <h2>¿Cómo utilizamos tu información?</h2>
        <p>Los datos personales que recopilamos se utilizan con los siguientes fines:</p>
        <ul>
            <li>Para responder a tus consultas o comentarios.</li>
            <li>Para proporcionarte la información que solicites, como detalles sobre nuestros vehículos y servicios.</li>
            <li>Para mejorar la experiencia del usuario en nuestro sitio web.</li>
            <li>Para realizar análisis y estudios de mercado para ofrecerte contenidos personalizados.</li>
            <li>Para enviarte comunicaciones promocionales si has optado por recibirlas.</li>
        </ul>
    </section>

    <section>
        <h2>¿Cómo protegemos tu información?</h2>
        <p>En Concesionarios Manzano, implementamos medidas de seguridad físicas, electrónicas y administrativas para proteger la información personal que nos proporcionas. Sin embargo, debes ser consciente de que ningún sistema de transmisión de datos por Internet es completamente seguro.</p>
    </section>

    <section>
        <h2>Compartir información con terceros</h2>
        <p>Nos comprometemos a no vender, alquilar ni compartir tus datos personales con terceros para sus propios fines comerciales sin tu consentimiento. No obstante, podemos compartir tus datos con:</p>
        <ul>
            <li>Proveedores de servicios que nos ayudan a operar el sitio web o realizar las funciones que nos solicitas.</li>
            <li>Autoridades legales cuando sea necesario para cumplir con la ley o proteger nuestros derechos legales.</li>
        </ul>
    </section>

    <section>
        <h2>Cookies</h2>
        <p>Utilizamos cookies para mejorar la experiencia del usuario y personalizar el contenido y los anuncios. Si deseas obtener más información sobre cómo utilizamos las cookies, consulta nuestra <a href="politicas_de_cookies.php">Política de Cookies</a>.</p>
    </section>

    <section>
        <h2>Derechos sobre tus datos</h2>
        <p>Tienes derecho a acceder, corregir, eliminar o limitar el uso de tus datos personales. Si deseas ejercer alguno de estos derechos, por favor contáctanos a través de los medios proporcionados en nuestro sitio web.</p>
    </section>

    <section>
        <h2>Actualizaciones de la Política de Privacidad</h2>
        <p>Esta política de privacidad puede ser actualizada de vez en cuando para reflejar cambios en nuestras prácticas. Te notificaremos sobre cualquier cambio mediante un aviso en nuestro sitio web.</p>
    </section>

    <section>
        <h2>Contacto</h2>
        <p>Si tienes alguna pregunta o inquietud sobre nuestra política de privacidad o sobre cómo manejamos tus datos personales, por favor contáctanos a través de los siguientes medios:</p>
        <ul>
            <li>Correo electrónico: contacto@concesionariosmanzano.com</li>
            <li>Teléfono: +34 608 60 23 02</li>
            <li>Dirección:  Av. de America, Córdoba, España</li>
        </ul>
    </section>
</main>

<footer>
    <p>&copy; 2025 Concesionarios Manzano. Todos los derechos reservados.</p>
    <p>Telefono contacto: +34 608 60 23 02</p>
    <p><a href="politicaPrivacidad.php" class="text-white">Política de Privacidad</a> | <a href="politicaCookies.php" class="text-white">Política de Cookies</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="fR533L_q2EJkWgWU9cATj";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body>
</html>