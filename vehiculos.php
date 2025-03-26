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
    </style>
</head>
<body>

<header class="bg-primary text-white text-center py-5">
    <h1>Filtra nuestros Vehículos</h1>
    <p>Encuentra el coche de tus sueños según tus preferencias</p>
</header>

<main class="container my-4">
    <!-- Filtros -->
    <form method="GET" action="/filtrar-vehiculos" class="row mb-4">
        <div class="col-md-3">
            <label for="marca" class="form-label">Marca</label>
            <select id="marca" name="marca" class="form-select">
                <option value="">Todas</option>
                <option value="Marca A">Marca A</option>
                <option value="Marca B">Marca B</option>
                <option value="Marca C">Marca C</option>
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

    <!-- Resultados de Vehículos (Se llenarán dinámicamente por el servidor) -->
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
        <!-- Se agregarían más vehículos según la consulta al backend -->
    </div>
</main>

<footer class="bg-primary text-white text-center py-3">
    <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
</footer>

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
