<?php
/**
 * Shared secure bootstrap for component/delete handlers.
 */
require_once dirname(__DIR__, 2) . '/configuration/config_connect.php';
require_once dirname(__DIR__, 2) . '/configuration/config_session.php';
require_once dirname(__DIR__, 2) . '/configuration/config_chmod.php';
require_once dirname(__DIR__, 2) . '/configuration/config_etc.php';

SecurityBootstrap::enforceRateLimit('delete_handler', 30, 60);

$forward = SecurityBootstrap::whitelistTable($_GET['forward'] ?? '');
$forwardpage = SecurityBootstrap::whitelistPage($_GET['forwardpage'] ?? '');
$chmod = SecurityBootstrap::paramInt($_GET['chmod'] ?? 0);
$no = SecurityBootstrap::paramInt($_GET['no'] ?? 0);
$nota = SecurityBootstrap::paramStr($_GET['nota'] ?? '', 64);
$kode = SecurityBootstrap::paramStr($_GET['kode'] ?? '', 64);
$jumlah = SecurityBootstrap::paramInt($_GET['jumlah'] ?? 0);
$jml = $jumlah;
$barang = SecurityBootstrap::paramStr($_GET['barang'] ?? '', 64);
$get = SecurityBootstrap::paramStr($_GET['get'] ?? '', 16);
$jenis = SecurityBootstrap::paramStr($_GET['jenis'] ?? '', 8);
$harga = SecurityBootstrap::paramFloat($_GET['harga'] ?? 0);
$tabel = SecurityBootstrap::whitelistTable($_GET['tabel'] ?? $forward);
$tipe = SecurityBootstrap::paramStr($_GET['tipe'] ?? '', 8);
$awal = SecurityBootstrap::paramInt($_GET['sebelum'] ?? 0);
$detail = SecurityBootstrap::paramStr($_GET['detail'] ?? '', 64);
$sub = $jumlah * $harga;
$cek = 0;

function secureDeleteJumpUrl($params = [])
{
    $parts = [];
    foreach ($params as $key => $value) {
        if ($value !== '' && $value !== null) {
            $parts[] = urlencode($key) . '=' . urlencode((string) $value);
        }
    }
    return 'jump?' . implode('&', $parts);
}

function secureDeleteDeniedForm($forwardpage, $extra = [])
{
    ?>
    <body onload="setTimeout(function() { document.frm1.submit() }, 10)">
    <form action="<?php echo htmlspecialchars($GLOBALS['baseurl'] . '/' . $forwardpage, ENT_QUOTES, 'UTF-8'); ?>" name="frm1" method="post">
    <?php foreach ($extra as $k => $v) { ?>
        <input type="hidden" name="<?php echo htmlspecialchars($k, ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); ?>">
    <?php } ?>
    <input type="hidden" name="hapusberhasil" value="2" />
    <?php
}

function secureDeleteSuccessForm($forwardpage, $extra = [])
{
    ?>
    <body onload="setTimeout(function() { document.frm1.submit() }, 10)">
    <form action="<?php echo htmlspecialchars($GLOBALS['baseurl'] . '/' . $forwardpage, ENT_QUOTES, 'UTF-8'); ?>" name="frm1" method="post">
    <?php foreach ($extra as $k => $v) { ?>
        <input type="hidden" name="<?php echo htmlspecialchars($k, ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); ?>">
    <?php } ?>
    <input type="hidden" name="hapusberhasil" value="1" />
    <?php
}

function secureDeleteSpinner()
{
    ?>
    <table width="100%" align="center" cellspacing="0">
        <tr>
            <td height="500px" align="center" valign="middle"><img src="../../dist/img/load.gif"></td>
        </tr>
    </table>
    </form>
    <?php
}
