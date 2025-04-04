<?php 
session_start();
require_once  './config/configBD.php'; // Archivo de conexión a la base de datos

// Crear la conexión con la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si el usuario ya está logueado, mostrar botón de Cerrar Sesión con mensaje
if (isset($_SESSION['usuario_id'])) {
    $mensaje = "Bienvenido, " . $_SESSION['usuario_nombre'];

    // Si el usuario es administrador
    if ($_SESSION['usuario_rol'] == "admin") {
        $mensaje = "Bienvenido, Administrador";
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Concesionario Manzano</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: lightgray;
                font-family: Arial, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
            }
            .login-container {
                max-width: 400px;
                padding: 2rem;
                background: white;
                border-radius: 10px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            .btn-logout {
                background-color: #dc3545;
                border: none;
                padding: 10px;
                width: 100%;
                color: white;
                border-radius: 5px;
                font-weight: bold;
                cursor: pointer;
                transition: 0.3s;
            }
            .btn-logout:hover {
                background-color: #c82333;
            }
            .welcome-message {
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <p class="welcome-message"><?php echo $mensaje; ?></p>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar al usuario en la base de datos
    $query = $conn->prepare("SELECT id, nombre, contraseña, rol FROM usuarios WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();

    // Obtén los resultados
    $result = $query->get_result();
    $usuario = $result->fetch_assoc();

    if ($usuario && password_verify($password, $usuario['contraseña'])) {
        // Si las credenciales son correctas, establecer la sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $usuario['rol'];

        // Redirigir al index
        header("Location: index.php");
        exit;
    } else {
        $error = "Correo o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Concesionario Manzano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: lightgray;
            font-family: Arial, sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .btn-primary {
            background-color: #004A99;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0066CC;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
        <form method="post">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
        <p class="mt-3">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
