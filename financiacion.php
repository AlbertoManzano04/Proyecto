<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones de Financiación - Concesionario Manzano</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nav-item .fas.fa-heart {
            color: red; /* Cambiar el color del corazón */
            font-size: 1.5rem; /* Ajustar el tamaño del ícono */
        }
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
            bottom: 80px;
            right: 20px;
            background-color: #25D366;
            color: white;
            padding: 15px;
            border-radius: 50%;
            font-size: 28px;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .whatsapp-btn:hover { background-color: #1ebe57; }
        .location-contact {
            text-align: center;
            margin-top: 20px;
        }
        h3,h2{
            color: darkblue;
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
    <h1><span class="titulo">Opciones de Financiación</span></h1>
    <p>Elige la financiación que mejor se adapte a tus necesidades</p>
</header>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario Manzano</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
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
                
                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="registro.php" class="nav-link">Registro</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                    <li class="nav-item">
                        <a href="adminDashboard.php" class="btn btn-warning nav-link">Panel Admin</a>
                    </li>
                <?php endif; ?>
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
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="contacto.php" class="contact-btn">Más Información</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="financiacion-card">
                <h5>Financiación a 24 Meses</h5>
                <p>Plazo: 24 meses</p>
                <p>Interés: 6.2% anual</p>
                <p>Cuota mensual: 250€</p>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="contacto.php" class="contact-btn">Más Información</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="financiacion-card">
                <h5>Financiación a 36 Meses</h5>
                <p>Plazo: 36 meses</p>
                <p>Interés: 6.9% anual</p>
                <p>Cuota mensual: 180€</p>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="contacto.php" class="contact-btn">Más Información</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<h3>Simula tu Financiación</h3>
<form id="simulador-form" class="mb-4">
    <div class="row g-3">
        <div class="col-md-4">
            <label for="importe" class="form-label">Importe a financiar (€):</label>
            <input type="number" class="form-control" id="importe" required>
        </div>
        <div class="col-md-4">
            <label for="plazo" class="form-label">Plazo (meses):</label>
            <select class="form-select" id="plazo" required>
                <option value="12">12 meses (5.5% interés)</option>
                <option value="24">24 meses (6.2% interés)</option>
                <option value="36">36 meses (6.9% interés)</option>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Calcular Cuota</button>
        </div>
    </div>
</form>

<div id="resultado-cuota" class="alert alert-info" style="display:none;"></div>

<div class="location-contact">
    <p><strong>Visítanos:</strong> Av. de America, Córdoba, España</p>
</div>

<a href="https://wa.me/608602302" class="whatsapp-btn" target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>

<footer>
    <p>&copy; 2025 Concesionario Manzano. Todos los derechos reservados.</p>
    <p>Telefono contacto: +34 608 60 23 02</p>
    <p><a href="politicaPrivacidad.php" style="color: white;">Política de Privacidad</a> | <a href="politicaCookies.php" style="color: white;">Política de Cookies</a></p>
</footer>
<script>
    //pequeño script para el simulador de financiación
    document.getElementById('simulador-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const importe = parseFloat(document.getElementById('importe').value);
        const plazo = parseInt(document.getElementById('plazo').value);

        let interesAnual;
        if (plazo === 12) interesAnual = 5.5;
        else if (plazo === 24) interesAnual = 6.2;
        else interesAnual = 6.9;

        const interesMensual = interesAnual / 12 / 100;
        const cuota = (importe * interesMensual) / (1 - Math.pow(1 + interesMensual, -plazo));
        const cuotaRedondeada = cuota.toFixed(2);

        const resultado = document.getElementById('resultado-cuota');
        resultado.style.display = 'block';
        resultado.textContent = `Cuota estimada: ${cuotaRedondeada} €/mes durante ${plazo} meses.`;
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="fR533L_q2EJkWgWU9cATj";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body>
</html>


