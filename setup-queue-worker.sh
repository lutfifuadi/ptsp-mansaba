#!/bin/bash

# ============================================================
# Script Setup Queue Worker (Supervisor)
# Untuk Aplikasi PTSP MAN 1 Kota Bandung
# ============================================================

APP_PATH="$(cd "$(dirname "$0")" && pwd)"
CONF_FILE="/etc/supervisor/conf.d/ptsp-worker.conf"
WEB_USER="www"

echo "[INFO] Menyiapkan konfigurasi Supervisor di $CONF_FILE..."

# Buat file konfigurasi
cat <<EOF | sudo tee $CONF_FILE > /dev/null
[program:ptsp-worker]
process_name=%(program_name)s_%(process_num)02d
command=php $APP_PATH/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=$WEB_USER
numprocs=2
redirect_stderr=true
stdout_logfile=$APP_PATH/storage/logs/worker.log
stopwaitsecs=3600
EOF

# Update Supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start ptsp-worker:*

echo "[OK] Queue worker berhasil disetup dan dijalankan."
