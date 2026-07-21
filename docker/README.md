This directory contains Docker setup for running the application locally.

Services:
- app: PHP 8.4 CLI with Composer. It will run `composer install` and `php artisan serve`.
- db: MariaDB 10.6 with root password `root` and database `simrs`.
- phpmyadmin: phpMyAdmin available on port 8080.

Quick start:

```bash
docker compose up --build
```

Then open http://localhost:8000 and phpMyAdmin at http://localhost:8080 (user `root`, pass `root`).
