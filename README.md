# Laravel Blog

Un blog moderno construido con Laravel 12, Livewire, Tailwind CSS y Vite.

## 🚀 Tecnologías

- **Backend**: Laravel 12
- **Frontend**: Livewire, Tailwind CSS 4
- **Build Tool**: Vite 6
- **Base de Datos**: MySQL 8.0
- **Servidor Web**: Nginx
- **Contenedores**: Docker & Docker Compose
- **Automatización**: Make

## 📋 Requisitos Previos

- Docker
- Docker Compose
- Make (opcional, pero recomendado)

## 🛠️ Instalación Rápida

### Opción 1: Con Make (Recomendado)

```bash
# Instalar y configurar todo el proyecto
make install
```

### Opción 2: Manual

```bash
# 1. Clonar el repositorio
git clone <url-del-repositorio>
cd blog

# 2. Crear archivo .env
cp env.example .env

# 3. Construir y levantar contenedores
docker-compose build
docker-compose up -d

# 4. Ejecutar migraciones y seeders
docker-compose exec laravel-blog-app php artisan migrate --force
docker-compose exec laravel-blog-app php artisan key:generate --force
docker-compose exec laravel-blog-app php artisan storage:link
docker-compose exec laravel-blog-app php artisan db:seed --force
```

## 🌐 Acceso

- **Aplicación**: http://localhost:8080
- **Base de Datos**: localhost:3307
  - Usuario: `laravel`
  - Contraseña: `laravel`
  - Base de datos: `laravel`

## 🔧 Comandos Make Disponibles

### Comandos Principales
```bash
make help          # Ver todos los comandos disponibles
make install       # Instalar proyecto completo
make up            # Levantar servicios
make down          # Detener servicios
make restart       # Reiniciar servicios
make build         # Construir imágenes Docker
```

### Desarrollo
```bash
make shell         # Acceder al contenedor de la aplicación
make logs          # Ver logs de todos los servicios
make logs-app      # Ver logs de la aplicación
make logs-db       # Ver logs de la base de datos
make dev           # Levantar servicios con Vite para desarrollo
```

### Laravel
```bash
make migrate       # Ejecutar migraciones
make migrate-fresh # Ejecutar migraciones desde cero
make seed          # Ejecutar seeders
make fresh         # Ejecutar migraciones y seeders desde cero
make key           # Generar clave de aplicación
make storage-link  # Crear enlace simbólico para storage
make artisan cmd="list"  # Ejecutar comando Artisan personalizado
```

### Dependencias
```bash
make composer-install  # Instalar dependencias de Composer
make composer-update   # Actualizar dependencias de Composer
make composer-dump     # Regenerar autoloader
make npm-install       # Instalar dependencias de NPM
make npm-dev           # Ejecutar Vite en modo desarrollo
make npm-build         # Construir assets de producción
```

### Base de Datos
```bash
make db-shell         # Acceder al shell de MySQL
make db-backup        # Crear backup de la base de datos
```

### Testing
```bash
make test             # Ejecutar tests
make test-coverage    # Ejecutar tests con cobertura
```

### Cache
```bash
make cache-clear      # Limpiar todas las cachés
make cache-optimize   # Optimizar cachés
```

### Limpieza
```bash
make clean            # Limpiar contenedores, volúmenes e imágenes
```

## 📁 Estructura del Proyecto

```
blog/
├── app/                 # Lógica de la aplicación
│   ├── Http/           # Controladores y Requests
│   ├── Livewire/       # Componentes Livewire
│   ├── Models/         # Modelos Eloquent
│   └── Services/       # Servicios
├── config/             # Configuraciones
├── database/           # Migraciones, seeders y factories
├── resources/          # Vistas, CSS, JS
├── routes/             # Definición de rutas
├── storage/            # Archivos generados
├── tests/              # Tests
├── docker-compose.yml  # Configuración de Docker Compose
├── Dockerfile          # Imagen de la aplicación
├── Makefile            # Comandos de automatización
└── env.example         # Variables de entorno de ejemplo
```

## 🔄 Flujo de Desarrollo

1. **Iniciar el proyecto**:
   ```bash
   make install
   ```

2. **Desarrollo diario**:
   ```bash
   make up              # Levantar servicios
   make shell           # Acceder al contenedor
   make logs            # Ver logs
   ```

3. **Desarrollo con hot reload**:
   ```bash
   make dev             # Levantar con Vite
   ```

4. **Después de cambios en dependencias**:
   ```bash
   make composer-install  # Si cambiaste composer.json
   make npm-install       # Si cambiaste package.json
   ```

5. **Después de cambios en la base de datos**:
   ```bash
   make migrate          # Ejecutar nuevas migraciones
   ```

## 🐛 Troubleshooting

### Problemas Comunes

**Error de permisos en storage**:
```bash
make shell
chmod -R 775 storage bootstrap/cache
```

**Base de datos no conecta**:
```bash
make down
make up
# Esperar 30 segundos para que MySQL esté listo
```

**Cache corrupta**:
```bash
make cache-clear
```

**Problemas con Vite**:
```bash
make npm-build
```

### Verificar Estado de Servicios
```bash
docker-compose ps
```

### Ver Logs Detallados
```bash
make logs-app
make logs-db
```

## 📝 Variables de Entorno

El archivo `env.example` contiene todas las variables necesarias. Las principales son:

- `APP_URL`: URL de la aplicación (http://localhost:8080)
- `DB_HOST`: Host de la base de datos (db)
- `DB_DATABASE`: Nombre de la base de datos (laravel)
- `DB_USERNAME`: Usuario de la base de datos (laravel)
- `DB_PASSWORD`: Contraseña de la base de datos (laravel)

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 🆘 Soporte

Si tienes problemas o preguntas:

1. Revisa la sección de troubleshooting
2. Ejecuta `make help` para ver todos los comandos disponibles
3. Revisa los logs con `make logs`
4. Abre un issue en el repositorio
