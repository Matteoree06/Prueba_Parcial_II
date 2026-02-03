# Sistema de Simulación de Inversiones Financieras

## Descripción del Proyecto

Este sistema permite a los usuarios simular inversiones financieras optimizando automáticamente su portafolio para maximizar ganancias según su capital disponible. La aplicación implementa algoritmos de optimización para seleccionar la mejor combinación de productos financieros.

### Características Principales
- ✅ Gestión de usuarios con capital disponible
- ✅ Catálogo de productos financieros con costos y retornos
- ✅ Algoritmo de optimización de portafolio
- ✅ Simulaciones con cálculo automático de ganancias
- ✅ Historial de simulaciones por usuario
- ✅ API RESTful con respuestas JSON estructuradas

## Tecnologías Utilizadas

### Backend
- **Laravel 11** - Framework PHP
- **PHP 8.3** - Lenguaje de programación
- **MySQL 8.0** - Base de datos relacional
- **Composer** - Gestor de dependencias

### Arquitectura
- **Repository Pattern** - Abstracción de datos
- **Service Layer** - Lógica de negocio
- **DTOs (Data Transfer Objects)** - Transferencia de datos
- **Factory Pattern** - Generación de datos de prueba

### DevOps y Contenedores
- **Docker & Docker Compose** - Containerización
- **Artisan Commands** - Comandos de Laravel
- **Database Seeders** - Datos iniciales

## Instalación y Ejecución

### Opción 1: Con Docker (Recomendado)

```bash
# Clonar el repositorio
git clone <url-repositorio>
cd prueba_parcial

# Crear archivo de configuración
cp .env.docker .env

# Construir y levantar contenedores
docker-compose build
docker-compose up -d

# Verificar que los contenedores estén corriendo
docker-compose ps
```

La aplicación estará disponible en: `http://localhost:8000`
PhpMyAdmin disponible en: `http://localhost:8080`

### Opción 2: Instalación Manual

```bash
# Instalar dependencias
composer install

# Configurar base de datos en .env
cp .env.example .env
# Editar .env con tus credenciales de MySQL

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones y seeders
php artisan migrate:fresh --seed

# Iniciar servidor de desarrollo
php artisan serve
```

### Variables de Entorno (.env)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prueba_parcial
DB_USERNAME=root
DB_PASSWORD=tu_password
```

## Estructura de la Base de Datos

### Tablas Principales

```sql
-- Usuarios
usuarios (
    id VARCHAR(255) PRIMARY KEY,
    nombre VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    capital_disponible DECIMAL(10,2)
)

-- Productos Financieros
producto_financiero (
    id VARCHAR(255) PRIMARY KEY,
    nombre VARCHAR(255),
    descripcion TEXT,
    costo DECIMAL(10,2),
    porcentaje_retorno DECIMAL(5,2),
    activo BOOLEAN
)

-- Simulaciones
simulacion (
    id VARCHAR(255) PRIMARY KEY,
    usuario_id VARCHAR(255) FOREIGN KEY,
    fecha_simulacion TIMESTAMP,
    capital_disponible DECIMAL(10,2),
    ganancia_total DECIMAL(10,2),
    productos_seleccionados JSONB
)
```

## Endpoints de la API

### Base URL
`http://localhost:8000/api`

### 1. Gestión de Usuarios

#### GET /usuarios
Obtiene todos los usuarios registrados.

**Respuesta:**
```json
[
    {
        "id": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
        "nombre": "Juan Pérez",
        "email": "juan.perez@email.com",
        "capital_disponible": 5000.00
    }
]
```

### 2. Gestión de Productos

#### GET /productos
Obtiene todos los productos financieros disponibles.

**Respuesta:**
```json
[
    {
        "id": "prod-uuid",
        "nombre": "CDT Tradicional",
        "descripcion": "Certificado de Depósito a Término...",
        "costo": 5000.00,
        "porcentaje_retorno": 8.50,
        "activo": true
    }
]
```

### 3. Simulaciones de Inversión

#### POST /simulaciones
Crea una nueva simulación de inversión optimizada.

**Request Body:**
```json
{
    "usuario_id": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
    "capital_disponible": 3000.00,
    "productos": [
        {
            "nombre": "Fondo Acciones Tech",
            "precio": 1000.00,
            "porcentaje_ganancia": 8.50
        },
        {
            "nombre": "ETF Global",
            "precio": 1500.00,
            "porcentaje_ganancia": 12.00
        }
    ]
}
```

