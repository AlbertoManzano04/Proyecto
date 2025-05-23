<?php
session_start(); // Iniciar la sesión
require_once 'config/configBD.php';

// Manejar envío del formulario
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    if (!isset($_FILES['cv']) || $_FILES['cv']['error'] != 0) {
        $mensaje = "❌ Error al subir el archivo.";
    } else {
        $archivo = $_FILES['cv'];
        $nombreArchivo = basename($archivo['name']);
        $tipoArchivo = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

        // Validar tipo de archivo
        $formatosPermitidos = ['pdf', 'doc', 'docx'];
        if (!in_array($tipoArchivo, $formatosPermitidos)) {
            $mensaje = "❌ Formato no permitido. Solo PDF, DOC y DOCX.";
        } else {
            // Definir el directorio donde se guardará el archivo
            $directorioDestino = './cvs/';
            if (!is_dir($directorioDestino)) {
                mkdir($directorioDestino, 0777, true); // Crear carpeta si no existe
            }

            // Crear un nombre único para evitar colisiones de nombres de archivo
            $nombreArchivoDestino = uniqid() . '.' . $tipoArchivo;

            // Ruta completa donde se guardará el archivo
            $rutaArchivoDestino = $directorioDestino . $nombreArchivoDestino;

            // Mover el archivo a la carpeta destino
            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivoDestino)) {
                // Conectar a la BD
                $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }

                // Insertar en la base de datos solo el nombre del archivo (no el contenido binario)
                $stmt = $conn->prepare("INSERT INTO enviarCV (nombre_completo, correo_electronico, telefono, curriculum) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nombre, $email, $telefono, $nombreArchivoDestino);

                if ($stmt->execute()) {
                    $mensaje = "✅ Currículum enviado con éxito.";
                } else {
                    $mensaje = "❌ Error al guardar en la base de datos.";
                }

                $stmt->close();
                $conn->close();
            } else {
                $mensaje = "❌ Error al mover el archivo a la carpeta de destino.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabaja con Nosotros - Concesionario Manzano</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nav-item .fas.fa-heart {
            color: red; /* Cambiar el color del corazón */
            font-size: 1.5rem; /* Ajustar el tamaño del ícono */
        }
        body { 
            font-family: Arial, sans-serif; 
            background-color: lightgray; 
        }
        header { 
            background: url('./images/trabajaJuntos.jpg') no-repeat center/cover; 
            color: white; 
            padding: 3rem 0; 
            text-align: center; 
            background-position: center 30%;
        }
        footer { 
            background: url('./images/juntos2.avif') no-repeat center/cover; 
            color: white; 
            padding: 2rem 0; 
            text-align: center; }
        nav { 
            background-color: #004A99; 
        }
        nav a { 
            color: white; 
            font-weight: bold; 
            padding: 15px 20px; 
            display: inline-block; 
            text-decoration: none; }
        nav a:hover { 
            background-color: #0066CC; 
            border-radius: 5px; 
        }
        .container { 
            margin-top: 40px; 
        }
        
        .formulario-area {
            position: relative;
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .formulario-area::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('./images/curriculum.jpg');
            background-size: cover;
            background-position: center 25%;
            opacity: 0.3; /* Controla la opacidad de la imagen */
            z-index: 0; /* Pone la imagen detrás de los campos del formulario */
        }

        .formulario-area input, .formulario-area button {
            position: relative;
            z-index: 1; /* Asegura que los campos estén encima de la imagen */
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
    <h1><span class="titulo">Trabaja con Nosotros</span></h1>
    <p>Únete al equipo de Concesionarios Manzano</p>
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
<main class="container">
    <section>
        <h2>Únete a Nuestro Equipo</h2>
        <p>En <strong>Concesionarios Manzano</strong> buscamos talento apasionado por el mundo del motor. Si quieres formar parte de nuestro equipo, completa el siguiente formulario y envíanos tu currículum.</p>

        <!-- Mostrar mensaje de éxito o error -->
        <?php if ($mensaje): ?>
            <div class="alert <?= strpos($mensaje, '✅') !== false ? 'alert-success' : 'alert-danger' ?>">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="formulario-area">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" required>
                </div>
                <div class="mb-3">
                    <label for="cv" class="form-label">Adjuntar Currículum</label>
                    <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </section>
</main>

<footer>
    <p>&copy; 2025 Concesionario Manzano. Todos los derechos reservados.</p>
    <p>Telefono contacto: +34 608 60 23 02</p>
    <p><a href="politicaPrivacidad.php" style="color: white;">Política de Privacidad</a> | <a href="politicaCookies.php" style="color: white;">Política de Cookies</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="fR533L_q2EJkWgWU9cATj";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body>
</html>
