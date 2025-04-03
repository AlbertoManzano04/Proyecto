<?php
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
            // Leer el archivo binario
            $archivoContenido = file_get_contents($archivo['tmp_name']);
            
            // Conectar a la BD
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            // Insertar en la BD
            $stmt = $conn->prepare("INSERT INTO enviarCV (nombre_completo, correo_electronico, telefono, curriculum) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nombre, $email, $telefono, $archivoContenido);

            if ($stmt->execute()) {
                $mensaje = "✅ Currículum enviado con éxito.";
            } else {
                $mensaje = "❌ Error al guardar en la base de datos.";
            }

            $stmt->close();
            $conn->close();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        header { background: url('./images/vehiculos2.jpg') no-repeat center/cover; color: white; padding: 3rem 0; text-align: center; }
        footer { background: url('./images/vehiculos3.avif') no-repeat center/cover; color: white; padding: 2rem 0; text-align: center; }
        nav { background-color: #004A99; }
        nav a { color: white; font-weight: bold; padding: 15px 20px; display: inline-block; text-decoration: none; }
        nav a:hover { background-color: #0066CC; border-radius: 5px; }
        .container { margin-top: 40px; }
    </style>
</head>
<body>

<header>
    <h1>Trabaja con Nosotros</h1>
    <p>Únete al equipo de Concesionarios Manzano</p>
</header>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario Manzano</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="vehiculos.php" class="nav-link">Vehículos km0</a></li>
                <li class="nav-item"><a href="vehiculosUsuarios.php" class="nav-link">Vehículos de Usuarios</a></li>
                <li class="nav-item"><a href="financiacion.php" class="nav-link">Financiación</a></li>
                <li class="nav-item"><a href="subeTuCoche.php" class="nav-link">Sube tu coche</a></li>
                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
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

        <form action="" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-white">
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
        </form>
    </section>
</main>

<footer>
    <p>&copy; 2025 Concesionario Manzano. Todos los derechos reservados.</p>
    <p><a href="politicaPrivacidad.php" style="color: white;">Política de Privacidad</a> | <a href="politicaCookies.php" style="color: white;">Política de Cookies</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

