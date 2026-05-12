#!/bin/bash

# ============================================================
# Script Deploy - Aplikasi PTSP MAN 1 Kota Bandung
# Server: VPS / aaPanel
# Jalankan: bash deploy.sh
# ============================================================

APP_PATH="$(cd "$(dirname "$0")" && pwd)"
WEB_USER="www"
GITHUB_OWNER="lutfifuadi"
GITHUB_REPO="ptsp-mansaba"
export COMPOSER_ALLOW_SUPERUSER=1


echo "=========================================="
echo "  Deploy Aplikasi PTSP - VPS"
echo "=========================================="
echo "  Path terdeteksi: $APP_PATH"
echo "=========================================="

# Pastikan dijalankan dari direktori aplikasi
cd "$APP_PATH" || { echo "[ERROR] Path tidak ditemukan: $APP_PATH"; exit 1; }

# Muat variabel dari .env
if [ -f ".env" ]; then
    # Cara lebih aman membaca .env untuk menghindari error valid identifier
    set -a
    [ -f .env ] && . ./.env
    set +a
fi

# ----------------------------------------------------------
# 1. Pull kode terbaru dari Git
# ----------------------------------------------------------
echo ""
echo "[1/8] Pull kode terbaru dari Git..."

if [ -n "$GITHUB_TOKEN" ]; then
    echo "[INFO] Menggunakan GITHUB_TOKEN untuk autentikasi Git..."
    # Update remote URL agar menggunakan token (jika menggunakan HTTPS)
    REMOTE_URL=$(git remote get-url origin)
    if [[ $REMOTE_URL == https://github.com* ]]; then
        NEW_URL="https://$GITHUB_TOKEN@${REMOTE_URL#https://}"
        git remote set-url origin "$NEW_URL"
    fi
fi

git fetch --tags
git pull origin main --tags
if [ $? -ne 0 ]; then
    echo "[ERROR] Git pull gagal. Periksa koneksi, token, atau konflik."
    exit 1
fi

# ----------------------------------------------------------
# 2. Install / update Composer dependencies
# ----------------------------------------------------------
echo ""
echo "[2/8] Install Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# ----------------------------------------------------------
# 3. Download public/build dari GitHub Release terbaru
# ----------------------------------------------------------
echo ""
echo "[3/8] Download public/build dari GitHub Release..."

CURL_OPTS=("-sLf")
WGET_OPTS=("-q")

if [ -n "$GITHUB_TOKEN" ]; then
    CURL_OPTS+=("-H" "Authorization: token $GITHUB_TOKEN")
    WGET_OPTS+=("--header=Authorization: token $GITHUB_TOKEN")
    echo "[INFO] Menggunakan GITHUB_TOKEN untuk autentikasi API."
fi

# Coba ambil data release dan simpan error jika ada
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
    
    # Gunakan curl untuk mengunduh agar konsisten dengan pengambilan data release
    curl "${CURL_OPTS[@]}" -L -o /tmp/aplikasi.zip "$LATEST_URL" 2>/tmp/download_error.txt
    
    if [ $? -eq 0 ] && [ -f /tmp/aplikasi.zip ]; then
        echo "[INFO] Mengekstrak build asset..."
        mkdir -p /tmp/build_extract
        unzip -o /tmp/aplikasi.zip 'public/build/*' -d /tmp/build_extract/ > /dev/null
        
        if [ -d "/tmp/build_extract/public/build" ]; then
            rm -rf public/build
            mv /tmp/build_extract/public/build public/
            echo "[OK] public/build berhasil diperbarui."
        else
            echo "[ERROR] Folder public/build tidak ditemukan dalam zip!"
        fi
        rm -rf /tmp/build_extract
        rm /tmp/aplikasi.zip
    else
        echo "[WARN] Gagal mengunduh build asset."
        if [ -f /tmp/download_error.txt ]; then
            echo "[DEBUG] Download Error: $(cat /tmp/download_error.txt)"
        fi
        echo "[INFO] Mencoba mengunduh tanpa token..."
        curl -sLf -L -o /tmp/aplikasi.zip "$LATEST_URL"
        if [ $? -eq 0 ] && [ -f /tmp/aplikasi.zip ]; then
             echo "[INFO] Berhasil mengunduh tanpa token. Mengekstrak..."
             # ... (logic pengulangan ekstraksi)
             mkdir -p /tmp/build_extract
             unzip -o /tmp/aplikasi.zip 'public/build/*' -d /tmp/build_extract/ > /dev/null
             if [ -d "/tmp/build_extract/public/build" ]; then
                 rm -rf public/build
                 mv /tmp/build_extract/public/build public/
                 echo "[OK] public/build berhasil diperbarui."
             fi
             rm -rf /tmp/build_extract
             rm /tmp/aplikasi.zip
        else
             echo "[ERROR] Tetap gagal mengunduh meskipun tanpa token."
             echo "[INFO] public/build tetap menggunakan versi sebelumnya."
        fi
    fi
else
    echo "[WARN] Tidak ada asset 'aplikasi.zip' ditemukan di release terbaru."
fi

# ----------------------------------------------------------
# 4. Salin .env jika belum ada & update GitHub config
# ----------------------------------------------------------
echo ""
echo "[4/8] Cek file .env..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    php artisan key:generate
    echo "[INFO] File .env dibuat dari .env.example. Harap sesuaikan konfigurasi database!"
else
    echo "[OK] File .env sudah ada."
fi

# Pastikan GITHUB_REPO_OWNER & GITHUB_REPO_NAME selalu terkini di .env
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

# ----------------------------------------------------------
# 5. Jalankan migrasi database
# ----------------------------------------------------------
echo ""
echo "[6/8] Migrasi database..."
php artisan migrate --force

# ----------------------------------------------------------
# 5a. Sinkronisasi versi aplikasi dengan tag release
# ----------------------------------------------------------
echo ""
echo "[5a/8] Sinkronisasi versi aplikasi..."
php artisan version:sync --force

# ----------------------------------------------------------
# 5b. Publish Livewire assets & pastikan storage symlink ada
# ----------------------------------------------------------
echo ""
echo "[5b] Publish Livewire assets..."
php artisan livewire:publish --assets

if [ ! -L "public/storage" ]; then
    echo "[INFO] Membuat symlink storage..."
    php artisan storage:link
fi

# ----------------------------------------------------------
# 6. Clear & cache ulang config
# ----------------------------------------------------------
echo ""
echo "[7/8] Optimasi Laravel..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ----------------------------------------------------------
# 7. Perbaiki permission folder (Full Project for Dashboard Update)
# ----------------------------------------------------------
echo ""
echo "[8/8] Set permission folder & ownership..."
# Pastikan seluruh folder dimiliki oleh user web agar Dashboard bisa update file
chown -R "$WEB_USER":"$WEB_USER" "$APP_PATH"
chmod -R 775 storage bootstrap/cache

# ----------------------------------------------------------
# Selesai
# ----------------------------------------------------------
echo ""
echo "=========================================="
echo "  Deploy Selesai!"
echo "=========================================="
