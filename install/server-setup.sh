#!/usr/bin/env bash
set -Eeuo pipefail

APP_DIR="/var/www/rino"
DOMAIN=""

fail() { printf 'Error: %s\n' "$*" >&2; exit 1; }
info() { printf '\n%s\n' "$*"; }
confirm() {
    local answer
    read -r -p "$1 [y/N]: " answer
    [[ "$answer" =~ ^[Yy]$ ]]
}

if [[ $EUID -ne 0 ]]; then
    fail "Run this command using sudo."
fi

if [[ $# -ne 1 ]]; then
    fail "Usage: sudo bash install/server-setup.sh example.com"
fi

DOMAIN="${1,,}"
if [[ ! "$DOMAIN" =~ ^[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)+$ ]] || [[ ${#DOMAIN} -gt 253 ]]; then
    fail "Enter a valid domain without a protocol or path."
fi

[[ -f "$APP_DIR/artisan" ]] || fail "Rino not found at $APP_DIR."
[[ -f "$APP_DIR/.env" ]] || fail "Missing $APP_DIR/.env. Run the application setup first."
command -v apt-get >/dev/null || fail "This setup supports Ubuntu with apt-get only."
[[ -f /etc/os-release ]] || fail "Cannot identify operating system."
# shellcheck disable=SC1091
. /etc/os-release
[[ "$ID" == ubuntu && "$VERSION_ID" == "24.04" ]] || fail "Automated server configuration supports Ubuntu 24.04 only."

info 'Rino Server Setup'
printf 'Application: %s\nDomain:      %s\n' "$APP_DIR" "$DOMAIN"
confirm 'Continue with optional server configuration?' || { info 'Server configuration skipped.'; exit 0; }

if ! command -v php >/dev/null || [[ ! -S /run/php/php8.3-fpm.sock ]]; then
    fail 'PHP 8.3-FPM is missing or stopped. Install/start php8.3-fpm before server setup.'
fi

if ! command -v nginx >/dev/null || ! command -v mysql >/dev/null; then
    info 'Some server packages are missing.'
    if confirm 'Install missing Nginx/MySQL packages?'; then
        apt-get update
        if ! command -v nginx >/dev/null; then
            apt-get install -y nginx
        fi
        if ! command -v mysql >/dev/null; then
            apt-get install -y mysql-server
        fi
    fi
fi

if command -v nginx >/dev/null; then
    if confirm 'Configure Nginx for Rino?'; then
        TARGET=/etc/nginx/sites-available/rino.conf
        if [[ -e "$TARGET" || -L "$TARGET" ]]; then
            info "Skipped: $TARGET already exists. Edit it manually if needed."
        else
            [[ -S /run/php/php8.3-fpm.sock ]] || fail "PHP 8.3-FPM socket is missing. Start php8.3-fpm first."
            if grep -RqsE '^\s*server_name\s+.*\b'"$DOMAIN"'\b' /etc/nginx/sites-enabled/ 2>/dev/null; then
                fail "An enabled Nginx site may already use $DOMAIN. Check it before proceeding."
            fi
            cat > "$TARGET" <<NGINX
server {
    listen 80;
    listen [::]:80;
    server_name $DOMAIN;
    root /var/www/rino/public;
    index index.php;
    charset utf-8;
    client_max_body_size 25M;
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ^~ /build/ {
        try_files \$uri =404;
        expires 7d;
    }

    location ~ ^/index\.php(/|\$) {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
        internal;
    }

    location ~ \.php\$ { return 404; }
    location ~ /\.(?!well-known).* { deny all; }
}
NGINX
            ln -s "$TARGET" /etc/nginx/sites-enabled/rino.conf
            if nginx -t; then
                systemctl enable --now nginx
                systemctl reload nginx
                info 'Nginx configured.'
            else
                rm -f /etc/nginx/sites-enabled/rino.conf "$TARGET"
                fail 'Nginx validation failed. The new Rino configuration was removed.'
            fi
        fi
    fi
fi

if confirm 'Apply Rino production file permissions?'; then
    chown -R www-data:www-data "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
    chmod -R ug+rwX "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
    if [[ -f "$APP_DIR/.env" ]]; then
        chgrp www-data "$APP_DIR/.env"
        chmod 640 "$APP_DIR/.env"
    fi
    info 'Laravel writable-directory permissions configured.'
fi

if confirm 'Configure Rino queue worker?'; then
    TARGET=/etc/systemd/system/rino-queue.service
    if [[ -e "$TARGET" ]]; then
        info "Skipped: $TARGET already exists."
    else
        cat > "$TARGET" <<'SERVICE'
[Unit]
Description=Rino Queue Worker
After=network.target mysql.service

[Service]
User=www-data
Group=www-data
WorkingDirectory=/var/www/rino
ExecStart=/usr/bin/php /var/www/rino/artisan queue:work database --sleep=3 --tries=3 --timeout=60
Restart=always
RestartSec=5

[Install]
WantedBy=multi-user.target
SERVICE
        systemctl daemon-reload
        systemctl enable --now rino-queue.service
        info 'Queue service configured.'
    fi
fi

if confirm 'Configure Rino task scheduler?'; then
    TARGET=/etc/cron.d/rino
    if [[ -e "$TARGET" ]]; then
        info "Skipped: $TARGET already exists."
    else
        if ! command -v crontab >/dev/null; then
            if confirm 'Install cron now?'; then
                apt-get install -y cron
                systemctl enable --now cron
            else
                fail 'Cron is required for the scheduler.'
            fi
        fi
        cat > "$TARGET" <<'CRON'
* * * * * www-data cd /var/www/rino && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
CRON
        chmod 644 "$TARGET"
        info 'Scheduler configured.'
    fi
fi

if command -v nginx >/dev/null && confirm "Install HTTPS certificate for $DOMAIN using Certbot?"; then
    info "DNS for $DOMAIN must already point to this VPS, with ports 80 and 443 reachable."
    if confirm 'Continue with certificate installation?'; then
        if ! command -v certbot >/dev/null; then
            apt-get update
            apt-get install -y certbot python3-certbot-nginx
        fi
        certbot --nginx -d "$DOMAIN"
    fi
fi

info 'Server setup prompts finished. Summary of actual service status:'
if command -v nginx >/dev/null && systemctl is-active --quiet nginx; then
    info 'Nginx: running'
else
    info 'Nginx: NOT running or unavailable'
fi
if systemctl is-active --quiet rino-queue.service; then
    info 'Rino queue: running'
else
    info 'Rino queue: NOT running or not configured'
fi
if [[ -f /etc/cron.d/rino ]] && systemctl is-active --quiet cron; then
    info 'Rino scheduler: configured (cron running)'
else
    info 'Rino scheduler: NOT verified'
fi
if command -v certbot >/dev/null && certbot certificates 2>/dev/null | grep -Fq "Domains: $DOMAIN"; then
    info 'HTTPS: certificate found for domain'
else
    info 'HTTPS: NOT verified'
fi
info 'Verify the website and admin login before launch.'
