
1. Dar permisos correctos a las carpetas
bash

# Dar permisos a la carpeta storage
chmod -R 755 storage
chmod -R 755 storage/app/public
chmod -R 755 storage/app/public/apu_files

# Dar permisos específicos a los archivos
find storage/app/public/apu_files -type f -exec chmod 644 {} \

2. Verificar los permisos de la carpeta public/storage
bash

chmod -R 755 public/storage

3. Si usas cPanel, es posible que necesites configurar .htacces

✅ Resumen de lo que hemos construido
📋 Sistema de Presupuestos

    ✅ Cabecera completa con todos los campos solicitados

    ✅ Selector de APUs con buscador (Select2)

    ✅ Cálculo automático de subtotales y total

    ✅ Cálculo automático de fecha de terminación

    ✅ CRUD completo (Crear, Leer, Actualizar, Eliminar)

📊 Todos los módulos funcionando:
Módulo	Estado
Materiales	✅
Equipos	✅
Mano de Obra	✅
Transporte	✅
APUs	✅
Presupuestos	✅
Dashboard	✅
Resumen final de la estructura
text

📚 CAPÍTULO (ej: 1 - Movimiento de Tierras)
    🎯 HITO (ej: 1.1 - Excavaciones)
        📁 CATEGORÍA (ej: 1.1.1 - Excavación en suelo)
            📋 APU 1
            📋 APU 2
        📁 CATEGORÍA (ej: 1.1.2 - Excavación en roca)
            📋 APU 3
    🎯 HITO (ej: 1.2 - Rellenos)
        📁 CATEGORÍA (ej: 1.2.1 - Relleno compactado)
            📋 APU 4

📊 Totales mostrados:
Nivel	Total	Ubicación
Por Capítulo	✅	Resumen superior + dentro del capítulo
Por Hito	✅	Resumen superior + dentro del hito
Por Categoría	✅	Resumen superior + dentro de la categoría
Total APUs	✅	Total general
Monto Anticipo	✅	Resta del total
Total Presupuesto	✅	Valor final
🎯 URLs disponibles:
URL	Función
/budgets	Listado de presupuestos
/budgets/create-chapter	Crear presupuesto por capítulos
/budgets/create-with-milestones	Crear presupuesto por hitos
/budgets/show-chapter/{id}	Ver presupuesto con estructura completa
/budgets/show-with-milestones/{id}	Ver presupuesto por hitos

=============================TENANT=======================================================
¡Excelente! 🎉 Ya tienes el listado de tenants funcionando. Ahora te explico cómo funciona el sistema multi-tenant con SQLite cuando contratas un nuevo cliente.
📊 Flujo completo para un nuevo cliente
1. El cliente se registra o el administrador lo crea

Opción A: El administrador crea el cliente desde el panel

    El administrador va a http://localhost:8000/admin/tenants

    Hace clic en "➕ Nuevo Cliente"

    Completa los datos:

        Nombre de la Empresa: Ej: "Constructora XYZ"

        Subdominio: Ej: "xyz" (para acceder a xyz.localhost:8000)

        Email: Ej: "admin@xyz.com"

        Plan: Free / Pro / Enterprise

    Haz clic en "Crear Cliente"

Lo que ocurre automáticamente:
php

// 1. Se crea un archivo SQLite para el cliente
database/tenants/xyz.sqlite

// 2. Se ejecutan todas las migraciones en esa base de datos
// (se crean todas las tablas: users, apus, materials, etc.)

// 3. Se registra el tenant en la tabla principal
tenants: {
    id: 1,
    name: 'Constructora XYZ',
    subdomain: 'xyz',
    database_path: 'database/tenants/xyz.sqlite',
    email: 'admin@xyz.com',
    plan: 'free',
    is_active: true
}

2. El cliente accede a su sistema

El cliente ingresa a su subdominio:
text

http://xyz.localhost:8000/login

Lo que ocurre:

    El middleware TenantMiddleware detecta el subdominio xyz

    Busca en la tabla tenants el registro con subdomain = 'xyz'

    Cambia la conexión de base de datos a database/tenants/xyz.sqlite

    Todas las consultas ahora van a la base de datos del cliente

3. El cliente se registra o inicia sesión

Cuando el cliente se registra:
php

// El usuario se crea en la base de datos del cliente (xyz.sqlite)
User::create([
    'name' => 'Juan Pérez',
    'email' => 'juan@xyz.com',
    'password' => bcrypt('password'),
    'tenant_id' => null // No se usa porque el tenant ya está definido por el subdominio
]);

