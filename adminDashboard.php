<?php
session_start();
require_once './config/configBD.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

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
        .form-section {
            background: white;
            padding: 2rem;
            margin: 2rem auto;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .form-section:hover {
            box-shadow: 0 6px 25px rgba(0,0,0,0.15);
        }
        table th {
            background-color: #f1f1f1;
        }
        .btn-sm {
            font-size: 0.8rem;
        }
        .alert {
            margin: 1rem auto;
            width: 80%;
        }
        h3 {
            border-left: 5px solid #007bff;
            padding-left: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success text-center"><?= htmlspecialchars($_GET['message']) ?></div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger text-center"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<header>
    <h1><i class="bi bi-speedometer2"></i> Panel de Administración</h1>
    <p>Gestiona vehículos del concesionario y de los usuarios</p>
</header>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="adminDashboard.php"><i class="bi bi-house-fill"></i> Admin Panel</a>
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

<div class="container">
    <!-- Formulario para añadir nuevo coche -->
    <div class="form-section">
        <h3><i class="bi bi-plus-circle"></i> Añadir nuevo vehículo de KM 0</h3>
        <form action="procesarCoche.php" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col">
                    <label>Marca</label>
                    <input type="text" name="marca" class="form-control" required>
                </div>
                <div class="col">
                    <label>Modelo</label>
                    <input type="text" name="modelo" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label>Año</label>
                    <input type="number" name="anio" class="form-control" required>
                </div>
                <div class="col">
                    <label>Color</label>
                    <input type="text" name="color" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label>Tipo</label>
                    <input type="text" name="tipo" class="form-control">
                </div>
                <div class="col">
                    <label>Precio</label>
                    <input type="number" name="presupuesto" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label>Kilómetros</label>
                <input type="number" name="kilometros" class="form-control" value="0" readonly>
            </div>
            <div class="mb-3">
                <label>Imagen</label>
                <input type="file" name="imagen" class="form-control">
            </div>
            <button type="submit" class="btn btn-success"><i class="bi bi-save2"></i> Guardar Vehículo</button>
        </form>
    </div>

    <!-- Tabla de vehículos del concesionario -->
    <div class="form-section">
        <h3><i class="bi bi-car-front-fill"></i> Vehículos del Concesionario</h3>
        <table class="table table-striped">
            <thead><tr><th>Marca</th><th>Modelo</th><th>Precio</th><th>Acción</th></tr></thead>
            <tbody>
            <?php while($row = $vehiculosConcesionario->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['marca']) ?></td>
                    <td><?= htmlspecialchars($row['modelo']) ?></td>
                    <td><?= number_format($row['presupuesto'], 2) ?> €</td>
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
    <div class="form-section">
        <h3><i class="bi bi-person-badge-fill"></i> Vehículos de Usuarios</h3>
        <table class="table table-striped">
            <thead><tr><th>Marca</th><th>Modelo</th><th>Teléfono</th><th>Kilómetros</th><th>Precio</th><th>Acción</th></tr></thead>
            <tbody>
            <?php while($row = $vehiculosUsuarios->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['marca']) ?></td>
                    <td><?= htmlspecialchars($row['modelo']) ?></td>
                    <td><?= htmlspecialchars($row['telefono']) ?></td>
                    <td><?= htmlspecialchars($row['kilometros']) ?> km</td>
                    <td><?= number_format($row['presupuesto'], 2) ?> €</td>
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
    <div class="form-section">
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

    <!-- Nueva Tabla de enviarCV -->
    <div class="form-section">
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
    <div class="form-section">
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
                        <?php if ($row['rol'] !== 'admin'): ?>
                            <a href="eliminarContacto.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro que deseas eliminar este mensaje del Formulario de contacto?')"><i class="bi bi-trash"></i></a>
                        <?php else: ?>
                            <span class="text-muted">No se puede eliminar</span>
                        <?php endif; ?>
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

