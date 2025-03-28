<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Coche - Vender tu Vehículo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: lightgray;
        }
        header {
            background: url('./images/vehiculos2.jpg') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        footer {
            background: url('./images/vehiculos3.avif') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container label {
            font-weight: bold;
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
    <h1>Vende tu Vehículo</h1>
    <p>Comparte las características de tu coche y sube imágenes para venderlo</p>
</header>

<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="vehiculos.php" class="nav-link">Vehículos</a></li>
                <li class="nav-item"><a href="financiacion.php" class="nav-link">Financiación</a></li>
                <li class="nav-item"><a href="subeTuCoche" class="nav-link">Sube tu coche</a></li>
                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">
    <div class="form-container">
        <h3 class="text-center">Formulario para Vender tu Vehículo</h3>
        <form method="POST" action="/subir-coche" enctype="multipart/form-data" class="row">
            <!-- Marca -->
            <div class="col-md-6 mb-3">
                <label for="marca" class="form-label">Marca</label>
                <select id="marca" name="marca" class="form-select" required>
                    <option value="">Seleccione una marca</option>
                    <option value="Marca A">Mercedes</option>
                    <option value="Marca B">BMW</option>
                    <option value="Marca C">Audi</option>
                    <option value="Marca D">Toyota</option>
                    <option value="Marca E">Honda</option>
                    <option value="Otros">Otros</option>
                </select>
            </div>

            <!-- Color -->
            <div class="col-md-6 mb-3">
                <label for="color" class="form-label">Color</label>
                <select id="color" name="color" class="form-select" required>
                    <option value="">Seleccione un color</option>
                    <option value="Rojo">Rojo</option>
                    <option value="Azul">Azul</option>
                    <option value="Negro">Negro</option>
                    <option value="Blanco">Blanco</option>
                    <option value="Gris">Gris</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <!-- Tipo -->
            <div class="col-md-6 mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select id="tipo" name="tipo" class="form-select" required>
                    <option value="">Seleccione el tipo</option>
                    <option value="SUV">SUV</option>
                    <option value="Sedán">Sedán</option>
                    <option value="Deportivo">Deportivo</option>
                    <option value="Camioneta">Camioneta</option>
                    <option value="Hatchback">Hatchback</option>
                </select>
            </div>

            <!-- Precio -->
            <div class="col-md-6 mb-3">
                <label for="precio" class="form-label">Precio (€)</label>
                <input type="number" id="precio" name="precio" class="form-control" required min="1000" step="100" placeholder="Ingrese el precio del coche">
            </div>

            <!-- Kilómetros -->
            <div class="col-md-6 mb-3">
                <label for="kilometros" class="form-label">Kilómetros recorridos</label>
                <input type="number" id="kilometros" name="kilometros" class="form-control" required min="0" placeholder="Ingrese los kilómetros recorridos">
            </div>

            <!-- Imágenes -->
            <div class="col-md-12 mb-3">
                <label for="imagenes" class="form-label">Sube Imágenes del Coche</label>
                <input type="file" id="imagenes" name="imagenes[]" class="form-control" multiple required>
                <small class="form-text text-muted">Puedes subir varias imágenes de tu coche.</small>
            </div>

            <!-- Enviar formulario -->
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Subir Coche</button>
            </div>
        </form>
    </div>
</main>

<footer>
    <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
</footer>

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
