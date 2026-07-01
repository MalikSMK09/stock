<?php
/**
 * SecurityBootstrap - Central security layer for SQL injection, DDoS, and attack mitigation.
 */
class SecurityBootstrap
{
    private static $initialized = false;
    private static $storageDir = null;

    const RATE_LIMIT_WINDOW = 60;
    const RATE_LIMIT_MAX_REQUESTS = 120;
    const LOGIN_MAX_ATTEMPTS = 5;
    const LOGIN_LOCKOUT_SECONDS = 900;
    const BLOCK_DURATION_SECONDS = 3600;

    public static function init()
    {
        if (self::$initialized) {
            return;
        }
        self::$initialized = true;
        self::$storageDir = dirname(__DIR__) . '/tmp/security';

        if (!is_dir(self::$storageDir)) {
            @mkdir(self::$storageDir, 0750, true);
        }

        self::sendSecurityHeaders();
        self::blockMaliciousUserAgents();
        self::enforceRateLimit();
        self::scanRequestPayload();
        self::hardenSession();
    }

    public static function sendSecurityHeaders()
    {
        if (headers_sent()) {
            return;
        }

        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');

        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        }
    }

    public static function blockMaliciousUserAgents()
    {
        $ua = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
        $blocked = [
            'sqlmap', 'nikto', 'nmap', 'masscan', 'acunetix', 'nessus',
            'openvas', 'w3af', 'havij', 'pangolin', 'dirbuster', 'gobuster',
            'wpscan', 'burpsuite', 'zaproxy', 'owasp', 'hydra', 'metasploit',
        ];

        foreach ($blocked as $pattern) {
            if (strpos($ua, $pattern) !== false) {
                self::logEvent('blocked_user_agent', ['ua' => $ua]);
                self::deny(403, 'Akses ditolak.');
            }
        }
    }

    public static function enforceRateLimit($context = 'global', $maxRequests = null, $window = null)
    {
        $ip = self::getClientIp();
        if (self::isIpBlocked($ip)) {
            self::deny(429, 'Terlalu banyak permintaan. Coba lagi nanti.');
        }

        $max = $maxRequests ?? self::RATE_LIMIT_MAX_REQUESTS;
        $win = $window ?? self::RATE_LIMIT_WINDOW;
        $key = self::sanitizeKey($context . '_' . $ip);
        $file = self::$storageDir . '/rate_' . $key . '.json';
        $now = time();
        $data = ['count' => 0, 'start' => $now, 'blocked_until' => 0];

        if (file_exists($file)) {
            $raw = @file_get_contents($file);
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $data = $decoded;
            }
        }

        if (!empty($data['blocked_until']) && $data['blocked_until'] > $now) {
            self::deny(429, 'IP diblokir sementara karena aktivitas mencurigakan.');
        }

        if (($now - $data['start']) > $win) {
            $data = ['count' => 0, 'start' => $now, 'blocked_until' => 0];
        }

        $data['count']++;

        if ($data['count'] > $max) {
            $data['blocked_until'] = $now + self::BLOCK_DURATION_SECONDS;
            self::writeJson($file, $data);
            self::logEvent('rate_limit_exceeded', ['ip' => $ip, 'context' => $context, 'count' => $data['count']]);
            self::deny(429, 'Terlalu banyak permintaan. Coba lagi nanti.');
        }

        self::writeJson($file, $data);
    }

    public static function checkLoginAttempt($username)
    {
        self::enforceRateLimit('login', self::LOGIN_MAX_ATTEMPTS, self::LOGIN_LOCKOUT_SECONDS);
        $ip = self::getClientIp();
        $key = self::sanitizeKey('login_fail_' . $ip . '_' . $username);
        $file = self::$storageDir . '/' . $key . '.json';
        $now = time();
        $data = ['count' => 0, 'start' => $now, 'locked_until' => 0];

        if (file_exists($file)) {
            $decoded = json_decode(@file_get_contents($file), true);
            if (is_array($decoded)) {
                $data = $decoded;
            }
        }

        if (!empty($data['locked_until']) && $data['locked_until'] > $now) {
            $remaining = $data['locked_until'] - $now;
            self::deny(429, 'Akun terkunci. Coba lagi dalam ' . ceil($remaining / 60) . ' menit.');
        }

        if (($now - $data['start']) > self::LOGIN_LOCKOUT_SECONDS) {
            $data = ['count' => 0, 'start' => $now, 'locked_until' => 0];
        }

        return $file;
    }

    public static function recordLoginFailure($attemptFile)
    {
        $data = ['count' => 0, 'start' => time(), 'locked_until' => 0];
        if (file_exists($attemptFile)) {
            $decoded = json_decode(@file_get_contents($attemptFile), true);
            if (is_array($decoded)) {
                $data = $decoded;
            }
        }

        $data['count']++;
        if ($data['count'] >= self::LOGIN_MAX_ATTEMPTS) {
            $data['locked_until'] = time() + self::LOGIN_LOCKOUT_SECONDS;
            self::logEvent('login_lockout', ['ip' => self::getClientIp()]);
        }

        self::writeJson($attemptFile, $data);
    }

    public static function clearLoginAttempts($attemptFile)
    {
        if (file_exists($attemptFile)) {
            @unlink($attemptFile);
        }
    }

    public static function scanRequestPayload()
    {
        $sources = [
            $_GET ?? [],
            $_POST ?? [],
            $_COOKIE ?? [],
        ];

        $patterns = [
            '/(\bunion\b.+\bselect\b)/i',
            '/(\bselect\b.+\bfrom\b)/i',
            '/(\binsert\b.+\binto\b)/i',
            '/(\bupdate\b.+\bset\b)/i',
            '/(\bdelete\b.+\bfrom\b)/i',
            '/(\bdrop\b.+\b(table|database)\b)/i',
            '/(\bor\b\s+[\'"]?\d+[\'"]?\s*=\s*[\'"]?\d+)/i',
            '/(\band\b\s+[\'"]?\d+[\'"]?\s*=\s*[\'"]?\d+)/i',
            '/(\bsleep\s*\(\s*\d+\s*\))/i',
            '/(\bbenchmark\s*\()/i',
            '/(\bload_file\s*\()/i',
            '/(\binto\s+outfile\b)/i',
            '/(\binformation_schema\b)/i',
            '/(\bextractvalue\s*\()/i',
            '/(\bupdatexml\s*\()/i',
            '/(\bexec\b|\bexecute\b|\bxp_cmdshell\b)/i',
            '/(<script[\s>])/i',
            '/(javascript\s*:)/i',
            '/(\bon\w+\s*=)/i',
        ];

        foreach ($sources as $source) {
            self::scanArray($source, $patterns);
        }
    }

    private static function scanArray($data, $patterns, $path = '')
    {
        foreach ($data as $key => $value) {
            $currentPath = $path === '' ? (string) $key : $path . '.' . $key;

            if (is_array($value)) {
                self::scanArray($value, $patterns, $currentPath);
                continue;
            }

            if (!is_string($value) && !is_numeric($value)) {
                continue;
            }

            $stringValue = (string) $value;

            if (strlen($stringValue) > 8192) {
                self::logEvent('payload_too_large', ['field' => $currentPath]);
                self::deny(413, 'Payload terlalu besar.');
            }

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $stringValue)) {
                    self::logEvent('waf_block', [
                        'ip' => self::getClientIp(),
                        'field' => $currentPath,
                        'value' => substr($stringValue, 0, 200),
                    ]);
                    self::deny(403, 'Permintaan ditolak oleh sistem keamanan.');
                }
            }
        }
    }

    public static function hardenSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', '1');
            ini_set('session.use_strict_mode', '1');
            ini_set('session.cookie_samesite', 'Strict');

            if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
                ini_set('session.cookie_secure', '1');
            }
        }
    }

    public static function generateCsrfToken()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['_csrf_token'];
    }

    public static function validateCsrfToken($token)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($token) || empty($_SESSION['_csrf_token'])) {
            return false;
        }

        return hash_equals($_SESSION['_csrf_token'], $token);
    }

    public static function csrfField()
    {
        $token = self::generateCsrfToken();
        return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function requireCsrf()
    {
        $token = $_POST['_csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (!self::validateCsrfToken($token)) {
            self::logEvent('csrf_failure', ['ip' => self::getClientIp()]);
            self::deny(403, 'Token keamanan tidak valid. Muat ulang halaman.');
        }
    }

    public static function hashPassword($password)
    {
        return hash('sha256', md5($password));
    }

    public static function allowedTables()
    {
        return [
            'barang', 'supplier', 'pelanggan', 'kategori', 'brand', 'user', 'jabatan',
            'buy', 'sale', 'invoicebeli', 'invoicejual', 'stok_masuk', 'stok_keluar',
            'stok_masuk_daftar', 'stok_keluar_daftar', 'stok_sesuai_daftar',
            'quotation', 'quotation_list', 'hutang', 'payment', 'mutasi',
            'transaksimasuk', 'dataretur', 'retur', 'operasional', 'rekening',
            'surat', 'bayar', 'pin', 'buy_hutang', 'buy_payment', 'sale_payment',
        ];
    }

    public static function allowedExportTypes()
    {
        return ['bayar', 'barang', 'buy', 'revenue', 'income', 'operasional', 'sale', 'mutasi'];
    }

    public static function allowedDeletionTables()
    {
        return ['barang', 'supplier', 'pelanggan'];
    }

    public static function whitelistTable($name)
    {
        $name = strtolower(trim((string) $name));
        if (!preg_match('/^[a-z][a-z0-9_]{0,63}$/', $name)) {
            self::logEvent('invalid_table', ['table' => $name]);
            self::deny(403, 'Nama tabel tidak valid.');
        }
        if (!in_array($name, self::allowedTables(), true)) {
            self::logEvent('table_not_whitelisted', ['table' => $name]);
            self::deny(403, 'Tabel tidak diizinkan.');
        }
        return $name;
    }

    public static function whitelistExport($name)
    {
        $name = strtolower(trim((string) $name));
        if (!in_array($name, self::allowedExportTypes(), true)) {
            self::logEvent('export_not_whitelisted', ['type' => $name]);
            self::deny(403, 'Export tidak diizinkan.');
        }
        return $name;
    }

    public static function whitelistDeletionTable($name)
    {
        $name = strtolower(trim((string) $name));
        if (!in_array($name, self::allowedDeletionTables(), true)) {
            self::logEvent('deletion_table_denied', ['table' => $name]);
            self::deny(403, 'Penghapusan tabel tidak diizinkan.');
        }
        return $name;
    }

    public static function whitelistPage($name)
    {
        $name = strtolower(trim((string) $name));
        if (!preg_match('/^[a-z][a-z0-9_]{0,63}$/', $name)) {
            self::logEvent('invalid_page', ['page' => $name]);
            self::deny(403, 'Halaman tidak valid.');
        }
        return $name;
    }

    public static function execute($conn, $sql, $types = '', $params = [])
    {
        $stmt = self::query($conn, $sql, $types, $params);
        if (!$stmt) {
            return false;
        }
        $ok = mysqli_stmt_execute($stmt);
        $affected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $ok ? $affected : false;
    }

    public static function deleteWhere($conn, $table, $column, $value, $type = 's')
    {
        $table = self::whitelistTable($table);
        if (!preg_match('/^[a-z][a-z0-9_]{0,63}$/', $column)) {
            self::deny(403, 'Kolom tidak valid.');
        }
        return self::execute($conn, "DELETE FROM `{$table}` WHERE `{$column}` = ?", $type, [$value]);
    }

    public static function updateBarangByKode($conn, $kode, $fields)
    {
        $allowed = ['sisa', 'terbeli', 'terjual', 'retur'];
        $sets = [];
        $types = '';
        $params = [];
        foreach ($fields as $col => $val) {
            if (!in_array($col, $allowed, true)) {
                continue;
            }
            $sets[] = "`{$col}` = ?";
            $types .= is_int($val) ? 'i' : 's';
            $params[] = $val;
        }
        if (empty($sets)) {
            return false;
        }
        $types .= 's';
        $params[] = $kode;
        $sql = 'UPDATE barang SET ' . implode(', ', $sets) . ' WHERE kode = ?';
        return self::execute($conn, $sql, $types, $params);
    }

    public static function hasDeletePermission($chmod)
    {
        $chmod = (int) $chmod;
        $jabatan = $_SESSION['jabatan'] ?? '';
        return ($chmod >= 4 && $chmod <= 5)
            || $jabatan === 'admin'
            || $jabatan === 'guru';
    }

    public static function hasAdminDeletePermission($chmod)
    {
        $chmod = (int) $chmod;
        return ($chmod >= 4 && $chmod <= 5) || ($_SESSION['jabatan'] ?? '') === 'admin';
    }

    public static function paramInt($value, $default = 0)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false
            ? (int) filter_var($value, FILTER_VALIDATE_INT)
            : $default;
    }

    public static function paramFloat($value, $default = 0.0)
    {
        return is_numeric($value) ? (float) $value : $default;
    }

    public static function paramStr($value, $maxLength = 255)
    {
        return self::sanitizeString($value, $maxLength);
    }

    public static function safeRedirectPage($page)
    {
        return self::whitelistPage($page);
    }

    public static function secureNota($value, $maxLength = 64)
    {
        return self::paramStr($value, $maxLength);
    }

    public static function secureSearch($value, $maxLength = 100)
    {
        return self::paramStr($value, $maxLength);
    }

    public static function sanitizeDate($value, $allowEmpty = false)
    {
        $value = trim((string) $value);
        if ($value === '') {
            return $allowEmpty ? '' : self::deny(400, 'Tanggal wajib diisi.');
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            self::deny(400, 'Format tanggal tidak valid.');
        }
        return $value;
    }

    public static function sanitizeYear($value)
    {
        $year = self::paramInt($value, 0);
        if ($year < 2000 || $year > 2100) {
            return (int) date('Y');
        }
        return $year;
    }

    public static function sanitizeMonth($value)
    {
        $month = self::paramInt($value, 0);
        if ($month < 1 || $month > 12) {
            return date('m');
        }
        return str_pad((string) $month, 2, '0', STR_PAD_LEFT);
    }

    public static function supplierFilter($value)
    {
        $value = trim((string) $value);
        if ($value === 'all') {
            return 'all';
        }
        return self::paramStr($value, 64);
    }

    public static function countByNota($conn, $table, $nota)
    {
        $table = self::whitelistTable($table);
        $row = self::queryOne($conn, "SELECT COUNT(nota) AS data FROM `{$table}` WHERE nota = ?", 's', [$nota]);
        return (int) ($row['data'] ?? 0);
    }

    public static function sumJumlahByNota($conn, $table, $nota, $alias = 'tot')
    {
        $table = self::whitelistTable($table);
        $row = self::queryOne($conn, "SELECT SUM(jumlah) AS {$alias} FROM `{$table}` WHERE nota = ?", 's', [$nota]);
        return $row[$alias] ?? 0;
    }

    public static function reportSearchCount($conn, $table, $search, array $columns)
    {
        $table = self::whitelistTable($table);
        if ($search === '') {
            $row = self::queryOne($conn, "SELECT COUNT(*) AS totaldata FROM `{$table}`");
            return (int) ($row['totaldata'] ?? 0);
        }

        $like = '%' . self::escapeLike($search) . '%';
        $clauses = [];
        $types = '';
        $params = [];
        foreach ($columns as $column) {
            if (!preg_match('/^[a-z][a-z0-9_]{0,63}$/', $column)) {
                continue;
            }
            $clauses[] = "`{$column}` LIKE ? ESCAPE '\\\\'";
            $types .= 's';
            $params[] = $like;
        }
        if (empty($clauses)) {
            return 0;
        }
        $sql = 'SELECT COUNT(*) AS totaldata FROM `' . $table . '` WHERE ' . implode(' OR ', $clauses);
        $row = self::queryOne($conn, $sql, $types, $params);
        return (int) ($row['totaldata'] ?? 0);
    }

    public static function reportRevenueCount($conn, $year, $month)
    {
        if ($year === '' || $year === null) {
            $row = self::queryOne(
                $conn,
                'SELECT COUNT(*) AS totaldata FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk)'
            );
        } else {
            $dateLike = $year . '-' . $month . '-%';
            $row = self::queryOne(
                $conn,
                'SELECT COUNT(*) AS totaldata FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE ?',
                's',
                [$dateLike]
            );
        }
        return (int) ($row['totaldata'] ?? 0);
    }

    public static function sumCartByNota($conn, $table, $nota, $expression = 'total')
    {
        $table = self::whitelistTable($table);
        $allowed = [
            'harga*jumlah' => 'SELECT SUM(harga * jumlah) AS data FROM',
            'hargabeli*jumlah' => 'SELECT SUM(hargabeli * jumlah) AS data FROM',
            'hargaakhir' => 'SELECT SUM(hargaakhir) AS data FROM',
            'modal' => 'SELECT SUM(modal) AS data FROM',
            'total' => 'SELECT SUM(total) AS data FROM',
        ];
        if (!isset($allowed[$expression])) {
            return 0;
        }
        $row = self::queryOne($conn, $allowed[$expression] . " `{$table}` WHERE nota = ?", 's', [$nota]);
        return $row['data'] ?? 0;
    }

    public static function optionalDate($value)
    {
        $value = trim((string) $value);
        if ($value === '') {
            return '';
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            self::deny(400, 'Format tanggal tidak valid.');
        }
        return $value;
    }

    public static function secureFakturType($tipe)
    {
        $tipe = strtolower(trim((string) $tipe));
        return in_array($tipe, ['quotation', 'sale', 'invoice', 'jual'], true) ? $tipe : 'quotation';
    }

    public static function pelangganName($conn, $kode)
    {
        $row = self::queryOne($conn, 'SELECT nama FROM pelanggan WHERE kode = ? LIMIT 1', 's', [$kode]);
        return $row['nama'] ?? '';
    }

    public static function saleExists($conn, $nota)
    {
        return (bool) self::queryOne($conn, 'SELECT nota FROM sale WHERE nota = ? LIMIT 1', 's', [$nota]);
    }

    public static function insertSaleInvoice($conn, $fields)
    {
        return self::execute(
            $conn,
            "INSERT INTO sale VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '', '', '', ?, ?, '', '')",
            'ssssdddddsdddssss',
            [
                $fields['nota'], $fields['nomor'], $fields['tglnota'], $fields['duedate'],
                $fields['sub'], $fields['perdis'], $fields['diskon'], $fields['ppn'],
                $fields['nomtax'], $fields['bnama'], $fields['biaya'], $fields['total'],
                $fields['databelitotal'], $fields['pelanggan'], $fields['kasir'],
                $fields['keterangan'], $fields['status'],
            ]
        );
    }

    public static function insertSaleFromQuotation($conn, $fields)
    {
        return self::execute(
            $conn,
            "INSERT INTO sale VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '', ?, ?, '', '')",
            'ssssddddsssss',
            [
                $fields['nota'], $fields['nomor'], $fields['tglnota'], $fields['duedate'],
                $fields['total'], $fields['diskon'], $fields['pot'], $fields['biaya'],
                $fields['databelitotal'], $fields['pelanggan'], $fields['kasir'],
                $fields['keterangan'], $fields['status'],
            ]
        );
    }

    public static function recordSaleMutations($conn, $nota, $kasir, $kegiatan = 'Penjualan Sales')
    {
        $today = date('Y-m-d');
        $jam = date('H:i');
        $items = self::queryAll($conn, 'SELECT kode, jumlah FROM invoicejual WHERE nota = ?', 's', [$nota]);
        foreach ($items as $rw) {
            $stock = self::queryOne($conn, 'SELECT sisa FROM barang WHERE kode = ? LIMIT 1', 's', [$rw['kode']]);
            self::execute(
                $conn,
                "INSERT INTO mutasi (namauser, tgl, jam, kodebarang, sisa, jumlah, kegiatan, keterangan, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'berhasil')",
                'ssssisss',
                [$kasir, $today, $jam, $rw['kode'], $stock['sisa'] ?? 0, $rw['jumlah'], $kegiatan, $nota, '']
            );
        }
    }

    public static function query($conn, $sql, $types = '', $params = [])
    {
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            self::logEvent('db_prepare_error', ['error' => mysqli_error($conn)]);
            return false;
        }

        if ($types !== '' && !empty($params)) {
            $bind = [$types];
            foreach ($params as $key => $value) {
                $bind[] = &$params[$key];
            }
            call_user_func_array([$stmt, 'bind_param'], $bind);
        }

        if (!mysqli_stmt_execute($stmt)) {
            self::logEvent('db_execute_error', ['error' => mysqli_stmt_error($stmt)]);
            mysqli_stmt_close($stmt);
            return false;
        }

        return $stmt;
    }

    public static function queryAll($conn, $sql, $types = '', $params = [])
    {
        $stmt = self::query($conn, $sql, $types, $params);
        if (!$stmt) {
            return [];
        }

        $result = mysqli_stmt_get_result($stmt);
        $rows = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
        }
        mysqli_stmt_close($stmt);
        return $rows;
    }

    public static function queryOne($conn, $sql, $types = '', $params = [])
    {
        $rows = self::queryAll($conn, $sql, $types, $params);
        return $rows[0] ?? null;
    }

    public static function escapeLike($value)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $value);
    }

    public static function sanitizeString($value, $maxLength = 255)
    {
        $value = trim((string) $value);
        $value = strip_tags($value);
        if (strlen($value) > $maxLength) {
            $value = substr($value, 0, $maxLength);
        }
        return $value;
    }

    public static function sanitizeInt($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false
            ? (int) filter_var($value, FILTER_VALIDATE_INT)
            : 0;
    }

    public static function requireAuth()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['username'])) {
            self::deny(401, 'Autentikasi diperlukan.');
        }

        if (function_exists('login_check') && !login_check()) {
            self::deny(401, 'Sesi telah berakhir.');
        }
    }

    public static function logEvent($type, $context = [])
    {
        $line = json_encode([
            'time' => date('c'),
            'type' => $type,
            'ip' => self::getClientIp(),
            'uri' => $_SERVER['REQUEST_URI'] ?? '',
            'method' => $_SERVER['REQUEST_METHOD'] ?? '',
            'context' => $context,
        ], JSON_UNESCAPED_UNICODE);

        $logFile = self::$storageDir . '/security.log';
        @file_put_contents($logFile, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    public static function getRecentEvents($limit = 50)
    {
        $logFile = self::$storageDir . '/security.log';
        if (!file_exists($logFile)) {
            return [];
        }

        $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!$lines) {
            return [];
        }

        $events = [];
        $slice = array_slice($lines, -$limit);
        foreach ($slice as $line) {
            $decoded = json_decode($line, true);
            if (is_array($decoded)) {
                $events[] = $decoded;
            }
        }

        return array_reverse($events);
    }

    public static function getSecurityStats()
    {
        $events = self::getRecentEvents(500);
        $stats = [
            'total_events' => count($events),
            'waf_blocks' => 0,
            'rate_limits' => 0,
            'login_lockouts' => 0,
            'csrf_failures' => 0,
            'blocked_agents' => 0,
        ];

        foreach ($events as $event) {
            $type = $event['type'] ?? '';
            if ($type === 'waf_block') {
                $stats['waf_blocks']++;
            } elseif ($type === 'rate_limit_exceeded') {
                $stats['rate_limits']++;
            } elseif ($type === 'login_lockout') {
                $stats['login_lockouts']++;
            } elseif ($type === 'csrf_failure') {
                $stats['csrf_failures']++;
            } elseif ($type === 'blocked_user_agent') {
                $stats['blocked_agents']++;
            }
        }

        return $stats;
    }

    private static function getClientIp()
    {
        $candidates = [
            $_SERVER['HTTP_CF_CONNECTING_IP'] ?? '',
            $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '',
            $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
        ];

        foreach ($candidates as $candidate) {
            if ($candidate === '') {
                continue;
            }
            $parts = explode(',', $candidate);
            $ip = trim($parts[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }

        return '0.0.0.0';
    }

    private static function isIpBlocked($ip)
    {
        $file = self::$storageDir . '/blocked_' . self::sanitizeKey($ip) . '.json';
        if (!file_exists($file)) {
            return false;
        }

        $data = json_decode(@file_get_contents($file), true);
        if (!is_array($data)) {
            return false;
        }

        return !empty($data['blocked_until']) && $data['blocked_until'] > time();
    }

    private static function sanitizeKey($value)
    {
        return preg_replace('/[^a-zA-Z0-9_\-]/', '_', $value);
    }

    private static function writeJson($file, $data)
    {
        @file_put_contents($file, json_encode($data), LOCK_EX);
    }

    private static function deny($code, $message)
    {
        http_response_code($code);
        if (self::isAjaxRequest()) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['error' => true, 'message' => $message]);
        } else {
            echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Keamanan</title></head><body>';
            echo '<h1>Akses Ditolak</h1><p>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</p>';
            echo '</body></html>';
        }
        exit;
    }

    private static function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
