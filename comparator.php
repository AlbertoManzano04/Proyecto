<?php
session_start();
require_once './config/configBD.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}




$query1 = "SELECT id, marca, modelo, anio, color, tipo, presupuesto, kilometros, combustible, potencia_cv, imagen FROM vehiculos_km0";
$result1 = $conn->query($query1);
$query2 = "SELECT id, marca, modelo, anio, color, tipo, presupuesto, kilometros, combustible, potencia_cv, imagen FROM coche_usuario";
$result2 = $conn->query($query2);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comparador de Vehículos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nav-item .fas.fa-heart {
            color: red; /* Cambiar el color del corazón */
            font-size: 1.5rem; /* Ajustar el tamaño del ícono */
        }
        body {
            background-color: #f2f2f2;
        }
        header {
            background: url('./images/comparator.png') no-repeat center/cover;
            padding: 2rem;
            color: white;
            text-align: center;
        }
        .vehicle-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
            cursor: grab;
        }
        .vehicle-card img {
            weight: 300px;
            height: 300px;
            object-fit: contain;
            border-radius: 5px;
        }
        .comparator-area {
            min-height: 300px;
            background: #fff;
            border: 2px dashed #007bff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .comparator-item {
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            width: 250px;
            background-color: #f8f9fa;
            position: relative;
        }
        .highlight {
            background-color: #d4edda !important;
            font-weight: bold;
        }
        .remove-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-weight: bold;
            cursor: pointer;
        }
        .precio, .anio, .km {
            margin: 5px 0;
        }
        footer {
            background: url('./images/comparator.png') no-repeat center/cover;
            color: white;
            text-align: center;
            padding: 2rem;
            font-weight: bold;
            background-position: center 95%;
        }
        nav {
            background-color: #004A99;
        }
        nav a {
            color: white;
            font-weight: bold;
            padding: 15px 20px;
            display: inline-block;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #0066CC;
            border-radius: 5px;
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
    <h1><span class="titulo">Comparador de Vehículos</span></h1>
    <p>Arrastra los vehículos que quieras comparar al área inferior</p>
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
<!-- Con un bucle recorremos las dos tablas de coches para mostrar todos los coches y poder 
 elegir el que quieras para compararlo con los demas  -->
<main class="container my-4">
    <div class="row">
        <?php while ($row = $result1->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="vehicle-card" draggable="true"
                     data-id="<?= $row['id'] ?>"
                     data-marca="<?= htmlspecialchars($row['marca']) ?>"
                     data-modelo="<?= htmlspecialchars($row['modelo']) ?>"
                     data-anio="<?= $row['anio'] ?>"
                     data-color="<?= htmlspecialchars($row['color']) ?>"
                     data-tipo="<?= htmlspecialchars($row['tipo']) ?>"
                     data-presupuesto="<?= $row['presupuesto'] ?>"
                     data-kilometros="<?= $row['kilometros'] ?>"
                     data-combustible="<?= htmlspecialchars($row['combustible']) ?>"
                     data-cv="<?= $row['potencia_cv'] ?>"
                     data-imagen="<?= $row['imagen'] ?>">
                    <img src="<?= $row['imagen'] ?>" alt="<?= $row['modelo'] ?>" class="img-fluid mb-2">
                    <h5><?= $row['marca'] . " " . $row['modelo'] ?></h5>
                    <p>Año: <?= $row['anio'] ?></p>
                    <p>Color: <?= $row['color'] ?></p>
                    <p>Tipo: <?= $row['tipo'] ?></p>
                    <p>Precio: €<?= number_format($row['presupuesto'], 0, ',', '.') ?></p>
                    <p>Kilómetros: <?= number_format($row['kilometros'], 0, ',', '.') ?></p>
                    <p>Combustible: <?= htmlspecialchars($row['combustible']) ?></p>
                    <p>Potencia: <?= $row['potencia_cv'] ?> CV</p>
                </div>
            </div>
        <?php endwhile; ?>

        <?php while ($row = $result2->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="vehicle-card" draggable="true"
                     data-id="<?= $row['id'] ?>"
                     data-marca="<?= htmlspecialchars($row['marca']) ?>"
                     data-modelo="<?= htmlspecialchars($row['modelo']) ?>"
                     data-anio="<?= $row['anio'] ?>"
                     data-color="<?= htmlspecialchars($row['color']) ?>"
                     data-tipo="<?= htmlspecialchars($row['tipo']) ?>"
                     data-presupuesto="<?= $row['presupuesto'] ?>"
                     data-kilometros="<?= $row['kilometros'] ?>"
                     data-combustible="<?= htmlspecialchars($row['combustible']) ?>"
                     data-cv="<?= $row['potencia_cv'] ?>"
                     data-imagen="<?= $row['imagen'] ?>">
                    <img src="<?= $row['imagen'] ?>" alt="<?= $row['modelo'] ?>" class="img-fluid mb-2">
                    <h5><?= $row['marca'] . " " . $row['modelo'] ?></h5>
                    <p>Año: <?= $row['anio'] ?></p>
                    <p>Color: <?= $row['color'] ?></p>
                    <p>Tipo: <?= $row['tipo'] ?></p>
                    <p>Precio: €<?= number_format($row['presupuesto'], 0, ',', '.') ?></p>
                    <p>Kilómetros: <?= number_format($row['kilometros'], 0, ',', '.') ?></p>
                    <p>Combustible: <?= htmlspecialchars($row['combustible']) ?></p>
                    <p>Potencia: <?= $row['potencia_cv'] ?> CV</p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <h2 class="mt-5 mb-3">Zona de Comparación</h2>
    <div id="comparator" class="comparator-area" ondragover="event.preventDefault()" ondrop="handleDrop(event)"></div>
</main>

<script>
    document.querySelectorAll('.vehicle-card').forEach(card => {
        card.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/plain', JSON.stringify(card.dataset));
        });
    });

    function handleDrop(e) {
        e.preventDefault();
        const data = JSON.parse(e.dataTransfer.getData('text/plain'));
        if (document.querySelector(`#comparator .item-${data.id}`)) return; // evitar duplicados

        const item = document.createElement('div');
        item.className = `comparator-item item-${data.id}`;
        item.dataset.anio = data.anio;
        item.dataset.presupuesto = data.presupuesto;
        item.dataset.kilometros = data.kilometros;
        item.dataset.cv = data.cv;
        item.dataset.combustible = data.combustible;
        item.innerHTML = `
    <button class="remove-btn" onclick="this.parentElement.remove(); resaltarCampos()">×</button>
    <img src="${data.imagen}" class="img-fluid mb-2" alt="${data.modelo}">
    <h6>${data.marca} ${data.modelo}</h6>
    <p class="anio">Año: ${data.anio}</p>
    <p class="precio">Precio: €${parseInt(data.presupuesto).toLocaleString()}</p>
    <p class="km">Kilómetros: ${parseInt(data.kilometros).toLocaleString()}</p>
    <p class="cv">Potencia: ${data.cv} CV</p>
    <p class="combustible">Combustible: ${data.combustible}</p>
    `;
        document.getElementById('comparator').appendChild(item);
        resaltarCampos();
    }

    function resaltarCampos() {
    const items = document.querySelectorAll('#comparator .comparator-item');
    let maxAnio = 0, minPrecio = Infinity, minKm = Infinity, maxCV = 0;

    items.forEach(item => {
        maxAnio = Math.max(maxAnio, parseInt(item.dataset.anio));
        minPrecio = Math.min(minPrecio, parseInt(item.dataset.presupuesto));
        minKm = Math.min(minKm, parseInt(item.dataset.kilometros));
        maxCV = Math.max(maxCV, parseInt(item.dataset.cv || 0));
    });

    items.forEach(item => {
        const anio = parseInt(item.dataset.anio);
        const precio = parseInt(item.dataset.presupuesto);
        const km = parseInt(item.dataset.kilometros);
        const cv = parseInt(item.dataset.cv || 0);

        item.querySelector(".anio").classList.toggle("highlight", anio === maxAnio);
        item.querySelector(".precio").classList.toggle("highlight", precio === minPrecio);
        item.querySelector(".km").classList.toggle("highlight", km === minKm);
        item.querySelector(".cv").classList.toggle("highlight", cv === maxCV);
    });
}

</script>

<!-- Incluir JavaScript de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<footer>
    <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    <p>Telefono contacto: +34 608 60 23 02</p>
    <p><a href="politicaPrivacidad.php" style="color: white;">Política de Privacidad</a> | <a href="politicaCookies.php" style="color: white;">Política de Cookies</a></p>
</footer>
</body>
</html>


