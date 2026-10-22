#!/usr/bin/env bash
# TNS Card app setup. Safe to run more than once.
# Usually called by install.sh; run it yourself only if you set up the web server by hand:
#   bash setup.sh
set -euo pipefail
cd "$(dirname "$0")"

FIRST_RUN=0
if [ ! -f .env ]; then
  cp .env.example .env
  FIRST_RUN=1
fi

# PHP packages. The lock file shipped upstream is incomplete, so fall back to a fresh resolve.
if ! composer install --no-dev --no-scripts --no-interaction --optimize-autoloader; then
  composer update --no-dev --no-scripts --no-interaction --optimize-autoloader
fi

[ -f database/database.sqlite ] || touch database/database.sqlite
grep -q '^APP_KEY=base64:' .env || php artisan key:generate --force
php artisan migrate --force

if [ "$FIRST_RUN" = 1 ]; then
  php artisan db:seed --force
  php artisan db:seed --class="PageSeeder" --force
  php artisan db:seed --class="ButtonSeeder" --force
  touch INSTALLING            # shows the setup wizard on the first visit
fi
touch storage/app/ISINSTALLED

php artisan view:clear >/dev/null
php artisan route:clear >/dev/null
php artisan config:clear >/dev/null

if [ "$FIRST_RUN" = 1 ]; then
  echo "Done. Open the site in your browser to finish the setup wizard."
else
  echo "Done."
fi
