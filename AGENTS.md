# AGENTS.md

## Cursor Cloud specific instructions

### What this is
A legacy PHP point-of-sale / inventory web app ("Indotory Pro Plus" / branded "PLAZA ATK"), Indonesian-language. Plain procedural PHP (no framework, no Composer, no Node). Stack: **PHP 7.4 + Apache (mod_php) + MariaDB**. The repository root is the web docroot.

### Runtime version — do NOT "upgrade"
This code targets PHP 7.x (the SQL dump header says PHP 7.1). It is intentionally run on **PHP 7.4**, not the distro default PHP 8.3. On PHP 8 the very first DB include (`configuration/config_connect.php` calls `mysqli_query($conn, ...)` before `$conn` is assigned) throws a fatal `TypeError` and every page 500s. On PHP 7.4 that is only a suppressed warning, so the app works. The Apache PHP module is switched with `a2dismod php8.3 && a2enmod php7.4`. Don't change this to make a page "work" — keep PHP 7.4.

### Services are NOT auto-started on VM boot
After a fresh start you must start them yourself:
```
sudo service mariadb start
sudo service apache2 start
```
App is then at `http://localhost/` (Apache vhost `/etc/apache2/sites-available/indotory.conf`: docroot `/workspace`, `AllowOverride All`, `mod_rewrite` on). The `.htaccess` rewrites extensionless URLs (e.g. `/index`, `/loginagain`) to `.php`, so it must be served by Apache — `php -S` will not honor those rewrites.

### Database
- Connection is **hardcoded** in `configuration/config_connect.php`: db `setyajay_stock`, user `setyajay_user`, password `enter4j4ya#` (localhost).
- Schema + seed data: `database/proplus.sql`.
- If the database/user/tables are missing (e.g. snapshot didn't retain MariaDB data), recreate them:
```
sudo mariadb -e "CREATE DATABASE IF NOT EXISTS setyajay_stock CHARACTER SET utf8mb4;
CREATE USER IF NOT EXISTS 'setyajay_user'@'localhost' IDENTIFIED BY 'enter4j4ya#';
GRANT ALL PRIVILEGES ON setyajay_stock.* TO 'setyajay_user'@'localhost'; FLUSH PRIVILEGES;"
sudo mariadb setyajay_stock < database/proplus.sql   # only when the DB is empty; this is a full seed, not a migration
```

### Login
Seeded admin account: username `admin`, password `admin`. Stored hash = `sha1(md5(plaintext))` (see `op.php`).

### Lint / test / build
There is no test suite, linter config, or build step in this repo (no Composer/PHPUnit/Node). "Build" is a no-op; "run" = serve via Apache. For a quick syntax check use `php -l <file>.php` (run with `php7.4` available on PATH).

### Known gotcha
`mcrypt` is not installed (removed from PHP 8 and not bundled in 7.4). `configuration/config_encrypt.php` (the `Cipher` class) only fatals if its `encrypt()`/`decrypt()` are actually called; the core POS flows (login, dashboard, master-data CRUD, sales) do not use it.
