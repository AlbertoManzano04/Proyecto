<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Concesionario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
            background-color: lightgray;
        }
    header {
    background: url('./images/concesionario1.jpg') no-repeat center/cover;
    color: white;
    padding: 2rem 0;
    text-align: center;
}
footer{
    background: url('./images/contacto1.avif') no-repeat center/cover;
    color: darkblue;
    font-weight: bold;
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
    </style>
</head>
<header>
    <h1>Contacta con Nosotros</h1>
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
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4">Contáctanos</h2>
                <form id="contactForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
            <div class="col-md-6">
                <h2 class="mb-4">Nuestra Ubicación</h2>
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d317713.67645747284!2d-0.4824852373897965!3d39.4699014201671!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6046298c6a7d5f%3A0x9b5eebcd5e2d0a50!2sValencia%2C%20Espa%C3%B1a!5e0!3m2!1ses!2ses!4v1688498481721!5m2!1ses!2ses" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>Concesionarios Alberto- Tu mejor opción siempre</p>
    </footer>
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Gracias por contactarnos. Nos pondremos en contacto contigo pronto.');
            this.reset();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

