#!/usr/bin/env bash
# Update TNS Card to the latest version on GitHub, after making a backup.
# Run as root from anywhere:
#   sudo bash /var/www/tnscard/update.sh
set -euo pipefail

APP_DIR="$(cd "$(dirname "$0")" && pwd)"
BACKUP_DIR="${BACKUP_DIR:-/var/backups/tnscard}"
KEEP_BACKUPS="${KEEP_BACKUPS:-10}"

if [ "$(id -u)" -ne 0 ]; then echo "Please run as root (sudo)."; exit 1; fi
cd "$APP_DIR"

echo "==> Backing up settings, database and uploaded images"
mkdir -p "$BACKUP_DIR"
STAMP="$(date +%Y%m%d-%H%M%S)"
tar -czf "$BACKUP_DIR/tnscard-$STAMP.tar.gz" --ignore-failed-read \
  .env database/database.sqlite config/advanced-config.php assets/img assets/favicon themes 2>/dev/null || true
ls -1t "$BACKUP_DIR"/tnscard-*.tar.gz | tail -n +$((KEEP_BACKUPS + 1)) | xargs -r rm -f
echo "    Saved $BACKUP_DIR/tnscard-$STAMP.tar.gz"

echo "==> Downloading the latest version"
sudo -u www-data git checkout -- composer.lock 2>/dev/null || true
sudo -u www-data git pull --ff-only

echo "==> Updating the app"
sudo -u www-data -H bash "$APP_DIR/setup.sh"
systemctl reload apache2 2>/dev/null || apache2ctl -k graceful 2>/dev/null || true

echo
echo "Update finished. Now on version: $(git log -1 --format='%h %s')"
