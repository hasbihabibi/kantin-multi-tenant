# Kantin Multi-Tenant

Project praktikum Pemrograman Web Lanjutan menggunakan Laravel 13 dan Livewire 4.

## Requirements

Pastikan perangkat memiliki:

* PHP 8.3 atau lebih baru
* Composer
* Node.js dan NPM
* MariaDB
* Redis
* Git

## Setup Project

Clone repository:

```bash
git clone <URL_REPOSITORY>
```

Masuk ke folder project:

```bash
cd kantin-multi-tenant
```

Install dependency PHP:

```bash
composer install
```

Install dependency frontend:

```bash
npm install
```

Salin file environment:

```bash
copy .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Konfigurasikan database MariaDB pada file `.env`.

Contoh:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kantin
DB_USERNAME=root
DB_PASSWORD=YOUR_PASSWORD
```

Konfigurasikan Redis:

```env
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

SESSION_DRIVER=redis
CACHE_STORE=redis
QUEUE_CONNECTION=redis
```

Jalankan migration:

```bash
php artisan migrate
```

Build frontend:

```bash
npm run build
```

## Menjalankan Project

Jalankan development environment:

```bash
composer run dev
```

Aplikasi dapat diakses melalui:

```text
http://localhost:8000
```

## Menjalankan Reverb

Pada terminal lain:

```bash
php artisan reverb:start
```

## Testing

Database testing menggunakan database terpisah:

```text
kantin_testing
```

Jalankan test:

```bash
php artisan test
```

## Code Formatter

Cek format kode:

```bash
vendor\bin\pint --test
```

Perbaiki format otomatis:

```bash
vendor\bin\pint
```

## Troubleshooting

### Database tidak dapat terhubung

Periksa:

* MariaDB sedang berjalan.
* Host dan port benar.
* Username dan password benar.
* Database `kantin` sudah dibuat.

### Redis tidak dapat terhubung

Pastikan Redis berjalan dan port 6379 tersedia.

Test dengan:

```bash
redis-cli -p 6379 ping
```

Target:

```text
PONG
```

### Vite tidak ditemukan

Jalankan:

```bash
npm install
npm run build
```
