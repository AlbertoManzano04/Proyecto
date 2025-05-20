<?php
session_start();
require_once './config/configBD.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

$mensaje = "";

// Variables para precargar datos si el usuario está logueado
$nombre = '';
$email = '';
$usuario_id = null;

if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conn->prepare("SELECT nombre, email FROM usuarios WHERE id = ?");
    $stmt->bind_param('i', $usuario_id);
    $stmt->execute();
    $stmt->bind_result($nombre, $email);
    $stmt->fetch();
    $stmt->close();
}

// Si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensaje_usuario = trim($_POST['message'] ?? '');

    if (empty($nombre) || empty($email) || empty($mensaje_usuario)) {
        $mensaje = "❌ Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "❌ El correo electrónico no es válido.";
    } else {
        if ($usuario_id !== null) {
            $query = "INSERT INTO Contacto (nombre, email, mensaje, usuario_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssi', $nombre, $email, $mensaje_usuario, $usuario_id);
        } else {
            $query = "INSERT INTO Contacto (nombre, email, mensaje) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $nombre, $email, $mensaje_usuario);
        }

        if ($stmt === false) {
            $mensaje = "❌ Error al preparar la consulta: " . $conn->error;
        } else {
            if ($stmt->execute()) {
                $mensaje = "✅ ¡Gracias por contactarnos! Te responderemos pronto por tu email.";
                $nombre = $email = ''; // Limpiar campos tras envío exitoso si no está logueado
            } else {
                $mensaje = "❌ Error al guardar los datos: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Concesionario</title>
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
            background: url('./images/contacto2.avif') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
            background-position: center 30%;
        }
        footer {
            background: url('./images/contacto1.avif') no-repeat center/cover;
            color: darkblue;
            font-weight: bold;
            padding: 2rem 0;
            text-align: center;
        }
        h1,h2{
            color: darkblue;
        }
        nav {
            background-color: #004A99;
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
        @media (max-width: 768px) {
            nav {
                text-align: center;
            }
            nav a {
                display: block;
                margin: 5px 0;
            }
        }

        /* Estilos del botón de WhatsApp */
        .whatsapp-container {
            display: flex;
            justify-content: flex-start; /* Alinea al botón a la izquierda */
            align-items: center;
            gap: 10px; /* Añade espacio entre el texto y el ícono */
            margin-top: 20px;
        }
        .whatsapp-text {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
        }
        .whatsapp-btn {
            background-color: #25D366;
            color: white;
            padding: 15px;
            border-radius: 50%;
            font-size: 24px;
            text-align: center;
            z-index: 1000; /* Asegura que el botón esté sobre otros elementos */
        }
        .whatsapp-btn:hover {
            background-color: #1ebe57;
        }
    </style>
</head>
<body>

<header>
    <h1>Contacta con Nosotros</h1>
</header>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario Manzano</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Menú desplegable funcional gracias a Bootstrap -->
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
                <?php endif; ?>

                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>

                <!-- Si el usuario está logueado, no mostrar Login/Registro -->
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <!-- Aquí puedes colocar un enlace de Cerrar sesión o similar -->
                    <li class="nav-item"><a href="logout.php" class="nav-link">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="registro.php" class="nav-link">Registro</a></li>
                <?php endif; ?>

                <!-- Mostrar el enlace al Panel Admin solo si el usuario es admin -->
                <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                    <li class="nav-item">
                        <a href="adminDashboard.php" class="btn btn-warning nav-link">Panel Admin</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-4">Contáctanos</h2>
            
            <!-- Mostrar mensaje -->
            <?php if (!empty($mensaje)): ?>
                <div class="alert <?= strpos($mensaje, '✅') !== false ? 'alert-success' : 'alert-danger' ?>">
                    <?= $mensaje ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($nombre) ?>" <?= isset($_SESSION['usuario_id']) ? 'readonly' : '' ?> required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" <?= isset($_SESSION['usuario_id']) ? 'readonly' : '' ?> required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>

        <div class="col-md-6">
    <h2 class="mb-4">Nuestra Ubicación</h2>
    <div class="ratio ratio-16x9">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3169.626275257521!2d-4.779383484692951!3d37.88817577973954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6cdf34c265d3d7%3A0xdafcf680b5c441a3!2sC%C3%B3rdoba%2C%20Espa%C3%B1a!5e0!3m2!1ses!2ses!4v1688498481721!5m2!1ses!2ses" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

            <!-- WhatsApp button next to location -->
            <div class="whatsapp-container">
                <span class="whatsapp-text">Contáctanos por WhatsApp</span>
                <a href="https://wa.me/608602302" class="whatsapp-btn" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    </a>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>Concesionarios Alberto - Tu mejor opción siempre</p>
    <p>Telefono contacto: +34 608 60 23 02</p>
    <p><a href="politicaPrivacidad.php" style="color: white;">Política de Privacidad</a> | <a href="politicaCookies.php" style="color: white;">Política de Cookies</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="fR533L_q2EJkWgWU9cATj";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body>
</html>

