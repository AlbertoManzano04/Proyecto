<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones de Financiación - Concesionario Manzano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo similar al de vehiculo.php */
        body {
            font-family: Arial, sans-serif;
            background-color: lightgray;
        }
        h1, h2 {
            color: darkblue;
        }
        header {
            background: url('./images/financiacion.avif') no-repeat center/cover;
            color: white;
            padding: 3rem 0;
            text-align: center;
            background-position: center 48%;
        }
        footer {
            background: url('./images/financiacion1.avif') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        /* Navegación */
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
        .container {
            margin-top: 40px;
        }
        .financiacion-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color:  white;
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
            top: 50%;
            right: 0;
            transform: translateY(-50%); /* Centra verticalmente */
            background-color: #25D366;
            color: white;
            padding: 10px 15px;
            border-radius: 50%;
            font-size: 24px;
            text-align: center;
            z-index: 1000; /* Asegura que el botón esté sobre otros elementos */
        }
        .whatsapp-btn:hover {
            background-color: #1ebe57;
        }
        .location-contact {
            text-align: center;
            margin-top: 20px;
        }
        h3,h2{
            color: darkblue;
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
        <a class="navbar-brand" href="index.php">Concesionario Manzano</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="vehiculos.php" class="nav-link">Vehículos km0</a></li>
                <li class="nav-item"><a href="vehiculosUsuarios.php" class="nav-link">Vehículos de Usuarios</a></li>
                <li class="nav-item"><a href="financiacion.php" class="nav-link">Financiación</a></li>
                <li class="nav-item"><a href="subeTuCoche.php" class="nav-link">Sube tu coche</a></li>
                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Concesionarios Manzano
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="nosotros.php">Nosotros</a></li>
                        <li><a class="dropdown-item" href="trabajaConNosotros.php">Trabaja con Nosotros</a></li>
                    </ul>
                </li>           
            </ul>
        </div>
    </div>
</nav>
    <section class="container">
        <h2>Financiación a tu medida en Concesionarios Manzano</h2>
        <p>En <strong>Concesionarios Manzano</strong>, entendemos que comprar un coche es una gran inversión. Por eso, te ofrecemos <strong>opciones de financiación flexibles</strong> que se adaptan a tus necesidades y presupuesto.</p>
        <h3>¿Cómo funciona?</h3>
        <p>Contamos con planes de financiación con cuotas mensuales accesibles y tasas de interés competitivas. Puedes elegir entre:</p>
        <ul>
            <li><strong>12 meses:</strong> Pagos más altos, menor interés.</li>
            <li><strong>24 meses:</strong> Un equilibrio entre cuota e interés.</li>
            <li><strong>36 meses o más:</strong> Cuotas más reducidas y mayor accesibilidad.</li>
        </ul>
        <img src="./images/finanzas1.avif" alt="">
        <h3>Ventajas de financiar con nosotros</h3>
        <ul>
            <li>Proceso rápido y sencillo.</li>
            <li>Condiciones adaptadas a tu perfil financiero.</li>
            <li>Flexibilidad en los pagos.</li>
            <li>Transparencia total, sin costos ocultos.</li>
            <li>Asesoramiento personalizado.</li>
        </ul>
        <img src="./images/finanzas2.jpg" alt="">
        <h3>Requisitos</h3>
        <p>Para acceder a nuestra financiación, solo necesitas traer a nuestras oficinas estos documentos:</p>
        <ul>
            <li>DNI o NIE.</li>
            <li>Justificante de ingresos.</li>
            <li>Extracto bancario reciente.</li>
        </ul>
        <p><strong>¡Contáctanos hoy mismo para más información!</strong></p>
    </section>

<main class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="financiacion-card">
                <h5>Financiación a 12 Meses</h5>
                <p>Plazo: 12 meses</p>
                <p>Interés: 5.5% anual</p>
                <p>Cuota mensual: 350€</p>
                <a href="contacto.php" class="contact-btn">Más Información</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="financiacion-card">
                <h5>Financiación a 24 Meses</h5>
                <p>Plazo: 24 meses</p>
                <p>Interés: 6.2% anual</p>
                <p>Cuota mensual: 250€</p>
                <a href="contacto.php" class="contact-btn">Más Información</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="financiacion-card">
                <h5>Financiación a 36 Meses</h5>
                <p>Plazo: 36 meses</p>
                <p>Interés: 6.9% anual</p>
                <p>Cuota mensual: 180€</p>
                <a href="contacto.php" class="contact-btn">Más Información</a>
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


