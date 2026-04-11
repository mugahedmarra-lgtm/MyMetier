#!/bin/bash
# Exit on any error
set -e

DOMAIN="${1:-your-domain.com}"
PROJECT_DIR="${2:-/path-to-project}"
PHP_SOCK="${3:-/run/php/php8.2-fpm.sock}"

echo "========================"
echo "[1] DOMAIN CONFIGURATION"
echo "========================"
echo "Please ensure that your domain ($DOMAIN) is pointed to this server's IP address and DNS is active."

echo "========================"
echo "[2] NGINX SERVER BLOCK"
echo "========================"
NGINX_CONF="/etc/nginx/sites-available/${DOMAIN}"

cat <<EOF | sudo tee "$NGINX_CONF"
# Rate limiting zone configuration
limit_req_zone \$binary_remote_addr zone=app_limit:10m rate=10r/s;
limit_req_zone \$binary_remote_addr zone=login_limit:10m rate=3r/s;

server {
    listen 80;
    server_name ${DOMAIN};

    root ${PROJECT_DIR}/public;
    index index.php;

    # Disable directory listing
    autoindex off;

    # Protect sensitive directories
    location ^~ /storage/ {
        deny all;
    }

    # Hide hidden files like .env
    location ~ /\.(?!well-known).* {
        deny all;
    }

    location / {
        limit_req zone=app_limit burst=20 nodelay;
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    # Stricter rate limiting for logins
    location /login {
        limit_req zone=login_limit burst=5 nodelay;
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php\$ {
        include fastcgi_params;
        fastcgi_pass unix:${PHP_SOCK};
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
    }
}
EOF

sudo ln -sf "$NGINX_CONF" /etc/nginx/sites-enabled/
sudo systemctl restart nginx

echo "========================"
echo "[3] INSTALL SSL (HTTPS)"
echo "========================"
# Install Certbot via apt
sudo apt update
sudo apt install -y certbot python3-certbot-nginx

# Run Certbot to install certificate and force HTTP -> HTTPS redirect
sudo certbot --nginx -d "$DOMAIN" --non-interactive --agree-tos -m "admin@${DOMAIN}" --redirect

echo "========================"
echo "[4] VERIFY HTTPS"
echo "========================"
echo "HTTPS has been configured. Open https://${DOMAIN} in your browser to verify."

echo "========================"
echo "[5] BASIC SECURITY"
echo "========================"
# Ensure APP_DEBUG is false in .env
if [ -f "${PROJECT_DIR}/.env" ]; then
    sed -i "s/^APP_DEBUG=.*/APP_DEBUG=false/" "${PROJECT_DIR}/.env"
fi

# Ensure storage is protected and appropriate permissions are set
sudo chown -R www-data:www-data "${PROJECT_DIR}/storage" "${PROJECT_DIR}/bootstrap/cache"
sudo chmod -R 775 "${PROJECT_DIR}/storage" "${PROJECT_DIR}/bootstrap/cache"
sudo chmod 640 "${PROJECT_DIR}/.env"
sudo chown "$USER":www-data "${PROJECT_DIR}/.env"

echo "========================"
echo "[6] FIREWALL (OPTIONAL)"
echo "========================"
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw allow 'OpenSSH'
sudo ufw --force enable

echo "========================"
echo "[7] RATE LIMIT (OPTIONAL)"
echo "========================"
echo "Basic protection configured: rate limiting implemented in Nginx for general requests and logins."

echo "========================"
echo "[8] FINAL CHECK"
echo "========================"
echo "Please thoroughly test the following functionalities securely via HTTPS:"
echo "- homepage"
echo "- login"
echo "- search"
echo "- profile page"
echo "Ensure fast loading and no errors."
