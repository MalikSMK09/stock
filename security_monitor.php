<!DOCTYPE html>
<html>
<?php
include "configuration/config_include.php";
include "configuration/config_alltotal.php";
include "configuration/config_connect.php";

encryption();
session();
connect();
head();
body();
timing();

if (!login_check()) {
?>
<meta http-equiv="refresh" content="0; url=logout.php" />
<?php
    exit(0);
}

$jabatan = $_SESSION['jabatan'] ?? '';
if (strtolower($jabatan) !== 'admin' && strtolower($jabatan) !== 'administrator') {
    echo '<div class="alert alert-danger">Hanya admin yang dapat mengakses halaman keamanan.</div>';
    footer();
    exit;
}

$stats = SecurityBootstrap::getSecurityStats();
$events = SecurityBootstrap::getRecentEvents(30);
?>
<div class="wrapper">
<?php
theader();
menu();
?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Security Monitor <small>Perlindungan SQL Injection &amp; DDoS</small></h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php echo (int) $stats['waf_blocks']; ?></h3>
                            <p>WAF Blocks</p>
                        </div>
                        <div class="icon"><i class="fa fa-shield"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo (int) $stats['rate_limits']; ?></h3>
                            <p>Rate Limit Hits</p>
                        </div>
                        <div class="icon"><i class="fa fa-tachometer"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo (int) $stats['login_lockouts']; ?></h3>
                            <p>Login Lockouts</p>
                        </div>
                        <div class="icon"><i class="fa fa-lock"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php echo (int) $stats['blocked_agents']; ?></h3>
                            <p>Scanner Blocked</p>
                        </div>
                        <div class="icon"><i class="fa fa-ban"></i></div>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Lapisan Keamanan Aktif</h3>
                </div>
                <div class="box-body">
                    <ul>
                        <li><strong>SQL Injection WAF</strong> &mdash; Memindai semua input GET/POST/COOKIE untuk pola sqlmap dan payload berbahaya.</li>
                        <li><strong>Prepared Statements</strong> &mdash; Endpoint kritis (login, autocomplete, ajax) menggunakan query terparameterisasi.</li>
                        <li><strong>Rate Limiting</strong> &mdash; Maks. 120 request/menit per IP; login dibatasi 5 percobaan per 15 menit.</li>
                        <li><strong>CSRF Protection</strong> &mdash; Token keamanan pada form login dan aksi sensitif.</li>
                        <li><strong>Security Headers</strong> &mdash; X-Frame-Options, X-Content-Type-Options, HSTS (HTTPS).</li>
                        <li><strong>Scanner Blocking</strong> &mdash; User-agent sqlmap, nikto, burpsuite, dan alat serangan umum diblokir.</li>
                    </ul>
                </div>
            </div>

            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Log Keamanan Terbaru</h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>Waktu</th>
                            <th>Event</th>
                            <th>IP</th>
                            <th>URI</th>
                        </tr>
                        <?php if (empty($events)) { ?>
                        <tr><td colspan="4">Belum ada event keamanan tercatat.</td></tr>
                        <?php } else { ?>
                            <?php foreach ($events as $event) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['time'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><span class="label label-danger"><?php echo htmlspecialchars($event['type'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span></td>
                                <td><?php echo htmlspecialchars($event['ip'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($event['uri'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <?php } ?>
                        <?php } ?>
                    </table>
                </div>
            </div>

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Rekomendasi Produksi</h3>
                </div>
                <div class="box-body">
                    <ol>
                        <li>Salin <code>configuration/.env.example</code> ke <code>configuration/.env</code> dan ganti kredensial database.</li>
                        <li>Aktifkan HTTPS dan Cloudflare/WAF di level infrastruktur untuk mitigasi DDoS layer 3/4.</li>
                        <li>Pastikan folder <code>tmp/security</code> tidak dapat diakses publik (sudah dilindungi .htaccess).</li>
                        <li>Audit berkala file PHP lama yang masih memakai query string concatenation.</li>
                    </ol>
                </div>
            </div>
        </section>
    </div>
</div>
<?php footer(); ?>
