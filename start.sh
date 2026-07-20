#!/bin/bash

echo "=========================================="
echo "      Shebok Platform - Auto Launch       "
echo "=========================================="

echo "[1/4] Checking Database Migrations..."
php artisan migrate --force

echo "[2/4] Preparing Frontend Assets (Vite)..."
if [ ! -d "node_modules" ]; then
    echo "node_modules not found. Installing dependencies..."
    npm install
fi
echo "Building assets..."
npm run build

echo "[3/4] Starting Laravel Development Server..."
echo "The application will be available at: http://127.0.0.1:8000"
echo ""
echo "Press Ctrl+C to stop the server."
echo "=========================================="
php artisan serve
