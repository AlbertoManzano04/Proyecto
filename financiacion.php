<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones de Financiación - Concesionario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo similar al de vehiculo.php */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        header {
            background: url('./images/vehiculos2.jpg') no-repeat center/cover;
            color: white;
            padding: 3rem 0;
            text-align: center;
        }
        footer {
            background: url('./images/vehiculos3.avif') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        .container {
            margin-top: 40px;
        }
        .financiacion-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: white;
            text-align: center;
            margin-bottom: 15px;
        }
        .financiacion-card h5 {
            font-size: 1.5rem;
        }
        .financiacion-card p {
            font-size: 1.1rem;
        }
        .financiacion-card .contact-btn {
            display: block;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
        }
        .financiacion-card .contact-btn:hover {
            background-color: #0056b3;
        }
        .whatsapp-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            color: white;
            padding: 10px 15px;
            border-radius: 50%;
            font-size: 24px;
            text-align: center;
        }
        .whatsapp-btn:hover {
            background-color: #1ebe57;
        }
        .location-contact {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>Opciones de Financiación</h1>
    <p>Elige la financiación que mejor se adapte a tus necesidades</p>
</header>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #004A99;">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
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
    <div class="row">
        <div class="col-md-4">
            <div class="financiacion-card">
                <h5>Financiación a 12 Meses</h5>
                <p>Plazo: 12 meses</p>
                <p>Interés: 5.5% anual</p>
                <p>Cuota mensual: 350€</p>
                <a href="contacto.php" class="contact-btn">Solicita más Información</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="financiacion-card">
                <h5>Financiación a 24 Meses</h5>
                <p>Plazo: 24 meses</p>
                <p>Interés: 6.2% anual</p>
                <p>Cuota mensual: 250€</p>
                <a href="contacto.php" class="contact-btn">Solicita más Información</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="financiacion-card">
                <h5>Financiación a 36 Meses</h5>
                <p>Plazo: 36 meses</p>
                <p>Interés: 6.9% anual</p>
                <p>Cuota mensual: 180€</p>
                <a href="contacto.php" class="contact-btn">Solicita más Información</a>
            </div>
        </div>
    </div>
</main>

<div class="location-contact">
    <p><strong>Visítanos:</strong> Calle Ejemplo, 123, Valencia, España</p>
</div>

<a href="https://wa.me/608602302" class="whatsapp-btn" target="_blank">
    &#x1F4AC;
</a>

<footer>
    <p>&copy; 2025 Concesionario Manzano. Todos los derechos reservados.</p>
    <p><a href="politicaPrivacidad.php" style="color: white;">Política de Privacidad</a> | <a href="politicaCookies.php" style="color: white;">Política de Cookies</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


