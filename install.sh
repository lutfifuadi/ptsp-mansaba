#!/bin/bash

# ============================================================
# Script Instalasi Pertama - Aplikasi PTSP MAN 1 Kota Bandung
# Server: VPS / aaPanel
# Jalankan SEKALI saat setup klien baru:
#   bash install.sh
# Setelah selesai, lanjutkan setup via browser: http://DOMAIN/install
# ============================================================

APP_PATH="$(cd "$(dirname "$0")" && pwd)"
WEB_USER="www"
GITHUB_OWNER="lutfifuadi"
GITHUB_REPO="ptsp-mansaba"
export COMPOSER_ALLOW_SUPERUSER=1


echo "=========================================="
echo "  Instalasi Aplikasi PTSP - VPS"
echo "=========================================="
echo "  Path terdeteksi: $APP_PATH"
echo "=========================================="

# Pastikan dijalankan dari direktori aplikasi
cd "$APP_PATH" || { echo "[ERROR] Path tidak ditemukan: $APP_PATH"; exit 1; }

# ----------------------------------------------------------
# 1. Persiapan folder wajib Laravel
# ----------------------------------------------------------
echo ""
echo "[1/6] Persiapan folder & permission..."
mkdir -p bootstrap/cache storage/framework/{sessions,views,cache/data} storage/logs
chmod -R 775 bootstrap/cache storage
echo "[OK] Folder siap."

# ----------------------------------------------------------
# 2. Install Composer dependencies
# ----------------------------------------------------------
echo ""
echo "[2/6] Install Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# ----------------------------------------------------------
# 3. Setup file .env
# ----------------------------------------------------------
echo ""
echo "[3/6] Setup file .env..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo "[OK] File .env dibuat dari .env.example."
else
    echo "[OK] File .env sudah ada, dilewati."
fi

# Muat variabel dari .env (terutama GITHUB_TOKEN jika sudah ada)
if [ -f ".env" ]; then
    export $(grep -v '^#' .env | xargs)
fi

# Tulis GITHUB_REPO_OWNER & GITHUB_REPO_NAME ke .env jika belum ada atau berbeda
if grep -q "^GITHUB_REPO_OWNER=" .env; then
    sed -i "s|^GITHUB_REPO_OWNER=.*|GITHUB_REPO_OWNER=$GITHUB_OWNER|" .env
else
    echo "GITHUB_REPO_OWNER=$GITHUB_OWNER" >> .env
fi

if grep -q "^GITHUB_REPO_NAME=" .env; then
    sed -i "s|^GITHUB_REPO_NAME=.*|GITHUB_REPO_NAME=$GITHUB_REPO|" .env
else
    echo "GITHUB_REPO_NAME=$GITHUB_REPO" >> .env
fi
echo "[OK] GITHUB_REPO_OWNER=$GITHUB_OWNER, GITHUB_REPO_NAME=$GITHUB_REPO ditulis ke .env"

# ----------------------------------------------------------
# 4. Download public/build dari GitHub Release terbaru
# ----------------------------------------------------------
echo ""
echo "[4/6] Download public/build dari GitHub Release..."

CURL_OPTS=("-sLf")
WGET_OPTS=("-q")

if [ -n "$GITHUB_TOKEN" ]; then
    CURL_OPTS+=("-H" "Authorization: token $GITHUB_TOKEN")
    WGET_OPTS+=("--header=Authorization: token $GITHUB_TOKEN")
    echo "[INFO] Menggunakan GITHUB_TOKEN untuk autentikasi."
fi

RELEASE_JSON=$(curl "${CURL_OPTS[@]}" "https://api.github.com/repos/$GITHUB_OWNER/$GITHUB_REPO/releases/latest" 2>/tmp/github_api_error.txt)
CURL_EXIT_CODE=$?

