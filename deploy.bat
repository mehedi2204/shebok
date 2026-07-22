@echo off
echo =========================================
echo  Shebok Production Deployment (Windows)
echo =========================================

echo.
echo [1/5] Building Docker...
docker compose up -d --build

echo.
echo [2/5] Installing Dependencies ^& Building Vite...
docker compose exec -T app composer install --no-dev --optimize-autoloader
docker compose exec -T app npm install
docker compose exec -T app npm run build

echo.
echo [3/5] Running migrations...
docker compose exec -T app php artisan migrate --force

echo.
echo [4/5] Optimizing...
docker compose exec -T app php artisan optimize:clear
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache

echo.
echo [5/5] Restarting...
docker compose restart

echo.
echo =========================================
echo Deployment Successful!
echo =========================================
pause
