#!/usr/bin/env bash
# Шаги сборки продакшена. Запускается на сервере из /usr/local/bin/studio-deploy,
# который перед этим уже перевёл рабочую копию на свежий origin/main.
# Править можно пушем — сервер подхватит новую версию со следующего деплоя.
set -euo pipefail
cd /var/www/studio

composer install --no-dev --optimize-autoloader --no-interaction --no-progress
npm ci --no-audit --no-fund
npm run build
# Собранные ассеты лежат в public/build, сами модули на сервере больше не нужны
rm -rf node_modules

php artisan migrate --force
php artisan optimize

# Артизан и composer работают от root и оставляют root-овские файлы в storage и bootstrap/cache
chown -R www-data:www-data /var/www/studio
# Сбрасывает opcache, иначе PHP-FPM ещё какое-то время отдаёт старый код
systemctl reload php8.3-fpm

echo "=== готово: $(git rev-parse --short HEAD) $(git log -1 --pretty=%s)"
