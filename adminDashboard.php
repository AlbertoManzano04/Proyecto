<?php
//creamos sesion abrimos nuestro config y conectamos a la base de datos
session_start();
require_once './config/configBD.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
//ejecutamos las distintas consultas para obtener los datos de las distintas tablas
$vehiculosConcesionario = $conn->query("SELECT * FROM vehiculos_km0");
$vehiculosUsuarios = $conn->query("SELECT * FROM coche_usuario");
$usuarios = $conn->query("SELECT * FROM usuarios");
$enviarCV = $conn->query("SELECT * FROM enviarCV");
$Contacto = $conn->query("SELECT * FROM Contacto");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f8fa;
            font-family: 'Segoe UI', sans-serif;
        }
        header {
            background: linear-gradient(to right, #004a99, #007bff);
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            border-bottom: 5px solid #004a99;
        }
        header h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        header p {
            font-size: 1.25rem;
            opacity: 0.9;
        }
        nav {
            background-color: #003366;
        }
        nav a.nav-link, nav .navbar-brand {
            color: white;
            font-weight: 500;
        }
        nav a:hover {
            color: #ffc107;
        }
        .seccion-formulario {
            background: white;
            padding: 2rem;
            margin: 2rem auto;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .seccion-formulario:hover {
            box-shadow: 0 6px 25px rgba(0,0,0,0.15);
        }
        table th {
            background-color: #f1f1f1;
        }
        .btn-sm {
            font-size: 0.8rem;
        }
        .alerta {
            margin: 1rem auto;
            width: 80%;
        }
        h3 {
            border-left: 5px solid #007bff;
            padding-left: 10px;
            margin-bottom: 20px;
        }
        .nota-rapida {
            background: #fff176;
            padding: 1rem;
            width: 200px;
            min-height: 150px;
            border: 1px solid #f0c000;
            box-shadow: 2px 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            white-space: pre-wrap;
            position: relative;
            transform: rotate(-1deg);
            transition: transform 0.2s;
        }
        .nota-rapida:hover {
            transform: scale(1.05) rotate(0deg);
            box-shadow: 3px 6px 12px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>

<?php if (isset($_GET['message'])): ?>
    <div class="alerta alert-success text-center"><?= htmlspecialchars($_GET['message']) ?></div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="alerta alert-danger text-center"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>
<!--
 * Empezqamos el panel de admministrador con nuestro navegador y header
 * -->

<header>
    <h1><i class="bi bi-speedometer2"></i> Panel de Administración</h1>
    <p>Gestiona vehículos del concesionario y de los usuarios</p>
</header>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="adminDashboard.php"><i class="bi bi-house-fill"></i> Panel de Administración</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php"><i class="bi bi-box-arrow-right"></i> Salir</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!--
 * Aqui tenemos el formulario que nos va a subir coches km0 a nuestro concesionario
 * -->
<div class="container">
    <!-- Formulario para añadir nuevo coche -->
    <div class="seccion-formulario">
        <h3><i class="bi bi-plus-circle"></i> Añadir nuevo vehículo de KM 0</h3>
        <form action="procesarCoche.php" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col">
            <label><i class="fas fa-car"></i> Marca</label>
            <input type="text" name="marca" class="form-control" required>
        </div>
        <div class="col">
            <label><i class="fas fa-cogs"></i> Modelo</label>
            <input type="text" name="modelo" class="form-control" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label><i class="fas fa-calendar"></i> Año</label>
            <input type="number" name="anio" class="form-control" required>
        </div>
        <div class="col">
            <label><i class="fas fa-palette"></i> Color</label>
            <input type="text" name="color" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label><i class="fas fa-car-side"></i> Tipo</label>
            <input type="text" name="tipo" class="form-control">
        </div>
        <div class="col">
            <label><i class="fas fa-dollar-sign"></i> Precio</label>
            <input type="number" name="presupuesto" class="form-control">
        </div>
    </div>
    <div class="mb-3">
        <label><i class="fas fa-tachometer-alt"></i> Kilómetros</label>
        <input type="number" name="kilometros" class="form-control" value="0" readonly>
    </div>
    <div class="mb-3">
        <label><i class="fas fa-bolt"></i> Potencia</label>
        <input type="number" name="potencia_cv" class="form-control">
    </div>
    <div class="mb-3">
        <label><i class="fas fa-gas-pump"></i> Combustible</label>
        <select name="combustible" class="form-select">
            <option value="Gasolina">Gasolina</option>
            <option value="Diésel">Diésel</option>
            <option value="Eléctrico">Eléctrico</option>
            <option value="Híbrido">Híbrido</option>
        </select>
    </div>
    <div class="mb-3">
        <label><i class="fas fa-image"></i> Imagen</label>
        <input type="file" name="imagen" class="form-control">
    </div>
    <button type="submit" class="btn btn-success"><i class="bi bi-save2"></i> Guardar Vehículo</button>
</form>
    </div>
    <div class="seccion-formulario">
    <h3><i class="bi bi-stickies-fill"></i> Notas Rápidas</h3>

    <!-- Formulario -->
    <form action="agregarNota.php" method="POST">
        <textarea name="contenido" class="form-control mb-3" placeholder="Escribe una nota..." required></textarea>
        <button type="submit" class="btn btn-warning"><i class="bi bi-plus-circle-fill"></i> Añadir Nota</button>
    </form>

    <!-- Mostrar notas existentes -->
    <div class="d-flex flex-wrap gap-3 mt-4">
        <?php
        $notas = $conn->query("SELECT * FROM notas ORDER BY fecha DESC");
        while($nota = $notas->fetch_assoc()):
        ?>
        <div class="nota-rapida position-relative">
            <div class="text-dark"><?= nl2br(htmlspecialchars($nota['contenido'])) ?></div>
            <form action="eliminarNota.php" method="POST" class="position-absolute top-0 end-0 m-1">
                <input type="hidden" name="id" value="<?= $nota['id'] ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="bi bi-x-lg"></i></button>
            </form>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<div class="d-flex align-items-center gap-2 mb-3">
    <form method="post" action="limpiarProductosHuerfanos.php" class="m-0">
        <button type="submit" class="btn btn-danger">Eliminar Productos Huérfanos de WordPress</button>
    </form>
    <a href="migrar_coches_existentes_a_wp.php" class="btn btn-primary">Actualizar Coches Existentes en WP</a>
</div>
    <!-- Tabla de vehículos del concesionario -->
    <div class="seccion-formulario">
        <h3><i class="bi bi-car-front-fill"></i> Vehículos del Concesionario</h3>
        <table class="table table-striped">
            <thead><tr><th>Marca</th><th>Modelo</th><th>Precio</th><th>Combustible</th><th>Potencia</th><th>Acción</th></tr></thead>
            <tbody>
            <?php while($row = $vehiculosConcesionario->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['marca']) ?></td>
                    <td><?= htmlspecialchars($row['modelo']) ?></td>
                    <td><?= number_format($row['presupuesto'], 2) ?> €</td>
                    <td><?= htmlspecialchars($row['combustible']) ?></td>
                    <td><?= htmlspecialchars($row['potencia_cv']) ?> cv</td>
                    <td>
                        <a href="procesarEdicionCoche.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                        <a href="eliminarCoche.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Tabla de vehículos de usuarios -->
    <div class="seccion-formulario">
        <h3><i class="bi bi-person-badge-fill"></i> Vehículos de Usuarios</h3>
        <table class="table table-striped">
            <thead><tr><th>Marca</th><th>Modelo</th><th>Teléfono</th><th>Kilómetros</th><th>Precio</th><th>Combustible</th><th>potencia</th><th>Acción</th></tr></thead>
            <tbody>
            <?php while($row = $vehiculosUsuarios->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['marca']) ?></td>
                    <td><?= htmlspecialchars($row['modelo']) ?></td>
                    <td><?= htmlspecialchars($row['telefono']) ?></td>
                    <td><?= htmlspecialchars($row['kilometros']) ?> km</td>
                    <td><?= number_format($row['presupuesto'], 2) ?> €</td>
                    <td><?= htmlspecialchars($row['combustible']) ?></td>
                    <td><?= htmlspecialchars($row['potencia_cv']) ?> CV</td>
                    <td>
                        <a href="procesarEdicionCoche.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                        <a href="eliminarCoche.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>


    <!-- Tabla de usuarios -->
    <div class="seccion-formulario">
        <h3><i class="bi bi-people-fill"></i> Usuarios</h3>
        <table class="table table-striped">
            <thead><tr><th>Nombre</th><th>Email</th><th>Rol</th><th>Acción</th></tr></thead>
            <tbody>
            <?php while($row = $usuarios->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['rol']) ?></td>
                    <td>
                        <?php if ($row['rol'] !== 'admin'): ?>
                            <a href="eliminarUsuario.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro que deseas eliminar este usuario?')"><i class="bi bi-trash"></i></a>
                        <?php else: ?>
                            <span class="text-muted">No se puede eliminar</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Tabla de enviarCV -->
    <div class="seccion-formulario">
        <h3><i class="bi bi-file-earmark-text-fill"></i> CV Enviados</h3>
        <table class="table table-striped">
            <thead><tr><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Curriculum</th><th>Acción</th></tr></thead>
            <tbody>
            <?php while($row = $enviarCV->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nombre_completo']) ?></td>
                    <td><?= htmlspecialchars($row['correo_electronico']) ?></td>
                    <td><?= htmlspecialchars($row['telefono']) ?></td>
                    <td>
                        <a href="./cvs/<?= htmlspecialchars($row['curriculum']) ?>" class="btn btn-info btn-sm" target="_blank">
                            <i class="bi bi-file-earmark-arrow-down"></i> Descargar
                        </a>
                    </td>
                    <td>
                        <a href="EliminarCV.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash3"></i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <!-- Tabla de Contacto -->
    <div class="seccion-formulario">
        <h3><i class="bi bi-chat-left-text-fill"></i>Formulario de Contacto</h3>
        <table class="table table-striped">
            <thead><tr><th>Nombre</th><th>Email</th><th>Mensaje</th></tr></thead>
            <tbody>
            <?php while($row = $Contacto->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['mensaje']) ?></td>
                    <td>
                    <td>
                <a href="mailto:<?= htmlspecialchars($row['email']) ?>?subject=Respuesta a tu consulta" class="btn btn-primary btn-sm">
                 <i class="bi bi-envelope-fill"></i> Responder
                </a>
                <a href="eliminarContacto.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro que deseas eliminar este mensaje del Formulario de contacto?')"><i class="bi bi-trash"></i></a>
                </td>

                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
