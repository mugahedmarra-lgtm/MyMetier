#!/bin/bash
# Exit on any error
set -e

echo "========================"
echo "[1] INSTALL REQUIRED PACKAGES"
echo "========================"
# Update package list
sudo apt-get update

# Install prerequisites
sudo apt-get install -y software-properties-common curl git unzip

# Add PHP PPA and install PHP 8.2 and required extensions
sudo add-apt-repository -y ppa:ondrej/php
sudo apt-get update
sudo apt-get install -y php8.2-fpm php8.2-cli php8.2-pdo php8.2-sqlite3 php8.2-mbstring php8.2-xml php8.2-ctype php8.2-curl php8.2-zip php8.2-json openssl

# Install Composer
if ! [ -x "$(command -v composer)" ]; then
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
fi

# Install Nginx
sudo apt-get install -y nginx

# Install Node.js (v20)
if ! [ -x "$(command -v node)" ]; then
    curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
    sudo apt-get install -y nodejs
fi

echo "========================"
echo "[2] PROJECT SETUP"
echo "========================"
REPO_URL="${1:-<repository>}"
PROJECT_DIR="${2:-project-folder}"

if [ ! -d "$PROJECT_DIR" ]; then
    git clone "$REPO_URL" "$PROJECT_DIR"
fi

cd "$PROJECT_DIR"
composer install --no-dev --optimize-autoloader

echo "========================"
echo "[3] ENV CONFIGURATION"
echo "========================"
cp .env.example .env

DOMAIN="${3:-your-domain.com}"
DB_PATH="${4:-/absolute/path/database/database.sqlite}"

sed -i "s/^APP_ENV=.*/APP_ENV=production/" .env
sed -i "s/^APP_DEBUG=.*/APP_DEBUG=false/" .env
sed -i "s|^APP_URL=.*|APP_URL=http://${DOMAIN}|" .env
sed -i "s/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/" .env

if grep -q "^DB_DATABASE=" .env; then
    sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_PATH}|" .env
else
    echo "DB_DATABASE=${DB_PATH}" >> .env
fi

echo "========================"
echo "[4] GENERATE KEY"
echo "========================"
php artisan key:generate --force

echo "========================"
echo "[5] DATABASE SETUP"
echo "========================"
mkdir -p $(dirname "$DB_PATH")
touch "$DB_PATH"
php artisan migrate --force

echo "========================"
echo "[6] STORAGE LINK"
echo "========================"
php artisan storage:link || true

echo "========================"
echo "[7] CACHE OPTIMIZATION"
echo "========================"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "========================"
echo "[8] FRONTEND BUILD"
echo "========================"
npm install
npm run build

echo "========================"
echo "[9] PERMISSIONS"
echo "========================"
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

echo "========================"
echo "[10] NGINX CONFIG"
echo "========================"
NGINX_CONF="/etc/nginx/sites-available/${DOMAIN}"

cat <<EOF | sudo tee "$NGINX_CONF"
server {
    listen 80;
    listen [::]:80;
    server_name ${DOMAIN};
    root $(pwd)/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

sudo ln -sf "$NGINX_CONF" /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm

echo "========================"
echo "[11] FINAL CHECK"
echo "========================"
echo "Please open http://${DOMAIN} in your browser to verify."
echo "Ensure the application loads and there are no debug errors."
