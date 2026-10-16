# 🛒 Aurea Store

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)

Plataforma web de comercio electrónico enfocada en la gestión de catálogo, variantes físicas de productos. El proyecto demuestra la implementación de arquitectura MVC, modelos relacionales complejos y componentes reactivos en el servidor.

---

## 🎯 Arquitectura Backend y Lógica de Negocio

* **Modelado de Datos Relacional Complejo:** Esquema normalizado para la gestión de categorías jerárquicas (categoría principal y subcategorías con slugs), catálogo de productos, variantes por SKUs, atributos dinámicos e imágenes.
* **Procesamiento y Gestión de Pedidos:** Estructura de modelos y migraciones diseñada para garantizar la integridad referencial en transacciones de compras y pedidos.
* **Componentes Reactivos con Livewire 3 & Volt:** Módulos administrativos para la gestión en tiempo real de categorías sin recarga de página.
* **Seguridad y Control de Acceso:** Área administrativa protegida por autenticación con soporte para renovación de credenciales, ajustes de apariencia y autenticación de dos factores (2FA).

---

## 🛠️ Tecnologías Utilizadas

* **Core Backend:** PHP 8.2+ / Laravel 12
* **Reactividad Server-Side:** Livewire 3, Volt & Flux
* **Base de Datos:** SQLite / MySQL / PostgreSQL (Configurable en `.env`)
* **Frontend & Assets:** Blade, Vite, Tailwind CSS 4
* **Testing:** Pest / PHPUnit

---

## 🏗️ Estructura del Proyecto

```text
app/
├── Livewire/        # Componentes reactivos del panel administrativo
└── Models/          # Modelos relacionales (Categories, Products, SKUs, Orders)
database/
├── migrations/      # Definición de tablas y claves foráneas
└── seeders/         # Carga de datos de prueba para entorno local
resources/views/     # Vistas Blade e interfaces Livewire
routes/              # Definición de rutas públicas y protegidas (/admin)
```
## Instalación

Clona el repositorio y entra en el directorio del proyecto:

```bash
git clone https://github.com/r0dry008/aurea-store.git
cd aurea-store
```

Instala las dependencias, prepara `.env`, genera la clave de la aplicación, ejecuta las migraciones y compila los recursos:

```bash
composer run setup
```

Si prefieres usar otro motor de base de datos, configura sus valores en `.env` antes de ejecutar las migraciones.

## Desarrollo

Para cargar los datos de ejemplo definidos por el seeder:

```bash
php artisan db:seed
```

Inicia el servidor de Laravel:

```bash
composer run dev
```

Abre la URL local que indique Laravel (normalmente `http://localhost:8000`). Las rutas administrativas requieren iniciar sesión y están bajo el prefijo `/admin`.

Para ejecutar únicamente las migraciones:

```bash
php artisan migrate
```

## Pruebas

Ejecuta la suite de pruebas con:

```bash
composer run test
```

## Autor

Rodrigo - Desarrollador Backend (PHP / Laravel)
GitHub: github.com/r0dry008
LinkedIn: linkedin.com/in/rodrigo-lagos-mamani-125558360