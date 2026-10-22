# TNS Card

Digital business cards and mini websites by **Team Network Solutions** — [tnscard.com](https://tnscard.com).

Each customer gets a page at `tnscard.com/@username` with their photo, contact buttons, links and "Save Contact". NFC (NTAG213) and QR cards open that page with one tap.

## Install (Proxmox LXC, VM or VPS)

On a fresh **Ubuntu 24.04** or **Debian 12** server, as root:

```bash
curl -fsSL https://raw.githubusercontent.com/TeamNetworkSolutions/tnscard/main/install.sh | bash
```

If an Nginx server handles HTTPS in front of it, give its IP so links use `https://`:

```bash
curl -fsSL https://raw.githubusercontent.com/TeamNetworkSolutions/tnscard/main/install.sh | HTTPS_PROXY_IP=192.168.1.10 DOMAIN=tnscard.com bash
```

The installer sets up Apache, PHP 8 and the app in `/var/www/tnscard`. Then:

1. Point your Nginx at this server, using [`deploy/nginx-reverse-proxy.conf`](deploy/nginx-reverse-proxy.conf).
2. Open the site and finish the setup wizard. Set **Enable registration** to **No**.
3. In **Admin → Config**: add your own SMTP server and set `APP_DEBUG=false`.

Do **not** turn on `FORCE_ROUTE_HTTPS` behind a proxy; Nginx already redirects to HTTPS.

## Update

```bash
bash /var/www/tnscard/update.sh
```

This backs up the settings, database and uploaded images to `/var/backups/tnscard`, downloads the latest version from GitHub and updates the database.

## Files that stay on the server

These are created on the server and never go to GitHub: `.env` (settings and passwords), `database/database.sqlite` (customers), `assets/img` (photos), `config/advanced-config.php`. Back them up — `update.sh` does this automatically, and Proxmox or Hostinger snapshots cover everything.

## License

TNS Card is free software licensed under the **GNU Affero General Public License v3.0** (see [LICENSE](LICENSE)). Because the site runs over a network, its full source code must stay publicly available; the site footer links to it. See [NOTICE.md](NOTICE.md) for credits.
