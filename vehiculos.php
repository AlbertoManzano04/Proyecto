<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehículos - Filtrar por Marca, Color, Tipo y Presupuesto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .vehicle-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .vehicle-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .vehicle-card .vehicle-info {
            text-align: center;
        }
        header {
            background: url('./images/vehiculos2.jpg') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        footer{
            background: url('./images/vehiculos3.avif') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        body {
            background-color: lightgray;
        }
        /* Estilos para el nav */
        nav {
            background-color: #004A99; /* Fondo azul */
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
        /* Estilos para hacer el nav responsivo */
        @media (max-width: 768px) {
            nav {
                text-align: center;
            }
            nav a {
                display: block;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Filtra nuestros Vehículos</h1>
    <p>Encuentra el coche de tus sueños según tus preferencias</p>
</header>

<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="vehiculos.php" class="nav-link">Vehículos km0</a></li>
                <li class="nav-item"><a href="financiacion.php" class="nav-link">Financiación</a></li>
                <li class="nav-item"><a href="subeTuCoche.php" class="nav-link">Sube tu coche</a></li>
                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">
    <!-- Filtros -->
    <form method="GET" action="/filtrar-vehiculos" class="row mb-4">
        <div class="col-md-3">
            <label for="marca" class="form-label">Marca</label>
            <select id="marca" name="marca" class="form-select">
                <option value="">Todas</option>
                <option value="Marca A">Mercedes</option>
                <option value="Marca B">BMW</option>
                <option value="Marca C">Audi</option>
                <option value="Marca D">Toyota</option>
                <option value="Marca D">Otros</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="color" class="form-label">Color</label>
            <select id="color" name="color" class="form-select">
                <option value="">Todos</option>
                <option value="Rojo">Rojo</option>
                <option value="Azul">Azul</option>
                <option value="Negro">Negro</option>
                <option value="Blanco">Blanco</option>
                <option value="Otro">Otros</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select id="tipo" name="tipo" class="form-select">
                <option value="">Todos</option>
                <option value="SUV">SUV</option>
                <option value="Sedán">Sedán</option>
                <option value="Deportivo">Deportivo</option>
                <option value="Camioneta">Camioneta</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="presupuesto" class="form-label">Presupuesto</label>
            <input type="range" name="presupuesto" id="presupuesto" min="0" max="50000" step="1000" value="50000" class="form-range">
            <p id="presupuestoValor">€ 50,000</p>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary w-100">Filtrar Vehículos</button>
        </div>
    </form>

    <!-- Resultados de Vehículos -->
    <div class="row" id="vehicle-results">
        <div class="col-md-4">
            <div class="vehicle-card">
                <img src="coche1.avif" alt="Vehículo 1">
                <div class="vehicle-info">
                    <h5>Marca A - SUV</h5>
                    <p>Color: Rojo</p>
                    <p>Precio: € 30,000</p>
                </div>
            </div>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
</footer>

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
