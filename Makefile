# Makefile para Laravel Blog con Docker
# Uso: make <comando>

.PHONY: help install build up down restart logs shell migrate seed fresh key storage-link test composer npm artisan

# Variables
COMPOSE = docker compose
APP_CONTAINER = laravel-blog-app
DB_CONTAINER = laravel-blog-mysql

# Comando por defecto
help: ## Mostrar esta ayuda
	@echo "🚀 Laravel Blog - Comandos disponibles:"
	@echo ""
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}'
	@echo ""

# Comandos principales
install: ## Instalar y configurar el proyecto completo
	@echo "🚀 Instalando Laravel Blog..."
	@if [ ! -f .env ]; then \
		echo "📝 Creando archivo .env..."; \
		cp env.example .env; \
		echo "✅ Archivo .env creado"; \
	fi
	@echo "🔨 Construyendo contenedores..."
	$(COMPOSE) build
	@echo "🚀 Levantando servicios..."
	$(COMPOSE) up -d
	@echo "⏳ Esperando a que MySQL esté listo..."
	@sleep 30
	@echo "🗄️ Ejecutando migraciones..."
	$(COMPOSE) exec $(APP_CONTAINER) php artisan migrate --force
	@echo "🔑 Generando clave de aplicación..."
	$(COMPOSE) exec $(APP_CONTAINER) php artisan key:generate --force
	@echo "🔗 Creando enlaces simbólicos..."
	$(COMPOSE) exec $(APP_CONTAINER) php artisan storage:link
	@echo "🌱 Ejecutando seeders..."
	$(COMPOSE) exec $(APP_CONTAINER) php artisan db:seed --force
	@echo "✅ ¡Proyecto instalado exitosamente!"
	@echo "🌐 URL: http://localhost:8080"
	@echo "🗄️ MySQL: localhost:3307"

build: ## Construir las imágenes de Docker
	@echo "🔨 Construyendo contenedores..."
	$(COMPOSE) build

up: ## Levantar los servicios
	@echo "🚀 Levantando servicios..."
	$(COMPOSE) up -d

down: ## Detener los servicios
	@echo "🛑 Deteniendo servicios..."
	$(COMPOSE) down

restart: ## Reiniciar los servicios
	@echo "🔄 Reiniciando servicios..."
	$(COMPOSE) restart

logs: ## Ver logs de todos los servicios
	$(COMPOSE) logs -f

logs-app: ## Ver logs de la aplicación
	$(COMPOSE) logs -f $(APP_CONTAINER)

logs-db: ## Ver logs de la base de datos
	$(COMPOSE) logs -f $(DB_CONTAINER)

# Comandos de Laravel
shell: ## Acceder al shell del contenedor de la aplicación
	$(COMPOSE) exec $(APP_CONTAINER) bash

migrate: ## Ejecutar migraciones
	$(COMPOSE) exec $(APP_CONTAINER) php artisan migrate

migrate-fresh: ## Ejecutar migraciones desde cero
	$(COMPOSE) exec $(APP_CONTAINER) php artisan migrate:fresh

seed: ## Ejecutar seeders
	$(COMPOSE) exec $(APP_CONTAINER) php artisan db:seed

fresh: ## Ejecutar migraciones y seeders desde cero
	$(COMPOSE) exec $(APP_CONTAINER) php artisan migrate:fresh --seed

key: ## Generar clave de aplicación
	$(COMPOSE) exec $(APP_CONTAINER) php artisan key:generate

storage-link: ## Crear enlace simbólico para storage
	$(COMPOSE) exec $(APP_CONTAINER) php artisan storage:link

# Comandos de Composer
composer-install: ## Instalar dependencias de Composer
	$(COMPOSE) exec $(APP_CONTAINER) composer install

composer-update: ## Actualizar dependencias de Composer
	$(COMPOSE) exec $(APP_CONTAINER) composer update

composer-dump: ## Regenerar autoloader de Composer
	$(COMPOSE) exec $(APP_CONTAINER) composer dump-autoload

# Comandos de NPM
npm-install: ## Instalar dependencias de NPM
	$(COMPOSE) exec $(APP_CONTAINER) npm install

npm-dev: ## Ejecutar Vite en modo desarrollo
	$(COMPOSE) exec $(APP_CONTAINER) npm run dev

npm-build: ## Construir assets de producción
	$(COMPOSE) exec $(APP_CONTAINER) npm run build

# Comandos de Artisan
artisan: ## Ejecutar comando Artisan (uso: make artisan cmd="migrate")
	$(COMPOSE) exec $(APP_CONTAINER) php artisan $(cmd)

# Comandos de desarrollo
dev: ## Levantar servicios con Vite para desarrollo
	@echo "🚀 Levantando servicios de desarrollo..."
	$(COMPOSE) --profile dev up -d

dev-down: ## Detener servicios de desarrollo
	$(COMPOSE) --profile dev down

# Comandos de limpieza
clean: ## Limpiar contenedores, volúmenes e imágenes
	@echo "🧹 Limpiando Docker..."
	$(COMPOSE) down -v --rmi all
	docker system prune -f

# Comandos de base de datos
db-shell: ## Acceder al shell de MySQL
	$(COMPOSE) exec $(DB_CONTAINER) mysql -u laravel -p laravel

db-backup: ## Crear backup de la base de datos
	@echo "💾 Creando backup de la base de datos..."
	$(COMPOSE) exec $(DB_CONTAINER) mysqldump -u laravel -p laravel > backup_$(shell date +%Y%m%d_%H%M%S).sql

# Comandos de testing
test: ## Ejecutar tests
	$(COMPOSE) exec $(APP_CONTAINER) php artisan test

test-coverage: ## Ejecutar tests con cobertura
	$(COMPOSE) exec $(APP_CONTAINER) php artisan test --coverage

# Comandos de cache
cache-clear: ## Limpiar todas las cachés
	$(COMPOSE) exec $(APP_CONTAINER) php artisan cache:clear
	$(COMPOSE) exec $(APP_CONTAINER) php artisan config:clear
	$(COMPOSE) exec $(APP_CONTAINER) php artisan route:clear
	$(COMPOSE) exec $(APP_CONTAINER) php artisan view:clear

cache-optimize: ## Optimizar cachés
	$(COMPOSE) exec $(APP_CONTAINER) php artisan config:cache
	$(COMPOSE) exec $(APP_CONTAINER) php artisan route:cache
	$(COMPOSE) exec $(APP_CONTAINER) php artisan view:cache

# Información del proyecto
info: ## Mostrar información del proyecto
	@echo "📋 Información del proyecto:"
	@echo "   🌐 URL de la aplicación: http://localhost:8080"
	@echo "   🗄️ Base de datos MySQL: localhost:3307"
	@echo "   👤 Usuario DB: laravel"
	@echo "   🔑 Contraseña DB: laravel"
	@echo "   📁 Directorio del proyecto: $(PWD)"
	@echo ""
	@echo "🔧 Comandos útiles:"
	@echo "   - make help          # Ver todos los comandos"
	@echo "   - make install       # Instalar proyecto completo"
	@echo "   - make up            # Levantar servicios"
	@echo "   - make down          # Detener servicios"
	@echo "   - make shell         # Acceder al contenedor"
	@echo "   - make logs          # Ver logs"