if [ $CURL_EXIT_CODE -ne 0 ] || [ -z "$RELEASE_JSON" ]; then
    echo "[WARN] Gagal mengambil data release dari GitHub API."
    if [ -f /tmp/github_api_error.txt ]; then
        echo "[DEBUG] Curl Error: $(cat /tmp/github_api_error.txt)"
    fi
    echo "[INFO] Cek koneksi, GITHUB_TOKEN (jika ada), atau rate limit API GitHub."
    LATEST_URL=""
else
    # Mencari URL download dengan cara yang lebih kuat terhadap format JSON (single line atau pretty print)
    LATEST_URL=$(echo "$RELEASE_JSON" | sed 's/[()]/ /g; s/"/\n"/g' | grep "https" | grep "aplikasi.zip" | head -n 1 | tr -d '"')
fi

if [ -n "$LATEST_URL" ]; then
    echo "[INFO] Mengunduh: $LATEST_URL"
    
    # Coba unduh menggunakan wget. Jika ada GITHUB_TOKEN, sertakan dalam header.
    wget "${WGET_OPTS[@]}" -L -O /tmp/aplikasi.zip "$LATEST_URL" 2>/tmp/wget_error.txt
    
    if [ $? -eq 0 ]; then
        echo "[INFO] Mengekstrak build asset..."
        mkdir -p /tmp/build_extract
        unzip -o /tmp/aplikasi.zip 'public/build/*' -d /tmp/build_extract/ > /dev/null
        
        if [ -d "/tmp/build_extract/public/build" ]; then
            rm -rf public/build
            mv /tmp/build_extract/public/build public/
            echo "[OK] public/build berhasil diekstrak."
        else
            echo "[ERROR] Folder public/build tidak ditemukan dalam zip!"
        fi
        rm -rf /tmp/build_extract
        rm /tmp/aplikasi.zip
    else
        echo "[WARN] Gagal mengunduh build asset."
        if [ -f /tmp/wget_error.txt ]; then
            echo "[DEBUG] Wget Error: $(cat /tmp/wget_error.txt)"
        fi
        echo "[INFO] Lanjutkan instalasi, tapi tampilan mungkin rusak."
        echo "[INFO] Hubungi developer untuk mengirim build asset manual."
    fi
else
    echo "[WARN] Tidak ada asset 'aplikasi.zip' ditemukan di release terbaru atau tidak ada release di GitHub."
fi

# ----------------------------------------------------------
# 5. Buat symlink storage
# ----------------------------------------------------------
echo ""
echo "[5/6] Buat symlink storage..."
if [ ! -L "public/storage" ]; then
    php artisan storage:link
    echo "[OK] Symlink public/storage dibuat."
else
    echo "[OK] Symlink public/storage sudah ada, dilewati."
fi

# ----------------------------------------------------------
# 6. Set permission & setup queue worker
# ----------------------------------------------------------
echo ""
echo "[6/6] Set permission & setup queue worker..."
chown -R "$WEB_USER":"$WEB_USER" "$APP_PATH"
chmod -R 755 "$APP_PATH"
chmod -R 775 storage bootstrap/cache

# Setup queue worker jika Supervisor tersedia
if command -v supervisorctl &> /dev/null; then
    echo "[INFO] Supervisor ditemukan, setup queue worker..."
    bash "$APP_PATH/setup-queue-worker.sh"
else
    echo ""
    echo "=========================================="
    echo "  [WARN] Supervisor tidak ditemukan!"
    echo "  Notifikasi WhatsApp tidak akan berjalan."
    echo "  Jalankan manual setelah install Supervisor:"
    echo "    bash $APP_PATH/setup-queue-worker.sh"
    echo "=========================================="
fi

# ----------------------------------------------------------
# Selesai
# ----------------------------------------------------------
echo ""
echo "=========================================="
echo "  Instalasi Selesai!"
echo "=========================================="
echo ""
echo "Langkah selanjutnya:"
echo "  Buka browser dan akses wizard instalasi:"
echo "  $APP_PATH/install"
echo ""
echo "  Wizard akan memandu:"
echo "  - Konfigurasi database"
echo "  - Data sekolah / lembaga"
echo "  - Pembuatan akun admin"
echo ""
