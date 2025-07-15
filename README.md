# Order Placement

A Laravel-based backend service for placing orders with modular architecture, JWT authentication, race condition handling via Redis, Dockerized setup, and automated tests.

## Requirements
- Docker & Docker Compose

## Installation

```bash
git clone git@github.com:<your-username>/order-placement.git
cd order-placement
composer install
cp .env.example .env
php artisan key:generate
```
