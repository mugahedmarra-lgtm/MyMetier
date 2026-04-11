#!/bin/bash
# Exit on any error
set -e

PROJECT_DIR="${1:-/path-to-project}"
DB_PATH="${2:-/absolute/path/database/database.sqlite}"
BACKUP_DIR="${3:-/path-to-project/backups}"

echo "========================"
echo "[1] OPTIMIZE LARAVEL"
echo "========================"
cd "$PROJECT_DIR"
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "========================"
echo "[2] DISABLE DEBUG COMPLETELY"
echo "========================"
if [ -f ".env" ]; then
    sed -i "s/^APP_ENV=.*/APP_ENV=production/" .env
    sed -i "s/^APP_DEBUG=.*/APP_DEBUG=false/" .env
fi
php artisan config:cache

echo "========================"
echo "[3] LOGGING CONFIG"
echo "========================"
if [ -f ".env" ]; then
    # Set to daily logging
    if grep -q "^LOG_CHANNEL=" .env; then
        sed -i "s/^LOG_CHANNEL=.*/LOG_CHANNEL=daily/" .env
    else
        echo "LOG_CHANNEL=daily" >> .env
    fi

    # Keep last 7 days
    if grep -q "^LOG_MAX_FILES=" .env; then
        sed -i "s/^LOG_MAX_FILES=.*/LOG_MAX_FILES=7/" .env
    else
        echo "LOG_MAX_FILES=7" >> .env
    fi
fi
php artisan config:cache

echo "========================"
echo "[4] QUEUE (OPTIONAL PREP)"
echo "========================"
if grep -q "^QUEUE_CONNECTION=" .env; then
    sed -i "s/^QUEUE_CONNECTION=.*/QUEUE_CONNECTION=database/" .env
else
    echo "QUEUE_CONNECTION=database" >> .env
fi
# Might fail if migration already exists, so continue
php artisan queue:table || true
php artisan migrate --force

echo "========================"
echo "[5] SCHEDULE (OPTIONAL PREP)"
echo "========================"
CRON_JOB="* * * * * cd ${PROJECT_DIR} && php artisan schedule:run >> /dev/null 2>&1"
echo "To enable Laravel scheduler, add the following line to your crontab (crontab -e):"
echo "$CRON_JOB"

echo "========================"
echo "[6] CACHE WARMUP"
echo "========================"
echo "Visit your homepage and search page to trigger cache population."

echo "========================"
echo "[7] ERROR HANDLING"
echo "========================"
echo "With APP_DEBUG=false, Laravel will automatically display clean generic error pages to users."
echo "Raw errors are hidden from the frontend but logged to storage."

echo "========================"
echo "[8] PERFORMANCE CHECK"
echo "========================"
echo "Please manually test:"
echo "- homepage load speed"
echo "- search response time"
echo "- profile page load"

echo "========================"
echo "[9] BASIC MONITORING"
echo "========================"
echo "Monitor storage/logs/*.log for errors."
echo "Keep an eye on memory usage, and check your slow query logs (if implemented)."

echo "========================"
echo "[10] BACKUP (IMPORTANT)"
echo "========================"
# Setup basic backup script inside BACKUP_DIR
mkdir -p "$BACKUP_DIR"
cat <<EOF > "$BACKUP_DIR/backup.sh"
#!/bin/bash
TIMESTAMP=\$(date +"%Y%m%d_%H%M%S")
# Backup SQLite Database
cp "$DB_PATH" "$BACKUP_DIR/database_\$TIMESTAMP.sqlite"
# Backup Storage
tar -czf "$BACKUP_DIR/storage_\$TIMESTAMP.tar.gz" -C "$PROJECT_DIR" storage
# Remove backups older than 14 days
find "$BACKUP_DIR" -type f \( -name "*.sqlite" -o -name "*.tar.gz" \) -mtime +14 -delete
EOF
chmod +x "$BACKUP_DIR/backup.sh"

BACKUP_CRON="0 2 * * * ${BACKUP_DIR}/backup.sh"
echo "A backup script has been created at ${BACKUP_DIR}/backup.sh."
echo "To schedule daily backups at 2 AM, add this line to your crontab:"
echo "$BACKUP_CRON"

echo "========================"
echo "[11] FINAL CHECKLIST"
echo "========================"
echo "Ensure:"
echo "- app loads"
echo "- no debug errors"
echo "- HTTPS working"
echo "- database connected"
echo "- uploads working"
