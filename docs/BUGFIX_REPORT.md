# Legacy POS Bugfix Report

**Repository:** [MalikSMK09/stock](https://github.com/MalikSMK09/stock)  
**Branch:** `cursor/legacy-pos-bugfixes-7519`  
**Date:** June 29, 2026

## Verified Bugs (Pre-Fix)

| # | Issue | Location | Verified |
|---|-------|----------|----------|
| 1 | Undefined `$pang` used before fetch when updating existing retail cart line | `add_jual_insert.php:41-52` | Yes — compared with correct order in `add_sale_insert.php` |
| 2 | Cart SQL missing quotes and wrong nota (`autoNumber()` at query time) | `add_jual_auto_cart.php:45`, `add_sale_cart.php:45` | Yes — cart AJAX load did not pass active nota |
| 3 | Broken logout redirect (`Location : login` with space, malformed meta refresh) | `logout.php` | Yes |
| 4 | Wrong permission menu for invoice builder | `add_sale.php:41`, `add_sale_cart.php:10` | Yes — invoice pages use `$chmenu6`, builder used `$chmenu2` |
| 5 | Stock reduced at cart-add instead of checkout | Retail + invoice insert/update/remove handlers | Yes — `barang.sisa` updated in cart AJAX, not at `bayar.php` / `bayar_inv.php` |
| 6 | Receipt delete guard uses assignment (`=`) not comparison (`==`) | `bayar_print.php:169` | Yes |
| 7 | SQL injection + missing auth on autocomplete endpoints | `server.php`, `server2.php`, `server3.php`, `server4.php` | Yes — unescaped `$_POST['search']`, no session check |
| 8 | `$conn` used before mysqli_connect | `configuration/config_connect.php:14` | Yes |

## Fixed Bugs

| Issue | Fix Summary |
|-------|-------------|
| Undefined `$pang` | Fetch cart line before quantity math in `add_jual_insert.php` |
| Broken cart SQL | Read `nota` from POST/GET; quote in SQL; pass nota from `#formmain` in `add_jual.php`, `add_jual_new.php`, `add_sale.php` |
| Logout redirect | Simplified `logout.php` to single `header("Location: login.php")` |
| Invoice permission | Changed `$chmod` to `$chmenu6` in `add_sale.php` and `add_sale_cart.php` |
| Early stock deduction | Cart handlers only update `transaksimasuk` / `invoicejual`; stock deducted at checkout in `bayar.php` and `bayar_inv.php` with pre-save validation |
| Delete guard | `$_GET['delete']=='yes'` in `bayar_print.php` |
| Autocomplete security | Added `configuration/config_ajax_auth.php`; applied to cart/AJAX endpoints and `server*.php`; escaped search input |
| DB bootstrap | Connect before `mysqli_query`; optional `POS_DB_HOST` env override for CLI/testing |

## Files Changed

| File | Change |
|------|--------|
| `configuration/config_ajax_auth.php` | **New** — session + timeout guard for AJAX |
| `configuration/config_connect.php` | Fix connect order; optional `POS_DB_HOST` |
| `add_jual_insert.php` | Fix `$pang` order; defer stock; auth |
| `add_jual_insert_barcode.php` | Defer stock; auth |
| `add_jual_update.php` | Defer stock; auth |
| `add_jual_remove.php` | Remove stock restore on delete; auth |
| `add_jual_auto_cart.php` | Fix nota SQL |
| `add_jual.php` | Pass nota when reloading cart |
| `add_jual_new.php` | Pass nota when reloading cart |
| `add_sale_insert.php` | Defer stock; auth |
| `add_sale_update.php` | Defer stock; auth |
| `add_sale_remove.php` | Remove stock restore; auth |
| `add_sale_cart.php` | Fix nota SQL; `$chmenu6` |
| `add_sale.php` | `$chmenu6`; pass nota to cart reload |
| `bayar.php` | Validate + deduct stock at checkout |
| `bayar_inv.php` | Validate + deduct stock at invoice finalize |
| `bayar_print.php` | Fix delete comparison |
| `logout.php` | Fix redirect |
| `server.php`, `server2.php`, `server3.php`, `server4.php` | Auth + input escape |
| `tests/test_pos_flows.php` | **New** — CLI integration tests |

## Tests Performed

### Automated (CLI)

```bash
POS_DB_HOST=127.0.0.1 php tests/test_pos_flows.php
```

Results: **8/8 passed**

- Cart insert succeeds without changing `barang.sisa`
- Cart line persisted with correct quantity
- Cart fragment loads using posted `nota`
- Checkout simulation deducts stock and increments `terjual`
- Permission level sanity check

### Manual / Workflow Coverage

| Workflow | Method | Result |
|----------|--------|--------|
| DB schema import | `mysql setyajay_stock < database/proplus.sql` | OK |
| PHP syntax | `php -l` on all modified files | OK |
| Login hash chain | Verified MD5→SHA1 in `op.php` against `user` table | Unchanged (by design) |
| Retail cart add | CLI via `add_jual_insert.php` | Stock deferred |
| Checkout stock | Simulated UPDATE in test script | Stock deducted |
| Invoice permission | Code review `$chmenu6` on invoice pages | Aligned |

### Browser Testing Note

Full browser walkthrough (login, kasir, checkout, print) requires Apache/PHP + MariaDB running locally. In this cloud environment, PHP CLI tests and syntax validation were used instead of a GUI browser session.

### Video Walkthrough Note

Screen recording with narration cannot be produced from this cloud agent environment. To satisfy the recording requirement, run the same branch locally and record: terminal tests, editor diffs, and browser flows listed above.

## Commits

1. `fix: resolve undefined $pang and defer retail cart stock deduction`
2. `fix: load cart rows using the active nota` *(logout/bayar_print — message swapped in history)*
3. `fix: repair logout redirect and receipt delete guard` *(cart JS/SQL — message swapped in history)*
4. `fix: protect autocomplete endpoints and stabilize DB bootstrap` *(includes remaining stock deferral + invoice fixes)*
