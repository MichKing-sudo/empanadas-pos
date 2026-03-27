# 🫓 EmpanadasPOS — Sistema de Ventas en Laravel

```
 ███████╗███╗   ███╗██████╗  █████╗ ███╗   ██╗ █████╗ ██████╗  █████╗ ███████╗
 ██╔════╝████╗ ████║██╔══██╗██╔══██╗████╗  ██║██╔══██╗██╔══██╗██╔══██╗██╔════╝
 █████╗  ██╔████╔██║██████╔╝███████║██╔██╗ ██║███████║██║  ██║███████║███████╗
 ██╔══╝  ██║╚██╔╝██║██╔═══╝ ██╔══██║██║╚██╗██║██╔══██║██║  ██║██╔══██║╚════██║
 ███████╗██║ ╚═╝ ██║██║     ██║  ██║██║ ╚████║██║  ██║██████╔╝██║  ██║███████║
 ╚══════╝╚═╝     ╚═╝╚═╝     ╚═╝  ╚═╝╚═╝  ╚═══╝╚═╝  ╚═╝╚═════╝ ╚═╝  ╚═╝╚══════╝
                                                                    P O S  💛
```

> **Sistema web de punto de venta y administración para venta de empanadas y papas rellenas.**  
> Construido con Laravel · Diseñado para rapidez en mostrador · Con reportes visuales de ventas.

---

## 📋 Tabla de Contenidos

