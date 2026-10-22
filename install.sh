#!/usr/bin/env bash
# TNS Card installer for a fresh Ubuntu 24.04 / Debian 12 server, LXC or VPS.
# Run as root:
#   curl -fsSL https://raw.githubusercontent.com/TeamNetworkSolutions/tnscard/main/install.sh | bash
#
# Optional settings (put them before "bash"):
#   DOMAIN=tnscard.com          your site address (default: tnscard.com)
#   HTTPS_PROXY_IP=192.168.1.10 IP of the Nginx server that handles HTTPS in front of this one
#   APP_DIR=/var/www/tnscard    where to install
#   REPO=https://github.com/TeamNetworkSolutions/tnscard.git
#   BRANCH=main
set -euo pipefail

DOMAIN="${DOMAIN:-tnscard.com}"
HTTPS_PROXY_IP="${HTTPS_PROXY_IP:-}"
APP_DIR="${APP_DIR:-/var/www/tnscard}"
REPO="${REPO:-https://github.com/TeamNetworkSolutions/tnscard.git}"
BRANCH="${BRANCH:-main}"

if [ "$(id -u)" -ne 0 ]; then echo "Please run as root (sudo)."; exit 1; fi

echo "==> Installing Apache, PHP and tools"
export DEBIAN_FRONTEND=noninteractive
apt-get update -q
apt-get install -y -q apache2 libapache2-mod-php git unzip curl ca-certificates composer sudo \
  php-cli php-sqlite3 php-mysql php-mbstring php-xml php-curl php-zip php-gd php-bcmath php-intl

echo "==> Downloading TNS Card into $APP_DIR"
if [ ! -d "$APP_DIR/.git" ]; then
  mkdir -p "$(dirname "$APP_DIR")"
  git clone --branch "$BRANCH" "$REPO" "$APP_DIR"
fi
chown -R www-data:www-data "$APP_DIR"
git config --system --add safe.directory "$APP_DIR"

echo "==> Setting up the app"
mkdir -p /var/www/.composer /var/www/.cache && chown -R www-data:www-data /var/www/.composer /var/www/.cache
sudo -u www-data -H bash "$APP_DIR/setup.sh"

if [ -n "$HTTPS_PROXY_IP" ]; then
  sed -i 's/^FORCE_HTTPS=.*/FORCE_HTTPS=true/' "$APP_DIR/.env"
fi

echo "==> Configuring Apache"
a2enmod -q rewrite headers remoteip >/dev/null
TRUSTED_LINE="# No HTTPS proxy configured"
if [ -n "$HTTPS_PROXY_IP" ]; then
  TRUSTED_LINE="RemoteIPHeader X-Forwarded-For
    RemoteIPTrustedProxy $HTTPS_PROXY_IP
    SetEnvIf X-Forwarded-Proto \"^https\$\" HTTPS=on"
fi
cat > /etc/apache2/sites-available/tnscard.conf <<EOF
<VirtualHost *:80>
    ServerName $DOMAIN
    ServerAlias www.$DOMAIN
    DocumentRoot $APP_DIR

    $TRUSTED_LINE

    <Directory $APP_DIR>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # Never serve private files, even if .htaccess is missing
    <FilesMatch "^\.|\.(sqlite|sqlite-journal|log|sh|lock|md|zip)$|^(composer\.json|package\.json|artisan|INSTALLING|INSTALLERLOCK)$">
        Require all denied
    </FilesMatch>
    RedirectMatch 404 ^/(\.git|storage|database|config|app|bootstrap|routes|tests|backups)(/|$)

    ErrorLog \${APACHE_LOG_DIR}/tnscard-error.log
    CustomLog \${APACHE_LOG_DIR}/tnscard-access.log combined
</VirtualHost>
EOF
a2dissite -q 000-default >/dev/null 2>&1 || true
a2ensite -q tnscard >/dev/null
apache2ctl configtest
systemctl reload apache2 2>/dev/null || systemctl restart apache2 2>/dev/null || apache2ctl -k restart

IP="$(hostname -I | awk '{print $1}')"
echo
echo "TNS Card is installed."
echo "  Open http://$IP/ (or https://$DOMAIN once your Nginx points to $IP) to finish the setup wizard."
echo "  To update later: sudo bash $APP_DIR/update.sh"
