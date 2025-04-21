<?php
session_start();
require_once './config/configBD.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener vehículos del concesionario (vehículos con 0 km)
$vehiculosConcesionario = $conn->query("SELECT * FROM vehiculos_km0");

// Obtener vehículos de usuarios (vehículos con más de 0 km)
$vehiculosUsuarios = $conn->query("SELECT * FROM coche_usuario");

$usuarios = $conn->query("SELECT * FROM usuarios");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        header {
            background: url('./images/administracion.avif') no-repeat center/cover;
            color: darkblue;
            padding: 3rem 0;
            text-align: center;
            font-size: 1.5rem;
            background-position: center 65%;
        }
        .form-section {
            background: white;
            padding: 2rem;
            margin: 2rem 0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<header>
    <h1>Panel de Administración</h1>
    <p>Gestiona vehículos del concesionario y de usuarios</p>
</header>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="adminDashboard.php">Panel de Administración</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Salir del Panel de Admin</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
    <div class="form-section">
        <h3>Añadir nuevo vehículo</h3>
        <form action="procesarCoche.php" method="post" enctype="multipart/form-data">
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
                <input type="number" name="kilometros" class="form-control" required>
            </div>
            
            <!-- Campo de Teléfono (se mostrará solo si los kilómetros son mayores a 0) -->
            <div class="row mb-3" id="telefono-container" style="display:none;">
                <div class="col">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Imagen</label>
                <input type="file" name="imagen" class="form-control">
            </div>
            <button type="submit" name="tipo_insert" value="concesionario" class="btn btn-primary">Guardar Vehículo</button>
        </form>
    </div>

    <script>
        // Mostrar el campo de teléfono si los kilómetros son mayores a 0
        document.querySelector('[name="kilometros"]').addEventListener('input', function() {
            var kilometros = this.value;
            var telefonoContainer = document.getElementById('telefono-container');
            if (kilometros > 0) {
                telefonoContainer.style.display = 'block';
            } else {
                telefonoContainer.style.display = 'none';
            }
        });
    </script>
</div>
    <!-- Vehículos del Concesionario -->
    <div class="form-section">
        <h3>Vehículos del Concesionario</h3>
        <table class="table table-bordered">
            <thead><tr><th>Marca</th><th>Modelo</th><th>Precio</th><th>Acción</th></tr></thead>
            <tbody>
            <?php while($row = $vehiculosConcesionario->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['marca']) ?></td>
                    <td><?= htmlspecialchars($row['modelo']) ?></td>
                    <td><?= number_format($row['presupuesto'], 2) ?> €</td>
                    <td>
                        <!-- Enlace para eliminar el vehículo -->
                        <a href="eliminarCoche.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Vehículos de Usuarios -->
    <div class="form-section">
        <h3>Vehículos de Usuarios</h3>
        <table class="table table-bordered">
            <thead>
                <tr><th>Marca</th><th>Modelo</th><th>Telefono</th><th>Kilometros</th><th>Precio</th></tr>
            </thead>
            <tbody>
            <?php while($row = $vehiculosUsuarios->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['marca']) ?></td>
                    <td><?= htmlspecialchars($row['modelo']) ?></td>
                    <td><?= htmlspecialchars($row['telefono']) ?></td>
                    <td><?= htmlspecialchars($row['kilometros']) ?> km</td>
                    <td><?= number_format($row['presupuesto'], 2) ?> €</td>
                    <td><a href="eliminarCoche.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<!-- Mensaje de alerta -->
<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['message']) ?></div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<!-- Lista de Usuarios -->
<!-- Lista de Usuarios -->
<div class="form-section">
    <h3>Usuarios</h3>

    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['message']) ?></div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr><th>Nombre</th><th>Email</th><th>Rol</th><th>Acción</th></tr>
        </thead>
        <tbody>
        <?php
        $usuarios = $conn->query("SELECT * FROM usuarios");
        while($row = $usuarios->fetch_assoc()):
        ?>
            <tr>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['rol']) ?></td>
                <td>
                    <?php if ($row['rol'] !== 'admin'): ?>
                        <a href="eliminarUsuario.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro que deseas eliminar este usuario?')">Eliminar</a>
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
</body>
</html>
