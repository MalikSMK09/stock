<?php
include "configuration/config_connect.php";
require_once "libs/SecurityBootstrap.php";

SecurityBootstrap::requireAuth();

$q = SecurityBootstrap::paramStr($_GET['q'] ?? '', 64);
$rows = SecurityBootstrap::queryAll($conn, "SELECT nota FROM quotation_list WHERE conv = '1' LIMIT 1");

if (count($rows) < 1) {
    echo "<script type='text/javascript'>window.location = 'quotation_conv?q=" . htmlspecialchars(urlencode($q), ENT_QUOTES, 'UTF-8') . "';</script>";
} else {
    $nota = $rows[0]['nota'];
    if ($nota == $q) {
        echo "<script type='text/javascript'>window.location = 'quotation_conv?q=" . htmlspecialchars(urlencode($q), ENT_QUOTES, 'UTF-8') . "';</script>";
    } else {
        echo "<script type='text/javascript'>window.location = 'quotation_confirm?q=" . htmlspecialchars(urlencode($nota), ENT_QUOTES, 'UTF-8') . "';</script>";
    }
}
