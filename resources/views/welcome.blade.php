<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos - Control de Existencias SENA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    
        body {
            background-color: #f5f5f5;
            color: #2d2d2d;
            line-height: 1.6;
            overflow-x: hidden;
        }
    
        /* Navegación */
        .navbar {
            background: linear-gradient(90deg, #15803d 0%, #1a9e4a 100%);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: background 0.3s ease;
        }
    
        .navbar .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
    
        .navbar .logo i {
            color: #fff;
            font-size: 1.75rem;
            transition: transform 0.3s ease;
        }
    
        .navbar .logo i:hover {
            transform: rotate(20deg);
        }
    
        .navbar .logo span {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
    
        .navbar .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
        }
    
        .navbar .nav-links a:hover {
            background: #fff;
            color: #15803d;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
    
        .navbar .nav-links a + a {
            margin-left: 1rem;
        }
    
        /* Sección principal (Hero) */
        .hero {
            position: relative;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('img/fondo.jpg') }}') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            overflow: hidden;
        }
    
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(21, 128, 61, 0.1);
            z-index: 1;
        }
    
        .hero-content {
            max-width: 900px;
            padding: 0 1.5rem;
            z-index: 2;
            animation: fadeInUp 1s ease-out;
        }
    
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.5);
            line-height: 1.2;
        }
    
        .hero p {
            font-size: 1.3rem;
            font-weight: 300;
            max-width: 700px;
            margin: 0 auto 2.5rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
        }
    
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }
    
        .cta-buttons a {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
    
        .cta-buttons a i {
            margin-right: 0.5rem;
        }
    
        .cta-buttons .btn-primary {
            background: #15803d;
            color: #fff;
        }
    
        .cta-buttons .btn-primary:hover {
            background: #1a9e4a;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        }
    
        .cta-buttons .btn-secondary {
            background: #fff;
            color: #15803d;
            border: 2px solid #15803d;
        }
    
        .cta-buttons .btn-secondary:hover {
            background: #15803d;
            color: #fff;
            border-color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        }
    
        /* Sección de información */
        .info-section {
            padding: 5rem 2rem;
            background: linear-gradient(180deg, #fff 0%, #f8f9fa 100%);
            text-align: center;
        }
    
        .info-section h2 {
            font-size: 2.5rem;
            font-weight: 600;
            color: #15803d;
            margin-bottom: 1.5rem;
            position: relative;
        }
    
        .info-section h2::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: #15803d;
            border-radius: 2px;
        }
    
        .info-section p {
            max-width: 900px;
            margin: 0 auto 3rem;
            font-size: 1.15rem;
            color: #4a4a4a;
            font-weight: 400;
        }
    
        /* Sección de características */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
    
        .feature-item {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
        }
    
        .feature-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border-color: #15803d;
        }
    
        .feature-item i {
            color: #15803d;
            font-size: 2.5rem;
            margin-bottom: 1.25rem;
            transition: color 0.3s ease;
        }
    
        .feature-item:hover i {
            color: #1a9e4a;
        }
    
        .feature-item h3 {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2d2d2d;
            margin-bottom: 0.75rem;
        }
    
        .feature-item p {
            font-size: 0.95rem;
            color: #666;
            font-weight: 400;
        }
    
        /* Footer */
        .footer {
            background: linear-gradient(90deg, #15803d 0%, #1a9e4a 100%);
            color: #fff;
            text-align: center;
            padding: 1.5rem;
            position: relative;
            width: 100%;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
    
        .footer p {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 300;
        }
    
        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    
        /* Responsividad */
        @media (max-width: 1024px) {
            .hero h1 {
                font-size: 2.8rem;
            }
    
            .hero p {
                font-size: 1.15rem;
            }
    
            .features {
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            }
        }
    
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 1rem;
                gap: 1rem;
            }
    
            .navbar .logo span {
                font-size: 1.25rem;
            }
    
            .navbar .nav-links a {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }
    
            .navbar .nav-links a + a {
                margin-left: 0;
                margin-top: 0.75rem;
            }
    
            .hero {
                height: 80vh;
            }
    
            .hero h1 {
                font-size: 2.2rem;
            }
    
            .hero p {
                font-size: 1rem;
                max-width: 90%;
            }
    
            .cta-buttons {
                flex-direction: column;
                gap: 1rem;
            }
    
            .cta-buttons a {
                padding: 0.65rem 1.5rem;
                font-size: 1rem;
            }
    
            .info-section {
                padding: 3rem 1.5rem;
            }
    
            .info-section h2 {
                font-size: 2rem;
            }
    
            .info-section p {
                font-size: 1rem;
            }
    
            .features {
                grid-template-columns: 1fr;
            }
    
            .feature-item {
                max-width: 350px;
                margin: 0 auto;
            }
        }
    
        @media (max-width: 480px) {
            .hero h1 {
                font-size: 1.8rem;
            }
    
            .hero p {
                font-size: 0.9rem;
            }
    
            .cta-buttons a {
                font-size: 0.9rem;
                padding: 0.6rem 1.2rem;
            }
    
            .info-section h2 {
                font-size: 1.75rem;
            }
    
            .feature-item {
                padding: 1.5rem;
            }
    
            .feature-item h3 {
                font-size: 1.2rem;
            }
    
            .feature-item p {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navegación -->
    <nav class="navbar">
        <div class="logo">
            <i class="fas fa-egg"></i>
            <span>Control de Existencias SENA</span>
        </div>
        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Ingresar</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Registrarse</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Sección principal con imagen de fondo -->
    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenidos al Control de Existencias del SENA</h1>
            <p>Gestiona eficientemente las existencias de productos como huevos y otros recursos en el SENA, manteniendo un seguimiento semanal de entradas y salidas para generar reportes al tener el control de cada movimiento de entradas y salidas en el inventario.</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="btn-primary"><i class="fas fa-user-plus mr-1"></i> Registrarse</a>
                <a href="{{ route('login') }}" class="btn-secondary"><i class="fas fa-sign-in-alt mr-1"></i> Ingresar</a>
            </div>
        </div>
    </section>

    <!-- Sección de información -->
    <section class="info-section">
        <h2>¿Qué ofrecemos?</h2>
        <p>En el sistema de control de existencias del SENA, los responsables pueden registrar y monitorear las entradas y salidas de productos como huevos, generar reportes semanales y solicitar ajustes en el inventario. Los administradores supervisan y aprueban estas acciones para garantizar un control detallado y eficiente.</p>
        <div class="features">
            <div class="feature-item">
                <i class="fas fa-boxes fa-2x"></i>
                <h3>Seguimiento de Movimientos</h3>
                <p>Registra y controla las entradas y salidas de productos con precisión.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-chart-line fa-2x"></i>
                <h3>Reportes Semanales</h3>
                <p>Genera reportes detallados para un análisis eficiente del inventario.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-users fa-2x"></i>
                <h3>Roles y Supervisión</h3>
                <p>Colaboración entre responsables y administradores para un manejo óptimo.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>© {{ date('Y') }} Control de Existencias SENA. Todos los derechos reservados.</p>
    </footer>
</body>
</html>