4. El cliente usa el sistema

Todos los datos que el cliente crea (APUs, materiales, presupuestos) se guardan SOLO en su base de datos:
text

DATOS DEL CLIENTE XYZ:
├── materials (tabla en xyz.sqlite)
├── apus (tabla en xyz.sqlite)
├── budgets (tabla en xyz.sqlite)
└── labors (tabla en xyz.sqlite)

DATOS DEL CLIENTE ABC (otro cliente):
├── materials (tabla en abc.sqlite)
├── apus (tabla en abc.sqlite)
├── budgets (tabla en abc.sqlite)
└── labors (tabla en abc.sqlite)

5. Aislamiento total de datos

Cada cliente tiene su propia base de datos SQLite:
text

📁 database/
├── 📄 database.sqlite          ← Base de datos MAESTRA (tenants, usuarios admin)
├── 📁 tenants/
│   ├── 📄 xyz.sqlite           ← Datos de Constructora XYZ
│   ├── 📄 abc.sqlite           ← Datos de Constructora ABC
│   └── 📄 empresa1.sqlite      ← Datos de Empresa 1

🔐 Diagrama de flujo completo:
text

┌─────────────────────────────────────────────────────────────────────┐
│                    ADMINISTRADOR DEL SISTEMA                        │
│  - Crea tenants (clientes)                                         │
│  - Gestiona suscripciones                                          │
│  - Ve todos los tenants                                            │
└─────────────────────────────────────────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────────────┐
│                  BASE DE DATOS MAESTRA (database.sqlite)            │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │  Tabla: tenants                                             │   │
│  │  id │ name          │ subdomain │ email                 │   │   │
│  │  1  │ Constructora XYZ │ xyz     │ admin@xyz.com        │   │   │
│  │  2  │ Constructora ABC │ abc     │ admin@abc.com        │   │   │
│  └─────────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────┘
                    │                        │
                    ▼                        ▼
┌───────────────────────────────┐ ┌───────────────────────────────┐
│   BASE DE DATOS CLIENTE XYZ   │ │   BASE DE DATOS CLIENTE ABC   │
│   (database/tenants/xyz.sqlite)│ │   (database/tenants/abc.sqlite)│
│  ┌─────────────────────────┐ │ │  ┌─────────────────────────┐   │
│  │ Tabla: users            │ │ │  │ Tabla: users            │   │
│  │ Juan Pérez              │ │ │  │ María Gómez             │   │
│  │ admin@xyz.com           │ │ │  │ admin@abc.com           │   │
│  │ (solo ve sus datos)     │ │ │  │ (solo ve sus datos)     │   │
│  ├─────────────────────────┤ │ │  ├─────────────────────────┤   │
│  │ Tabla: materials        │ │ │  │ Tabla: materials        │   │
│  │ - Cemento (25.50)       │ │ │  │ - Arena (45.00)         │   │
│  │ - Acero (85.00)         │ │ │  │ - Grava (30.00)         │   │
│  ├─────────────────────────┤ │ │  ├─────────────────────────┤   │
│  │ Tabla: apus             │ │ │  │ Tabla: apus             │   │
│  │ - APU001 (Construcción) │ │ │  │ - APU005 (Cimentación)  │   │
│  ├─────────────────────────┤ │ │  ├─────────────────────────┤   │
│  │ Tabla: budgets          │ │ │  │ Tabla: budgets          │   │
│  │ - Presupuesto Obra 1    │ │ │  │ - Presupuesto Obra 2    │   │
│  └─────────────────────────┘ │ │  └─────────────────────────┘   │
└───────────────────────────────┘ └───────────────────────────────┘

🌐 URLs de acceso:
Cliente	URL de acceso
Constructora XYZ	http://xyz.localhost:8000
Constructora ABC	http://abc.localhost:8000
Nuevo cliente	http://[subdominio].localhost:8000

===================================================================================









🚀 Mejoras futuras sugeridas

Cuando quieras mejorar, aquí hay algunas ideas:

    Exportar presupuesto a PDF - Generar documento profesional

    Exportar presupuesto a Excel - Para enviar a clientes

    Imprimir presupuesto - Formato de impresión

    Gráficas - Visualización de costos por APU

    Comparativa de presupuestos - Versiones anteriores

    Aprobaciones - Flujo de aprobación de presupuestos

    Notificaciones - Alertas por correo

    Plantillas - Guardar plantillas de presupuestos
## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
