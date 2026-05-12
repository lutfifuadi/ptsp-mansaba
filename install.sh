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
    LATEST_URL=""
else
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

DOWNLOAD_SUCCESS=false
if [ -n "$LATEST_URL" ]; then
    echo "[INFO] URL asset ditemukan: $LATEST_URL"

    # Coba unduh menggunakan wget tanpa auth header
    echo "[INFO] Mengunduh (tanpa auth header)..."
    if command -v wget &> /dev/null; then
        wget -q -L -O /tmp/aplikasi.zip "$LATEST_URL" 2>/tmp/wget_error.txt
        WGET_EXIT=$?
        if [ $WGET_EXIT -eq 0 ]; then
            DOWNLOAD_SUCCESS=true
        else
            # coba dengan auth header jika ada token
            if [ -n "$GITHUB_TOKEN" ]; then
                wget -q -L --header="Authorization: Bearer $GITHUB_TOKEN" -O /tmp/aplikasi.zip "$LATEST_URL" 2>/tmp/wget_error.txt
                WGET_EXIT=$?
                [ $WGET_EXIT -eq 0 ] && DOWNLOAD_SUCCESS=true
            fi
        fi
    fi

    # Fallback ke curl jika wget tidak ada atau gagal
    if [ "$DOWNLOAD_SUCCESS" != "true" ] && command -v curl &> /dev/null; then
        HTTP_CODE=$(curl -sL -o /tmp/aplikasi.zip -w "%{http_code}" "$LATEST_URL" 2>/tmp/download_error.txt)
        if [ "$HTTP_CODE" != "200" ] && [ -n "$GITHUB_TOKEN" ]; then
            HTTP_CODE=$(curl -sL -H "Authorization: Bearer $GITHUB_TOKEN" -o /tmp/aplikasi.zip -w "%{http_code}" "$LATEST_URL" 2>/tmp/download_error.txt)
        fi
        [ "$HTTP_CODE" == "200" ] && DOWNLOAD_SUCCESS=true
    fi

    if [ "$DOWNLOAD_SUCCESS" == "true" ] && [ -f /tmp/aplikasi.zip ] && [ -s /tmp/aplikasi.zip ]; then
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
        rm -f /tmp/aplikasi.zip
    else
        echo "[WARN] Gagal mengunduh build asset."
        if [ -f /tmp/wget_error.txt ] && [ -s /tmp/wget_error.txt ]; then
            echo "[DEBUG] Wget Error: $(cat /tmp/wget_error.txt)"
        fi
        if [ -f /tmp/download_error.txt ] && [ -s /tmp/download_error.txt ]; then
            echo "[DEBUG] Curl Error: $(cat /tmp/download_error.txt)"
        fi
        if [ "$HTTP_CODE" == "401" ] || [ "$HTTP_CODE" == "403" ]; then
            echo "[ERROR] Akses ditolak. Jika repository private, pastikan GITHUB_TOKEN valid (PAT dengan scope 'repo')."
        elif [ "$HTTP_CODE" == "404" ]; then
            echo "[ERROR] File aplikasi.zip tidak ditemukan di release."
        elif [ "$HTTP_CODE" == "000" ]; then
            echo "[ERROR] Tidak dapat terhubung ke GitHub. Periksa koneksi internet, firewall, atau DNS."
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
