# Order Placement

A Laravel-based backend service for placing orders with modular architecture, JWT authentication, race condition handling via Redis, Dockerized setup, and automated tests.

## Features
- **Modular Structure:** Built using `nwidart/laravel-modules` for clean separation of logic
- **Order API:** Register orders with multiple items and shipping methods
- **Shipping Cost Logic:** Handles 3 different methods with fixed pricing
- **Race Condition Protection:** Ensures safe concurrent ordering via Redis locks
- **JWT Authentication:** Secure access to APIs using JSON Web Tokens
- **Laravel Horizon:** For monitoring and managing queues
- **Dockerized Environment:** Full setup with PHP-FPM, Nginx, Redis, MySQL
- **Makefile Automation:** Simplified CLI commands for everyday tasks
- **Test Suite:** Automated tests for all major logic

## Requirements
- **Docker**
- **Docker Compose**
- **Make** (optional)

## How to use
### Clone the Repository
```bash
git clone git@github.com:mjpakzad/order-placement.git
```
### Change directory
```bash
cd order-placement
```

### Using the Makefile (Recommended)
Everything is automated for you:
1. **Initial Setup**
```
make setup
```
This will:

- Copy ```.env.example``` to ```.env```
- Build and launch Docker containers
- Install PHP dependencies
- Generate the application key
- Generate JWT Secret
- Run migrations and seed the database
2. **Start Services**
```
make up
```
3. **Stop Services**
```
make down
```
4. **Rebuild Services**
```
make rebuild
```
5. **Run Tests**
```
make test
```
6. **Run Artisan Commands**
```
make artisan migrate
```
7. **Run Composer Commands**
```
make composer require vendor/package-name
```
8. **View Logs**
```
make logs
```
9. **Stay Updated**
```
make pipeline
```
   To keep your project up to date, this command will:
- Install PHP dependencies
- Run migrations and seed the database
### Without Using the Makefile
1. **Copy the ```.env``` File**
```
cp .env.example .env
```
2. **Build and Start the Docker Services**
```
docker compose up -d --build
```
3. **Install Composer Dependencies**
```
docker compose exec app composer install
```
4. **Generate the Application Key**
```
docker compose exec app php artisan key:generate
```
5. **Generate JWT Secret**
```php
docker compose exec app php artisan jwt:secret
```
6. **Run Migrations and Seed the Database**
```
docker compose exec app php artisan migrate --seed
```
6. Run Tests
```
docker compose exec app php artisan test
```
### Accessing the Application
- Application URL: http://localhost
- Laravel Telescope: http://localhost/telescope
- Laravel Horizon: http://localhost/horizon

## Additional Information
### Queue Management
- Queue jobs run in the background using a separate ```queue``` container
- Redis is used as the queue driver.
- Horizon provides real-time monitoring

### Redis Configuration
- Make sure the following is set in your `.env`
```
REDIS_CLIENT=phpredis
```

### Manual Commands
If you’re not using Makefile, you can still run Artisan or Composer commands:
- **Run Artisan:**
```
docker exec -it app php artisan {command}
```
- **Run Composer:**
```
docker exec -it app composer {command}
```
