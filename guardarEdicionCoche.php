<?php
session_start();
require_once './config/configBD.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Validar que llegue el ID y la tabla
if (!isset($_POST['id'], $_POST['tabla'])) {
    die("Datos incompletos.");
}

$id = $_POST['id'];
$tabla = $_POST['tabla'];

// Obtener los datos del formulario
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$anio = $_POST['anio'];
$color = $_POST['color'];
$tipo = $_POST['tipo'];
$presupuesto = $_POST['presupuesto'];
$kilometros = $_POST['kilometros'];
$combustible = $_POST['combustible'];
$potencia_cv = $_POST['potencia_cv'];

// Obtener imagen actual desde la base de datos
$stmtImagen = $conn->prepare("SELECT imagen FROM $tabla WHERE id = ?");
$stmtImagen->bind_param("i", $id);
$stmtImagen->execute();
$resultImagen = $stmtImagen->get_result();
$vehiculo = $resultImagen->fetch_assoc();
$imagen = $vehiculo['imagen']; // Valor actual por defecto

// Imagen (opcional - si se sube una nueva)
if (!empty($_FILES['imagen']['name'])) {
    $carpetaDestino = 'images/';
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    // Obtener el nombre original del archivo y limpiarlo
    $nombreOriginal = basename($_FILES["imagen"]["name"]);
    $nombreLimpio = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $nombreOriginal);

    // Comprobar si el archivo ya existe y renombrarlo
    $rutaArchivo = $carpetaDestino . $nombreLimpio;
    $contador = 1;
    while (file_exists($rutaArchivo)) {
        $nombreSinExtension = pathinfo($nombreLimpio, PATHINFO_FILENAME);
        $extension = pathinfo($nombreLimpio, PATHINFO_EXTENSION);
        $rutaArchivo = $carpetaDestino . $nombreSinExtension . "_" . $contador . "." . $extension;
        $contador++;
    }

    // Validar tipo de archivo permitido
    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (in_array($_FILES["imagen"]["type"], $tiposPermitidos)) {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo)) {
            $imagen = $rutaArchivo;
        } else {
            die("Error: No se pudo mover la imagen al destino. Verifica permisos de la carpeta.");
        }
    } else {
        die("Error: Formato de imagen no permitido.");
    }
}

// Validación de combustible
$valores_combustible = ['Gasolina', 'Diésel', 'Eléctrico', 'Híbrido'];
if (!in_array($combustible, $valores_combustible)) {
    die("Valor de combustible no válido.");
}

// Actualizar en la base de datos
$stmt = $conn->prepare("UPDATE $tabla SET marca=?, modelo=?, anio=?, color=?, tipo=?, presupuesto=?, kilometros=?, imagen=?, combustible=?, potencia_cv=? WHERE id=?");
$stmt->bind_param("ssisssdssdi", $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $imagen, $combustible, $potencia_cv, $id);

if ($stmt->execute()) {
    header("Location: adminDashboard.php?msg=editado");
    exit;
} else {
    echo "Error al guardar: " . $stmt->error;
}
?>
