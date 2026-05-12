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

API_CURL_OPTS=("-sL")
if [ -n "$GITHUB_TOKEN" ]; then
    API_CURL_OPTS+=("-H" "Authorization: Bearer $GITHUB_TOKEN")
    echo "[INFO] Menggunakan GITHUB_TOKEN untuk autentikasi API."
fi

API_URL="https://api.github.com/repos/$GITHUB_OWNER/$GITHUB_REPO/releases/latest"
RELEASE_JSON=$(curl "${API_CURL_OPTS[@]}" "$API_URL" 2>/tmp/github_api_error.txt)
API_HTTP_CODE=$(curl "${API_CURL_OPTS[@]}" -o /dev/null -w "%{http_code}" "$API_URL" 2>/dev/null)

if [ "$API_HTTP_CODE" != "200" ] || [ -z "$RELEASE_JSON" ]; then
    echo "[WARN] Gagal mengambil data release dari GitHub API (HTTP $API_HTTP_CODE)."
    if [ -f /tmp/github_api_error.txt ] && [ -s /tmp/github_api_error.txt ]; then
        echo "[DEBUG] Curl Error: $(cat /tmp/github_api_error.txt)"
    fi
    if [ "$API_HTTP_CODE" == "401" ] || [ "$API_HTTP_CODE" == "403" ]; then
        echo "[ERROR] Autentikasi GitHub gagal. Pastikan GITHUB_TOKEN valid dan memiliki scope 'repo'."
    elif [ "$API_HTTP_CODE" == "404" ]; then
        echo "[ERROR] Release tidak ditemukan. Pastikan ada release yang dipublish di repository."
    elif [ "$API_HTTP_CODE" == "000" ]; then
        echo "[ERROR] Tidak dapat terhubung ke api.github.com. Periksa koneksi internet atau DNS server."
    fi
    echo "[INFO] Cek koneksi, GITHUB_TOKEN (jika ada), atau rate limit API GitHub."
    LATEST_URL=""
else
    # Gunakan PHP untuk parse JSON jika tersedia (lebih akurat dari regex)
    if command -v php &> /dev/null; then
        LATEST_URL=$(echo "$RELEASE_JSON" | php -r '
            if (!$data = json_decode(file_get_contents("php://stdin"), true)) exit(1);
            foreach ($data["assets"] ?? [] as $asset) {
                if ($asset["name"] === "aplikasi.zip") {
                    echo $asset["browser_download_url"];
                    break;
                }
            }
        ')
        if [ $? -ne 0 ] || [ -z "$LATEST_URL" ]; then
            LATEST_URL=$(echo "$RELEASE_JSON" | sed 's/[()]/ /g; s/"/\n"/g' | grep "https" | grep "aplikasi.zip" | head -n 1 | tr -d '"')
        fi
    else
        LATEST_URL=$(echo "$RELEASE_JSON" | sed 's/[()]/ /g; s/"/\n"/g' | grep "https" | grep "aplikasi.zip" | head -n 1 | tr -d '"')
    fi
fi

if [ -n "$LATEST_URL" ]; then
    echo "[INFO] URL asset ditemukan: $LATEST_URL"

    # Coba unduh dengan wget (lebih handal menangani redirect GitHub S3/CDN)
    DOWNLOAD_SUCCESS=false
    if command -v wget &> /dev/null; then
        echo "[INFO] Mengunduh dengan wget..."
        if [ -n "$GITHUB_TOKEN" ]; then
            wget --timeout=120 -q -L -O /tmp/aplikasi.zip \
                --header="Authorization: Bearer $GITHUB_TOKEN" \
                "$LATEST_URL" 2>/tmp/wget_error.txt
        else
            wget --timeout=120 -q -L -O /tmp/aplikasi.zip "$LATEST_URL" 2>/tmp/wget_error.txt
        fi

        if [ $? -eq 0 ] && [ -f /tmp/aplikasi.zip ] && [ -s /tmp/aplikasi.zip ]; then
            DOWNLOAD_SUCCESS=true
        elif [ -f /tmp/wget_error.txt ] && [ -s /tmp/wget_error.txt ]; then
            echo "[DEBUG] Wget Error: $(cat /tmp/wget_error.txt)"
        fi
    fi

    # Fallback ke curl jika wget gagal atau tidak ada
    if [ "$DOWNLOAD_SUCCESS" != "true" ] && command -v curl &> /dev/null; then
        echo "[INFO] Mengunduh dengan curl..."
        curl --max-time 120 -sL -f -o /tmp/aplikasi.zip "$LATEST_URL" 2>/tmp/curl_error.txt
        CURL_EXIT=$?
        if [ $CURL_EXIT -eq 0 ] && [ -f /tmp/aplikasi.zip ] && [ -s /tmp/aplikasi.zip ]; then
            DOWNLOAD_SUCCESS=true
        elif [ -f /tmp/curl_error.txt ] && [ -s /tmp/curl_error.txt ]; then
            echo "[DEBUG] Curl Error: $(cat /tmp/curl_error.txt)"
        fi
    fi

    if [ "$DOWNLOAD_SUCCESS" == "true" ]; then
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
        rm -f /tmp/aplikasi.zip
    else
        echo "[WARN] Gagal mengunduh build asset."
        if [ -f /tmp/wget_error.txt ] && [ -s /tmp/wget_error.txt ]; then
            echo "[DEBUG] Wget Error: $(cat /tmp/wget_error.txt)"
        fi
        if [ -f /tmp/curl_error.txt ] && [ -s /tmp/curl_error.txt ]; then
            echo "[DEBUG] Curl Error: $(cat /tmp/curl_error.txt)"
        fi
        echo "[ERROR] Kemungkinan penyebab:"
        echo "  1. File aplikasi.zip tidak ada/dihapus dari release v1.1.3"
        echo "  2. Rate limit GitHub (60 request/jam untuk IP publik)"
        echo "  3. Koneksi internet server terbatas/diblokir"
        echo "  4. Repository diblokir oleh firewall/DNS server di Indonesia"
        echo "[INFO] public/build tetap menggunakan versi sebelumnya."
        rm -f /tmp/aplikasi.zip
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
