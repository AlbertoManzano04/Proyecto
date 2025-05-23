<?php
session_start();
// Incluir configuración de base de datos
require_once __DIR__ . '/config/configBD.php';

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    die("No estás logueado. Por favor, inicia sesión.");
}

// Conectar a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Manejo del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $color = $_POST['color'];
    $tipo = $_POST['tipo'];
    $presupuesto = $_POST['presupuesto'];
    $kilometros = $_POST['kilometros'];
    $telefono = $_POST['contacto']; // Añadido para recoger el teléfono
    $usuario_id = $_SESSION['usuario_id']; // Obtener el usuario_id de la sesión
    $potencia_cv = $_POST['potencia_cv']; // Obtener la potencia
    $combustible = $_POST['combustible']; // Obtener el combustible

    // Manejo de la imagen
    $directorio = "images/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }
    $archivoImagen = $directorio . basename($_FILES["imagen"]["name"]);
    if (!file_exists($archivoImagen)) {
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $archivoImagen);
    } else {
        echo "<script>alert('La imagen ya existe en el directorio.');</script>";
    }

    // Insertar en la base de datos
    $stmt = $conn->prepare("INSERT INTO coche_usuario (marca, modelo, anio, color, tipo, presupuesto, kilometros, imagen, telefono, usuario_id, potencia_cv, combustible) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissdisssss", $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $archivoImagen, $telefono, $usuario_id, $potencia_cv, $combustible);

    if ($stmt->execute()) {
        echo "<script>alert('Coche subido con éxito'); window.location.href='vehiculosUsuarios.php';</script>";
    } else {
        echo "<script>alert('Error al subir el coche');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Coche - Vender tu Vehículo</title>
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
        h1, h2 {
            color: darkblue;
        }
header, footer {
    background: url('./images/subeCoche.jpg') no-repeat center/cover;
    color: white;
    padding: 2rem 0;
    text-align: center;
    background-position: center 75%;
}

.form-container {
    position: relative; /* Esto asegura que los elementos dentro de este contenedor no se vean afectados por el fondo */
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1; /* Asegura que el formulario esté por encima de la imagen de fondo */
}

.form-container label {
    font-weight: bold;
}

.form-area input, .form-area button {
            position: relative;
            z-index: 1; /* Asegura que los campos estén encima de la imagen */
        }

.form-area::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('./images/venta.avif');
    background-size: cover;
    background-position: center;
    opacity: 0.3; /* Ajusta la opacidad para que la imagen no opaque los campos */
    z-index: -1; /* Esto asegura que la imagen esté detrás del formulario */
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

.highlight-text {
    font-size: 1.2rem;
    color: #007bff;
    font-weight: bold;
    margin-bottom: 20px;
}

.sube-coche-description {
    background-color: #f7f7f7;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 30px;
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
    <h1><span class="titulo">Vende tu Vehículo</span></h1>
    <p>Comparte las características de tu coche y sube imágenes para venderlo</p>
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

<!-- Fomrulario para subir tu coche  -->
<main class="container my-4">
    <div class="sube-coche-description">
        <h3 class="highlight-text">¡Vende tu coche de manera rápida y fácil!</h3>
        <p>¿Estás buscando vender tu vehículo? ¡Estás en el lugar indicado! Completa este sencillo formulario, sube las fotos de tu coche y nosotros nos encargaremos del resto. Te garantizamos un proceso rápido, seguro y con una excelente valoración. ¡Aprovecha esta oportunidad para vender tu coche de forma sencilla y sin complicaciones!</p>
    </div>

    <div class="form-container form-area">
        <h3 class="text-center">Formulario para Vender tu Vehículo</h3>
        <form method="POST" action="subeTuCoche.php" enctype="multipart/form-data" class="row needs-validation" novalidate>
    <div class="col-md-6 mb-3">
        <label for="marca" class="form-label"><i class="fas fa-car"></i> Marca</label>
        <input type="text" id="marca" name="marca" class="form-control" required placeholder="Ej. Ford">
    </div>

    <div class="col-md-6 mb-3">
        <label for="modelo" class="form-label"><i class="fas fa-cogs"></i> Modelo</label>
        <input type="text" id="modelo" name="modelo" class="form-control" required placeholder="Ej. Focus">
    </div>

    <div class="col-md-6 mb-3">
        <label for="anio" class="form-label"><i class="fas fa-calendar-alt"></i> Año</label>
        <input type="number" id="anio" name="anio" class="form-control" required min="1990" max="2025" placeholder="Ej. 2020">
    </div>

    <div class="col-md-6 mb-3">
        <label for="color" class="form-label"><i class="fas fa-palette"></i> Color</label>
        <input type="text" id="color" name="color" class="form-control" required placeholder="Ej. Azul marino">
    </div>

    <div class="col-md-6 mb-3">
        <label for="tipo" class="form-label"><i class="fas fa-car-side"></i> Tipo</label>
        <select id="tipo" name="tipo" class="form-select" required>
            <option value="">Seleccione el tipo</option>
            <option value="SUV">SUV</option>
            <option value="Sedán">Sedán</option>
            <option value="Deportivo">Deportivo</option>
            <option value="Camioneta">Camioneta</option>
            <option value="Hatchback">Hatchback</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="presupuesto" class="form-label"><i class="fas fa-euro-sign"></i> Precio Deseado</label>
        <input type="number" id="presupuesto" name="presupuesto" class="form-control" required min="1000" step="100" placeholder="Ej. 15000">
    </div>

    <div class="col-md-6 mb-3">
        <label for="kilometros" class="form-label"><i class="fas fa-road"></i> Kilómetros</label>
        <input type="number" id="kilometros" name="kilometros" class="form-control" required min="0" step="1000" placeholder="Ej. 95000">
    </div>
<!-- Campo para ingresar los caballos de potencia -->
<div class="col-md-6 mb-3">
    <label for="potencia_cv" class="form-label"><i class="fas fa-tachometer-alt"></i> Caballos de Potencia</label>
    <input type="number" id="potencia_cv" name="potencia_cv" class="form-control" required placeholder="Ej. 150">
</div>

<!-- Campo para seleccionar el tipo de combustible con iconos -->
<div class="col-md-6 mb-3">
    <label for="combustible" class="form-label"><i class="fas fa-gas-pump"></i> Tipo de Combustible</label>
    <select id="combustible" name="combustible" class="form-select" required>
        <option value="">Seleccione el combustible</option>
        <option value="Gasolina">Gasolina</option>
        <option value="Diesel">Diesel</option>
    </select>
</div>
    <div class="col-md-12 mb-3">
        <label for="imagen" class="form-label"><i class="fas fa-camera"></i> Sube una imagen del coche</label>
        <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*" required onchange="previewImagen(event)">
        <div class="mt-3 text-center">
            <img id="preview" src="#" alt="Vista previa" style="max-height: 200px; display: none; border-radius: 8px;"/>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label for="contacto" class="form-label"><i class="fas fa-phone-alt"></i> Número de Contacto</label>
        <input type="tel" id="contacto" name="contacto" class="form-control" required pattern="[0-9]{9}" placeholder="Ej. 612345678">
    </div>

    <div class="col-12 text-center">
        <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-upload"></i> Subir Coche</button>
    </div>
</form>

    </div>
</main>

<footer>
    <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    <p>Telefono contacto: +34 608 60 23 02</p>
    <p><a href="politicaPrivacidad.php" style="color: white;">Política de Privacidad</a> | <a href="politicaCookies.php" style="color: white;">Política de Cookies</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="fR533L_q2EJkWgWU9cATj";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body>
</html>