**Respuesta Exitosa:**
```json
{
    "id": "sim-uuid",
    "usuario_id": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
    "fecha_simulacion": "2024-01-15T10:30:00Z",
    "capital_disponible": 3000.00,
    "productos_seleccionados": [
        {
            "nombre": "ETF Global",
            "precio": 1500.00,
            "porcentaje_ganancia": 12.00,
            "ganancia_esperada": 180.00
        },
        {
            "nombre": "Fondo Acciones Tech",
            "precio": 1000.00,
            "porcentaje_ganancia": 8.50,
            "ganancia_esperada": 85.00
        }
    ],
    "costo_total": 2500.00,
    "capital_restante": 500.00,
    "ganancia_total": 265.00,
    "retorno_total_porcentaje": 10.60,
    "mensaje": "Simulación exitosa con ganancias óptimas"
}
```

#### GET /simulaciones/{usuarioId}
Obtiene el historial de simulaciones de un usuario.

**Respuesta:**
```json
[
    {
        "id": "sim-uuid-1",
        "usuario_id": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
        "fecha_simulacion": "2024-01-15T10:30:00Z",
        "capital_disponible": 3000.00,
        "ganancia_total": 265.00,
        "cantidad_productos": 2,
        "retorno_porcentaje": 10.60
    }
]
```

## Algoritmo de Optimización

### Proceso de Cálculo

El sistema implementa un algoritmo de optimización que:

1. **Filtra productos viables** según el capital disponible
2. **Calcula ganancia por producto**: `precio × (porcentaje_retorno / 100)`
3. **Optimiza combinaciones** usando algoritmo greedy mejorado
4. **Selecciona la mejor combinación** que maximice ganancias

### Ejemplo de Optimización

**Capital Disponible:** $3,000.00

| Producto | Precio | % Ganancia | Ganancia Calculada |
|----------|--------|------------|-------------------|
| ETF Global | $1,500.00 | 12.00% | $180.00 |
| Fondo Tech | $1,000.00 | 8.50% | $85.00 |
| Bonos AAA | $500.00 | 5.25% | $26.25 |
| Fondo Dividendos | $800.00 | 6.75% | $54.00 |

**Combinaciones Evaluadas:**

| Combinación | Costo Total | Ganancia Total | Capital Restante |
|-------------|-------------|----------------|------------------|
| ETF + Fondo Tech | $2,500.00 | $265.00 | $500.00 |
| ETF + Dividendos | $2,300.00 | $234.00 | $700.00 |
| Todas menos ETF | $2,300.00 | $165.25 | $700.00 |

**Resultado Óptimo:** ETF Global + Fondo Tech = $265.00 ganancia (10.60% retorno)

## Casos de Respuesta

### 1. Simulación Exitosa
- Capital suficiente para múltiples productos
- Optimización exitosa con buenas ganancias
- Retorno > 8%

### 2. Ganancias Mínimas
- Capital limitado
- Solo algunos productos viables
- Retorno 3-8%

### 3. Fondos Insuficientes
```json
{
    "error": "Fondos insuficientes",
    "detalle": "El capital disponible ($500.00) es insuficiente...",
    "capital_disponible": 500.00,
    "producto_mas_barato": 1200.00,
    "diferencia_necesaria": 700.00,
    "recomendacion": "Aumente su capital o consulte productos..."
}
```

## Datos de Prueba

### Usuarios Precargados
- Juan Carlos Pérez ($75,000)
- María Elena García ($120,000)
- Carlos Roberto López ($95,000)
- Ana Sofia Martínez ($180,000)
- Luis Fernando Torres ($65,000)

### Productos Financieros
- CDT Tradicional ($5,000 - 8.5%)
- Fondo Conservador ($10,000 - 12.25%)
- Acciones Bancarias ($15,000 - 18.75%)
- Bonos Corporativos ($25,000 - 14.8%)
- Fondo Inmobiliario ($50,000 - 22.3%)
- ETF Internacional ($20,000 - 16.45%)
- Criptomonedas Estables ($8,000 - 35.6%)
- Commodities Oro ($30,000 - 11.9%)

## Comandos Útiles

```bash
# Levantar servicios Docker
docker-compose up -d

# Detener servicios Docker
docker-compose down

# Ver logs de la aplicación
docker-compose logs app

# Resetear base de datos con datos frescos
docker-compose exec app php artisan migrate:refresh --seed

# Solo ejecutar seeders
docker-compose exec app php artisan db:seed

# Acceder al contenedor de la aplicación
docker-compose exec app bash

# Limpiar caché (dentro del contenedor)
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear

# Verificar rutas
docker-compose exec app php artisan route:list
```

## Testing

```bash
# Ejecutar tests (cuando estén implementados)
php artisan test

# Test de endpoints con curl
curl -X GET http://localhost:8000/api/usuarios
curl -X GET http://localhost:8000/api/productos
```

## Contribución

1. Fork del proyecto
2. Crear rama para feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crear Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT.
