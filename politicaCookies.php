<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Cookies - Concesionarios Manzano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: lightgray;
        }
        header {
            background: url('./images/concesionario1.jpg') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        footer{
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
    <h1>Política de Cookies - Concesionarios Manzano</h1>
</header>

<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario Manzano</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Concesionarios Manzano
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="nosotros.php">Nosotros</a></li>
                        <li><a class="dropdown-item" href="trabajaConNosotros.php">Trabaja con Nosotros</a></li>
                        
                        <!-- Mostrar el comparador solo si el usuario está logueado -->
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
                <?php endif; ?>

                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>

                <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                <li class="nav-item"><a href="registro.php" class="nav-link">Registro</a></li>
            </ul>
        </div>
    </div>
</nav>


<main>
    <section>
        <h2>¿Qué son las cookies?</h2>
        <p>Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo cuando visitas un sitio web. Estas cookies se utilizan para mejorar la experiencia del usuario, facilitar el uso del sitio y personalizar el contenido.</p>
    </section>

    <section>
        <h2>¿Qué tipo de cookies usamos?</h2>
        <p>En Concesionarios Manzano utilizamos varias cookies para mejorar la experiencia de navegación de nuestros usuarios. Estas cookies se dividen en las siguientes categorías:</p>
        <ul>
            <li><strong>Cookies necesarias:</strong> Son esenciales para que el sitio web funcione correctamente. Estas cookies permiten la navegación en el sitio y el uso de sus funciones, como el acceso a áreas seguras del mismo.</li>
            <li><strong>Cookies de rendimiento:</strong> Permiten recopilar información sobre cómo los usuarios interactúan con nuestro sitio web. Esto nos ayuda a mejorar la funcionalidad y el rendimiento del sitio.</li>
            <li><strong>Cookies de funcionalidad:</strong> Estas cookies permiten que el sitio recuerde tus preferencias y configuraciones, mejorando la experiencia del usuario al personalizar el contenido que ves.</li>
            <li><strong>Cookies de publicidad:</strong> Estas cookies se utilizan para mostrar anuncios relevantes basados en tus intereses y para limitar la cantidad de veces que ves el mismo anuncio.</li>
        </ul>
    </section>

    <section>
        <h2>¿Cómo controlar las cookies?</h2>
        <p>Puedes controlar o deshabilitar las cookies a través de la configuración de tu navegador. Sin embargo, debes tener en cuenta que algunas características del sitio web pueden no funcionar correctamente si desactivas las cookies.</p>
        <p>Para más información sobre cómo gestionar las cookies, consulta las opciones de configuración de tu navegador o visita los siguientes enlaces:</p>
        <ul>
            <li><a href="https://support.google.com/chrome/answer/95647?hl=es">Configuración de cookies en Google Chrome</a></li>
            <li><a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-en-Firefox">Configuración de cookies en Mozilla Firefox</a></li>
            <li><a href="https://support.microsoft.com/es-es/help/17442/windows-internet-explorer-delete-manage-cookies">Configuración de cookies en Microsoft Internet Explorer</a></li>
            <li><a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac">Configuración de cookies en Safari</a></li>
        </ul>
    </section>

    <section>
        <h2>Aceptación de nuestra política de cookies</h2>
        <p>Al continuar navegando por nuestro sitio web, aceptas el uso de cookies de acuerdo con nuestra política de cookies. Si no estás de acuerdo, puedes desactivar las cookies siguiendo los pasos mencionados anteriormente.</p>
    </section>
</main>

<footer>
    <p>&copy; 2025 Concesionarios Manzano. Todos los derechos reservados.</p>
    <p><a href="politicaPrivacidad.php" class="text-white">Política de Privacidad</a> | <a href="politicaCookies.php" class="text-white">Política de Cookies</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>