# Blangkis Store production deployment

This guide deploys CodeIgniter 4 behind Nginx and PHP-FPM on Ubuntu. The repository root must never be the web root; Nginx must serve `public/` only.

## Requirements

- Ubuntu 22.04 or newer
- PHP 8.1 or newer (PHP 8.2/8.3 is recommended for the locked dependencies)
- PHP extensions: `bcmath`, `curl`, `dom`, `fileinfo`, `gd`, `intl`, `mbstring`, `mysqli` or `pdo_mysql`, `openssl`, `xml`, and `zip`
- Nginx
- MySQL 8/MariaDB compatible with the application
- Composer 2
- A DNS record pointing the production hostname to the VPS

Install the PHP packages for the selected PHP version, for example:

```bash
sudo apt update
sudo apt install nginx mysql-server composer \
  php-fpm php-cli php-mysql php-curl php-xml php-mbstring php-intl \
  php-gd php-zip php-bcmath
```

Confirm the versions before deployment:

```bash
php -v
composer --version
php -m
```

## Application install

Use a non-root deploy directory and clone the repository there:

```bash
sudo mkdir -p /var/www/blangkisstore
sudo chown "$USER":www-data /var/www/blangkisstore
git clone https://github.com/syafiqa23/Blangkis.Store.git /var/www/blangkisstore
cd /var/www/blangkisstore
composer install --no-dev --optimize-autoloader --no-interaction
cp .env.example .env
chmod 640 .env
```

Edit `.env` on the server. At minimum set:

```dotenv
CI_ENVIRONMENT = production
app.baseURL = 'https://store.example.com/'
app.forceGlobalSecureRequests = true
cookie.secure = true
database.default.hostname = 127.0.0.1
database.default.database = blangkisstore
database.default.username = blangkisstore
database.default.password = <long-random-password>
database.default.port = 3306
```

Set OAuth and shipping/API values only when those integrations are enabled. Keep all secrets in `.env` or a server secret manager; never put them in tracked PHP files, shell history, or the repository.

## Database

Create a dedicated database user with only the privileges required by this application. Do not use the MySQL `root` account from PHP-FPM.

For a new database, run migrations from the release directory:

```bash
php spark migrate --all
```

The repository includes `db_ci4.sql`, which can be imported when restoring the existing database instead of running migrations. Do not import both into the same empty database without checking for duplicate schema/data first.

Seeders are optional and should only be run when initial/demo data is required:

```bash
php spark db:seed KategoriSeeder
php spark db:seed ProductSeeder
php spark db:seed UserSeeder
```

Review seed data before using it in a real production database.

## Nginx and PHP-FPM

Create `/etc/nginx/sites-available/blangkisstore` and adjust the hostname and PHP-FPM socket:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name store.example.com;

    root /var/www/blangkisstore/public;
    index index.php;

    client_max_body_size 10M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~* ^/uploads/.*\.php$ {
        deny all;
    }

    location ~ \.php$ {
        try_files $uri =404;
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~ /\. {
        deny all;
    }
}
```

Use the socket matching `systemctl status php*-fpm`. Enable and test the site:

```bash
sudo ln -s /etc/nginx/sites-available/blangkisstore /etc/nginx/sites-enabled/blangkisstore
sudo nginx -t
sudo systemctl reload nginx
sudo systemctl enable --now php8.2-fpm nginx
```

The `try_files` fallback is the Nginx equivalent of CodeIgniter's rewrite rule. Static CSS, JavaScript, images, and fonts are served directly from `public/`.

## Permissions

PHP-FPM needs write access only to `writable/`. Keep application code read-only for the web worker:

```bash
sudo chown -R deploy:www-data /var/www/blangkisstore
sudo find /var/www/blangkisstore -type d -exec chmod 750 {} \;
sudo find /var/www/blangkisstore -type f -exec chmod 640 {} \;
sudo chown -R www-data:www-data /var/www/blangkisstore/writable
sudo find /var/www/blangkisstore/writable -type d -exec chmod 750 {} \;
sudo find /var/www/blangkisstore/writable -type f -exec chmod 640 {} \;
sudo chmod 640 /var/www/blangkisstore/.env
```

Do not use `chmod -R 777`. Ensure the deploy user can still read and update releases, and keep database backups outside the web root.

## HTTPS and operations

Use Certbot or an equivalent certificate manager after DNS resolves:

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d store.example.com
```

Keep `app.forceGlobalSecureRequests = true` and `cookie.secure = true` once HTTPS is active. Confirm the HTTPS redirect, login, checkout, image uploads, Google OAuth callback, and generated invoices after deployment.

For a later release:

```bash
cd /var/www/blangkisstore
git pull --ff-only
composer install --no-dev --optimize-autoloader --no-interaction
php spark migrate --all
sudo systemctl reload php8.2-fpm
sudo systemctl reload nginx
```

Before each release, run `php spark routes`, inspect logs under `writable/logs/`, and take a database backup. Never expose `app/`, `writable/`, `tests/`, `vendor/`, `.env`, or `composer.*` through a separate Nginx root.
