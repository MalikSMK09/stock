<?php
error_reporting(0);
session_start();
include "configuration/config_etc.php";
include "configuration/config_include.php";
include 'configuration/config_connect.php';
connect();
timing();

$queryback = "SELECT url FROM backset";
$resultback = mysqli_query($conn, $queryback);
$rowback = mysqli_fetch_assoc($resultback);
$url = $rowback['url'];

$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    SecurityBootstrap::requireCsrf();

    $username = SecurityBootstrap::sanitizeString($_POST['txtuser'] ?? '', 64);
    $password = $_POST['txtpass'] ?? '';
    $attemptFile = SecurityBootstrap::checkLoginAttempt($username);

    if ($username === '' || $password === '') {
        SecurityBootstrap::recordLoginFailure($attemptFile);
        header("Location: loginagain");
        exit;
    }

    $hashedPassword = SecurityBootstrap::hashPassword($password);

    $user = SecurityBootstrap::queryOne(
        $conn,
        "SELECT * FROM user WHERE userna_me = ? AND pa_ssword = ? LIMIT 1",
        'ss',
        [$username, $hashedPassword]
    );

    if ($user) {
        SecurityBootstrap::clearLoginAttempts($attemptFile);
        session_regenerate_id(true);

        $_SESSION['username'] = $user['userna_me'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['jabatan'] = $user['jabatan'];
        $_SESSION['avatar'] = $user['avatar'];
        $_SESSION['nouser'] = $user['no'];
        $_SESSION['baseurl'] = $baseurl;
        login_validate();

        if (($url == 'http://idwares.esy.es')) {
            header("Location: index?alert=1");
        } else {
            header("Location: index");
        }
        exit;
    }

    SecurityBootstrap::recordLoginFailure($attemptFile);
    SecurityBootstrap::logEvent('login_failed', ['username' => $username]);
    header("Location: loginagain");
    exit;
}