- [Descripción General](#-descripción-general)
- [Rutas Principales](#-rutas-principales)
- [Módulos del Sistema](#-módulos-del-sistema)
- [Modelo de Datos](#-modelo-de-datos)
- [Requisitos Técnicos](#-requisitos-técnicos)
- [Instalación](#-instalación)
- [Estructura de Carpetas](#-estructura-de-carpetas)
- [Reglas de Negocio](#-reglas-de-negocio)
- [Informes de Ventas](#-informes-de-ventas)
- [Equipo](#-equipo)

---

## 🌟 Descripción General

**EmpanadasPOS** es un sistema web desarrollado en **Laravel** orientado a la gestión de ventas de una tienda especializada en **empanadas y papas rellenas**. El sistema permite registrar ventas rápidamente desde un punto de venta (POS), administrar el catálogo de productos y clientes, y visualizar informes detallados del desempeño comercial.

```
┌────────────────────────────────────────────────────────┐
│                   EMPANADAS POS                        │
│                                                        │
│   🛒 /pos          →    Punto de Venta (Vendedor)      │
│   ⚙️  /admin        →    Panel de Administración       │
└────────────────────────────────────────────────────────┘
```

---

## 🗺️ Rutas Principales

| Ruta | Descripción | Acceso |
|------|-------------|--------|
| `/pos` | Punto de venta para registro de ventas | Vendedor |
| `/admin` | Panel administrativo con gestión y reportes | Administrador |
| `/admin/productos` | CRUD de productos | Administrador |
| `/admin/clientes` | CRUD de clientes | Administrador |
| `/admin/informes` | Dashboard de informes y estadísticas | Administrador |

---

## 🧩 Módulos del Sistema

### 🛒 Módulo POS — `/pos`

El punto de venta está diseñado para ser **rápido y funcional** en un entorno de mostrador.

```
┌─────────────────────────────────────────────────────────────┐
│  👤 Cliente: [Mostrador ▼]   o   [Buscar / Crear cliente]   │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  🫓 Empanada de Pollo       [+] [-]   Cantidad: 1   $1.500  │
│  🫓 Empanada Hawaiana       [+] [-]   Cantidad: 2   $3.000  │
│  🥔 Papa Mixta              [+] [-]   Cantidad: 3   $4.500  │
│                                                             │
├─────────────────────────────────────────────────────────────┤
│  TOTAL:  $9.000              [ 💳 REGISTRAR VENTA ]         │
└─────────────────────────────────────────────────────────────┘
```

**Funcionalidades:**
- ✅ Cliente de mostrador **por defecto** (sin datos requeridos)
- ✅ Opción de asociar venta a un **cliente específico** (existente o nuevo)
- ✅ Carrito de compras con múltiples productos y cantidades
- ✅ Registro de la venta con detalle de ítems

---

### ⚙️ Módulo Admin — `/admin`

Panel de administración con tres secciones principales:

#### 📦 Gestión de Productos
- Crear, editar y eliminar productos del catálogo
- **Restricción:** No se puede eliminar un producto que tenga ventas registradas
- Campos mínimos: nombre, tipo/categoría, precio, disponibilidad

#### 👥 Gestión de Clientes
- Crear, editar y eliminar clientes
- **Restricción:** No se puede eliminar un cliente con compras registradas
- Datos requeridos por cliente:

| Campo | Tipo |
|-------|------|
| Tipo de documento | Selección (CC, CE, NIT, Pasaporte…) |
| Número de documento | Texto único |
| Nombre completo | Texto |
| Dirección | Texto |
| Ciudad | Texto |
| Teléfono | Texto |

#### 📊 Informes de Ventas
Ver sección detallada más abajo ↓

---

## 🗃️ Modelo de Datos

```
┌──────────────┐       ┌──────────────────┐       ┌───────────────┐
│   clientes   │       │      ventas      │       │   productos   │
├──────────────┤       ├──────────────────┤       ├───────────────┤
│ id           │──────▶│ id               │       │ id            │
│ tipo_doc     │       │ cliente_id (FK)  │       │ nombre        │
│ num_doc      │       │ fecha            │       │ categoria     │
│ nombre       │       │ total            │       │ precio        │
│ direccion    │       │ es_mostrador     │       │ disponible    │
│ ciudad       │       └────────┬─────────┘       │ created_at    │
│ telefono     │                │                 └───────┬───────┘
│ created_at   │                │                         │
└──────────────┘                ▼                         │
                       ┌──────────────────┐               │
                       │  venta_detalles  │               │
                       ├──────────────────┤               │
                       │ id               │               │
                       │ venta_id (FK)    │               │
                       │ producto_id (FK) │───────────────┘
                       │ cantidad         │
                       │ precio_unitario  │
                       │ subtotal         │
                       └──────────────────┘
```

> 🔑 `es_mostrador` en la tabla `ventas` indica si la venta fue sin cliente identificado.  
> Cuando `es_mostrador = true`, el `cliente_id` puede ser nulo o apuntar a un cliente genérico del sistema.

---

## ⚙️ Requisitos Técnicos

| Tecnología | Versión mínima |
|------------|---------------|
| PHP | >= 8.1 |
| Laravel | >= 10.x |
| MySQL / MariaDB | >= 8.0 |
| Node.js | >= 18.x (para assets) |
| Composer | >= 2.x |

**Paquetes sugeridos:**
- `laravel/ui` o **Livewire** para interactividad del POS
- `barryvdh/laravel-dompdf` para exportar informes a PDF *(opcional)*
- `maatwebsite/excel` para exportar datos a Excel *(opcional)*
- **Chart.js** o **ApexCharts** para gráficas en informes

---

## 🚀 Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/tu-usuario/empanadas-pos.git
cd empanadas-pos

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JS
npm install && npm run build

# 4. Configurar entorno
cp .env.example .env
php artisan key:generate

# 5. Configurar base de datos en .env
# DB_DATABASE=empanadas_pos
# DB_USERNAME=root
# DB_PASSWORD=secret

# 6. Ejecutar migraciones y seeders
php artisan migrate --seed

# 7. Levantar servidor local
php artisan serve
```

Visita `http://localhost:8000/pos` para el punto de venta  
Visita `http://localhost:8000/admin` para el panel de administración

---

## 📁 Estructura de Carpetas

```
empanadas-pos/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── POS/
│   │   │   │   └── VentaController.php
│   │   │   └── Admin/
│   │   │       ├── ProductoController.php
│   │   │       ├── ClienteController.php
│   │   │       └── InformeController.php
│   ├── Models/
│   │   ├── Venta.php
│   │   ├── VentaDetalle.php
│   │   ├── Producto.php
│   │   └── Cliente.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── ProductoSeeder.php    ← productos de ejemplo
│       └── ClienteSeeder.php    ← cliente "Mostrador" por defecto
├── resources/
│   └── views/
│       ├── pos/
│       │   └── index.blade.php
│       └── admin/
│           ├── layout.blade.php
│           ├── productos/
│           ├── clientes/
│           └── informes/
└── routes/
    └── web.php
```

---

## 📏 Reglas de Negocio

```
┌─────────────────────────────────────────────────────────────────┐
│  ✅  Una venta puede tener MÚLTIPLES productos                  │
│  ✅  Un producto puede tener MÚLTIPLES cantidades por venta     │
│  ✅  El cliente de mostrador NO requiere datos personales       │
│  ✅  Se puede crear un cliente nuevo directo desde el POS       │
│  ❌  No se pueden vender bebidas ni otros productos             │
│  ❌  No se puede eliminar un producto con ventas registradas    │
│  ❌  No se puede eliminar un cliente con compras registradas    │
└─────────────────────────────────────────────────────────────────┘
```

---

## 📊 Informes de Ventas

El módulo de informes ofrece una visión clara y visual del negocio:

| Informe | Descripción | Visualización |
|---------|-------------|---------------|
| 💰 Ventas por período | Total de ventas diarias, semanales o mensuales | Gráfica de línea |
| 🫓 Ventas por producto | Producto más vendido en cantidad y valor | Gráfica de barras |
| 👤 Tipo de cliente | % clientes de mostrador vs clientes registrados | Gráfica de torta |
| 🏙️ Ciudad de procedencia | Distribución geográfica de clientes | Tabla + gráfica |
| 📋 Listado de ventas | Historial detallado con filtros | Tabla paginada |

---

## 👨‍💻 Equipo


| Jhon Michael Montes Afanador | Desarrollador Full Stack |
| Jairo Andres Ariza Hernandez | Analista de Calidad de Software |
| Sergio Andres Medina Vitola | Analista de Calidad de Software |
| Santiago Andres Garcia Guerrero | Analista De Sistemas/Programador |

---

## 📄 Licencia

Este proyecto es de uso académico. Desarrollado como proyecto de aula para el curso de Desarrollo Web con Laravel.

---

<div align="center">

**Hecho con 💛 y muchas empanadas 🫓**

`/pos` · `/admin` · Laravel · MySQL

</div>
