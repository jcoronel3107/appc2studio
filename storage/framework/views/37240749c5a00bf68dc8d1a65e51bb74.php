echo '<!DOCTYPE html>
<html lang="<?php echo e(str_replace("_", "-", app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>APU System - Gestión de Análisis de Precios Unitarios</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 60px 20px;
            color: white;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 0 10px;
        }
        
        .btn-primary {
            background: #28a745;
            color: white;
        }
        
        .btn-primary:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #007bff;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .feature-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        .feature-card h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 22px;
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.6;
        }
        
        .image-gallery {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        
        .image-gallery h2 {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            font-size: 32px;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .gallery-item {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .gallery-item .caption {
            padding: 15px;
            text-align: center;
            background: white;
        }
        
        .gallery-item .caption p {
            color: #333;
            font-weight: 500;
        }
        
        footer {
            background: rgba(0,0,0,0.3);
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
        
        @media (max-width: 768px) {
            .hero h1 { font-size: 32px; }
            .hero p { font-size: 16px; }
            .btn { display: block; margin: 10px auto; width: 200px; }
        }
    </style>
</head>
<body>
    <div class="hero">
        <h1>🏗️ Metrik System</h1>
        <p>Ingenieria con Precision</p>
        <div>
            <a href="<?php echo e(route("login")); ?>" class="btn btn-primary">🔐 Iniciar Sesión</a>
            <a href="<?php echo e(route("register")); ?>" class="btn btn-secondary">📝 Registrarse</a>
        </div>
    </div>
    
    <div class="features">
        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <h3>Análisis de Precios Unitarios</h3>
            <p>Gestiona y calcula APUs de manera profesional con todas las secciones: equipos, mano de obra, materiales y transporte.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📦</div>
            <h3>Catálogo de Materiales</h3>
            <p>Administra tu lista de materiales con precios, categorías y términos. Importa y exporta desde Excel.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🖥️</div>
            <h3>Catálogo de Equipos</h3>
            <p>Gestiona equipos, tarifas por hora, consumo de combustible y más. Integración total con tus APUs.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📥</div>
            <h3>Importación desde Excel</h3>
            <p>Importa APUs, materiales y equipos directamente desde archivos Excel con formato estándar.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📤</div>
            <h3>Exportación de Reportes</h3>
            <p>Exporta tus análisis a Excel con formato profesional, listos para presentar a clientes.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔐</div>
            <h3>Seguridad y Control</h3>
            <p>Sistema con autenticación de usuarios, cada quien gestiona sus propios análisis.</p>
        </div>
    </div>
    
    <div class="image-gallery">
        <h2>📸 Galería del Sistema</h2>
        <div class="gallery-grid">
            <div class="gallery-item">
                <div style="background: #e0f2fe; height: 200px; display: flex; align-items: center; justify-content: center; font-size: 64px;">📋</div>
                <div class="caption"><p>Listado de APUs</p></div>
            </div>
            <div class="gallery-item">
                <div style="background: #dcfce7; height: 200px; display: flex; align-items: center; justify-content: center; font-size: 64px;">📊</div>
                <div class="caption"><p>Dashboard Estadístico</p></div>
            </div>
            <div class="gallery-item">
                <div style="background: #fef9c3; height: 200px; display: flex; align-items: center; justify-content: center; font-size: 64px;">📦</div>
                <div class="caption"><p>Catálogo de Materiales</p></div>
            </div>
            <div class="gallery-item">
                <div style="background: #fed7aa; height: 200px; display: flex; align-items: center; justify-content: center; font-size: 64px;">🖥️</div>
                <div class="caption"><p>Catálogo de Equipos</p></div>
            </div>
        </div>
    </div>
    
    <footer>
        <p>&copy; <?php echo e(date("Y")); ?> APU System - Sistema de Gestión de Análisis de Precios Unitarios</p>
        <p style="margin-top: 10px; font-size: 12px;">Desarrollado con Laravel | SQLite | Excel</p>
    </footer>
</body>
</html>' > resources/views/welcome.blade.php<?php /**PATH D:\Desarrollo\app2sintent\appc2studio\resources\views/welcome.blade.php ENDPATH**/ ?>