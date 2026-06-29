# Modernization Notes (Future Work — Not Implemented)

This document outlines a pragmatic modernization path for IndoTory Pro Plus. None of these changes were applied in the bugfix branch.

## Guiding Principles

1. **Incremental over big-bang** — the app is production-used; migrate one workflow at a time.
2. **Behavior first** — match existing nota, stock, and permission semantics before refactoring structure.
3. **Test before refactor** — expand `tests/test_pos_flows.php` into a full regression suite per workflow.

## Recommended Phases

### Phase 1 — Security Baseline (Low Risk)

- Move DB credentials to environment variables (`POS_DB_HOST`, `POS_DB_USER`, `POS_DB_PASS`, `POS_DB_NAME`).
- Add CSRF tokens to high-impact forms (login, checkout, user admin).
- Regenerate session ID on successful login (`session_regenerate_id(true)`).
- Extend `config_ajax_auth.php` to all AJAX/POST endpoints systematically.
- Password migration: verify with legacy hash, rehash with `password_hash()` on successful login.

### Phase 2 — Data Access Hardening (Medium Risk)

- Introduce thin mysqli wrapper with prepared statements for new/edited queries only.
- Prioritize: login, cart insert/update, checkout, stock in/out.
- Add DB transactions around checkout (`bayar` insert + stock updates + `mutasi`).

### Phase 3 — Stock Integrity (Medium Risk)

- Optional `cart_expires_at` column or cron to purge stale `transaksimasuk` rows older than N hours.
- Row-level locking (`SELECT ... FOR UPDATE`) during checkout stock deduction.
- Periodic reconciliation job: compare `barang.sisa` vs sum of movements in `mutasi`.

### Phase 4 — PHP Runtime Upgrade (Higher Risk)

- Replace `mcrypt` cipher with `sodium` or OpenSSL (`configuration/config_encrypt.php`).
- Replace PHPExcel with PhpSpreadsheet for `import_barang.php`.
- Target PHP 8.2+ with staged compatibility testing.

### Phase 5 — Structural Improvement (Optional, Long Term)

- Extract shared bootstrap into one `bootstrap.php` (session, connect, auth, chmod).
- Group related pages into subfolders **only** with `.htaccess` rewrite aliases to preserve URLs.
- Do **not** adopt a full framework unless the team commits to a multi-month migration.

## What Not To Do

- Do not rewrite as Laravel/React in a single effort — business logic is embedded in 170+ page files.
- Do not change table names or column names without a migration script and dual-write period.
- Do not switch stock model from denormalized counters to pure ledger without a cutover plan.

## Success Metrics

- Zero stock drift on kasir checkout in acceptance tests.
- No unauthenticated AJAX endpoints.
- PHP 8.x compatible with deprecated extensions removed.
- Documented rollback procedure for each phase.
