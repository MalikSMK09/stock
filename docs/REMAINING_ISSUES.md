# Remaining Issues (Not Fixed)

These items were identified during audit and review but intentionally left unchanged to preserve stability and limit scope.

## Security

| Priority | Issue | Notes |
|----------|-------|-------|
| Critical | Widespread SQL injection via string-concatenated queries | Only `server*.php` search input was escaped; full prepared-statement migration is a large effort |
| High | MD5 + SHA1 password hashing without salt | Changing hash algorithm requires migration path for existing `user.pa_ssword` values |
| High | Hardcoded DB credentials in `configuration/config_connect.php` | Should move to environment variables / `.env` outside web root |
| Medium | No CSRF tokens on forms | All POST endpoints accept requests without tokens |
| Medium | Session fixation not addressed | No `session_regenerate_id()` on login |
| Medium | PIN stored as SHA1 in `pin` table | Weak hash for sensitive operations |
| Low | UI-only authorization on some pages | Menu `$chmod` gates UI; not all server paths re-check role level |

## Deprecated / Compatibility

| Issue | Impact |
|-------|--------|
| `mcrypt` in `configuration/config_encrypt.php` | Fatal on PHP 7.2+ if encryption path is invoked |
| Vendored PHPExcel | Unmaintained; PHP 8 incompatible |
| AdminLTE 2 / Bootstrap 3 / jQuery stack | EOL frontend dependencies |
| `error_reporting(0)` on login and many pages | Hides runtime errors |

## Logic / Data Integrity

| Issue | Notes |
|-------|-------|
| Orphan cart rows in `transaksimasuk` / `invoicejual` | Abandoned carts leave stale lines (stock no longer affected after this fix) |
| No foreign keys in schema | Referential integrity enforced only in PHP |
| Denormalized stock counters on `barang` | `sisa`, `terjual`, `terbeli` can drift if manual DB edits occur |
| Concurrent cart overselling | Two kasir sessions can still race on the same SKU without row locking |
| `add_jual_auto.php` and other autocomplete backends | Not all autocomplete files were hardened in this pass |
| Legacy orphan file `pengaturan.php` | References non-existent include paths |

## Known Minor Bugs (Low Priority)

| Issue | Location |
|-------|----------|
| Demo URL gate on login | `op.php:33` — special branch for `http://idwares.esy.es` |
| Duplicate parallel kasir implementation | `add_jual_new.php` / `bayar_new.php` |
| `invoicejual_old` legacy table | Schema remnant |
| Typo in variable naming | Historical `$sise` patterns in older files |

## Operational

| Issue | Notes |
|-------|-------|
| No automated CI pipeline | Tests added manually under `tests/` |
| No Composer dependency management for app core | PHPExcel vendored in-tree |
| Database name mismatch | Dump uses `proplus`; config uses `setyajay_stock` |
