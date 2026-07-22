#!/bin/bash

set -e

echo "========================================="
echo " Shebok Production Deployment"
echo "========================================="

echo ""
echo "[1/7] Building Docker..."
docker compose up -d --build

echo ""
echo "[2/7] Installing Composer Dependencies..."
docker compose exec -T app composer install --no-dev --optimize-autoloader

echo ""
echo "[3/7] Building Frontend..."
docker compose exec -T app npm install
docker compose exec -T app npm run build

echo ""
echo "[4/7] Preparing Laravel..."
docker compose exec -T app php artisan optimize:clear
docker compose exec -T app php artisan storage:link || true

echo ""
echo "[5/7] Running Database Migration..."
docker compose exec -T app php artisan migrate --force

echo ""
echo "[6/7] Caching Configuration..."
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache

echo ""
echo "[7/7] Restarting Containers..."
docker compose restart

echo ""
echo "========================================="
echo " Deployment Successful!"
echo "========================================="
echo ""
echo "Project is Live!"
