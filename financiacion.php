<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - Tu mejor opción</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: lightgray;
        }
        header {
            background: url('./images/concesionario1.jpg') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
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
        main {
            padding: 2rem;
        }
        section {
            margin-bottom: 2rem;
            text-align: center;
        }
        footer {
            background-color: #004A99;
            color: white;
            text-align: center;
            padding: 1rem 0;
        }
        h1, h2 {
            color: darkblue;
        }
        p {
            color: darkblue;
        }
        #financiacion {
            background-color: #F4F4F4;
            padding: 3rem 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .financiacion-texto {
            font-size: 1.1rem;
            color: #333;
            line-height: 1.6;
        }
        .btn-financiacion {
            background-color: #004A99;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-financiacion:hover {
            background-color: #003366;
        }
    </style>
</head>
<body>

<header>
    <h1>Bienvenido a Nuestro Concesionario</h1>
    <p>Encuentra el coche de tus sueños con las mejores condiciones</p>
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
                <li class="nav-item"><a href="subeTuCoche.php" class="nav-link">sube tu coche</a></li>
                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<main>
    <section id="vehiculos">
        <h2>Algunos De Nuestros Vehículos</h2>
        <div class="carousel-container">
            <!-- Aquí puedes insertar tu carrusel de vehículos -->
        </div>
    </section>

    <section id="financiacion">
        <h2>Financiación y Venta de Vehículos</h2>
        <p class="financiacion-texto">
            ¿Quieres vender tu coche o comprar uno nuevo a 0 km? ¡Estamos aquí para ayudarte!<br><br>

            En <strong>Concesionarios Manzano</strong>, te ofrecemos las mejores opciones de <strong>financiación</strong> para que puedas vender tu coche actual y adquirir un vehículo nuevo a <strong>0 km</strong> sin complicaciones. Nuestros asesores financieros están listos para ayudarte a encontrar el plan que más se ajuste a tus necesidades.<br><br>

            <strong>¿Vendes tu coche?</strong> Si estás buscando vender tu vehículo, ¡nos encargamos de todo! Podemos valorar tu coche rápidamente y ofrecerte una tasación justa. Además, si decides venderlo a través de nuestro concesionario, podemos ofrecerte una <strong>descuento exclusivo</strong> en tu compra.<br><br>

            <strong>¿Buscas un coche nuevo?</strong> Si prefieres un coche totalmente nuevo, con <strong>0 km</strong>, tenemos una amplia gama de vehículos de las mejores marcas, listos para ser entregados. Además, gracias a nuestros <strong>planes de financiación personalizados</strong>, podrás conducir el coche de tus sueños con pagos mensuales cómodos y accesibles.<br><br>

            <strong>Nuetros Planes de Financiación:</strong><br>
            <ul>
                <li><strong>Sin entrada inicial</strong>: ¡Sí, has leído bien! Puedes comenzar a pagar desde el primer mes sin necesidad de realizar un pago inicial.</li>
                <li><strong>Plazos flexibles</strong>: Escoge entre plazos que se adapten a tu presupuesto, desde 12 hasta 84 meses.</li>
                <li><strong>Financiación a medida</strong>: Nuestro equipo de expertos trabajará contigo para ofrecerte una financiación adaptada a tus necesidades, asegurando que se ajuste a tus posibilidades económicas.</li>
            </ul>
            <strong>¿Cómo funciona?</strong><br>
            <ol>
                <li><strong>Tasación de tu coche:</strong> Trae tu vehículo y nosotros lo evaluamos en menos de 30 minutos.</li>
                <li><strong>Aprobación del crédito:</strong> Te ayudamos a obtener la financiación más conveniente con una aprobación rápida y sencilla.</li>
                <li><strong>Entrega inmediata:</strong> Una vez aprobado tu crédito, podrás elegir el coche que más te guste y llevártelo al instante.</li>
            </ol>
            <a href="contacto.php" class="btn-financiacion">Contáctanos para más información</a>
        </p>
    </section>
</main>

<footer>
    <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
</footer>

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
