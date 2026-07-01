<!DOCTYPE html>
<html>
<?php
session_start();
include "configuration/config_include.php";
connect();

$queryback = "SELECT * FROM data";
$resultback = mysqli_query($conn, $queryback);
$rowback = mysqli_fetch_assoc($resultback);
$footer = $rowback['nama'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$pinVerified = !empty($_SESSION['pin_reset_verified']) && $_SESSION['pin_reset_verified'] > time();
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Indotory Pro Plus | Reset Login</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
</head>
<body class="hold-transition lockscreen">
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href=""><b><?php echo htmlspecialchars($footer, ENT_QUOTES, 'UTF-8'); ?></b>POS</a>
  </div>

<?php if ($pinVerified) { ?>

<form method="post" action="">
<?php echo SecurityBootstrap::csrfField(); ?>
<div>
<button type="submit" name="reset" class="btn btn-danger btn-block">RESET</button>
</div>
</form>
<p>Klik RESET lalu Login dengan username: admin &amp; password: admin</p>

<?php } else { ?>

  <div class="lockscreen-name">Admin</div>
  <div class="lockscreen-item">
    <div class="lockscreen-image">
      <img src="dist/img/avatar.png" alt="User Image">
    </div>
    <form class="lockscreen-credentials" action="" method="post">
      <?php echo SecurityBootstrap::csrfField(); ?>
      <div class="input-group">
        <input type="password" class="form-control" name="pin" placeholder="Masukan PIN" maxlength="32" required>
        <div class="input-group-btn">
          <button type="submit" class="btn" name="cek"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
  </div>
  <div class="help-block text-center">
    Masukan PIN Anda Untuk mereset password Admin
  </div>

<?php } ?>

  <div class="text-center"></div>
</div>

<?php
if (isset($_POST['reset']) && $pinVerified) {
    SecurityBootstrap::requireCsrf();
    SecurityBootstrap::enforceRateLimit('reset_user', 3, 3600);

    $password = "90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad";
    $user = "admin";

    $existing = SecurityBootstrap::queryOne(
        $conn,
        'SELECT userna_me FROM user WHERE userna_me = ? LIMIT 1',
        's',
        [$user]
    );

    if ($existing) {
        SecurityBootstrap::execute(
            $conn,
            "UPDATE user SET pa_ssword = ?, jabatan = ? WHERE userna_me = ?",
            'sss',
            [$password, $user, $user]
        );
    } else {
        SecurityBootstrap::execute(
            $conn,
            "INSERT INTO user (userna_me, pa_ssword, nama, alamat, nohp, tgllahir, tglaktif, jabatan, avatar, no) VALUES (?, ?, 'admin', 'alamat', '111', '2020-02-02', '2020-02-02', 'admin', 'dist/upload/index.jpg', '')",
            'ss',
            [$user, $password]
        );
    }

    unset($_SESSION['pin_reset_verified']);
    SecurityBootstrap::logEvent('admin_password_reset', []);
    echo "<script type='text/javascript'>window.location = 'login';</script>";
}

if (isset($_POST['cek'])) {
    SecurityBootstrap::requireCsrf();
    SecurityBootstrap::enforceRateLimit('reset_pin_check', 5, 900);

    $pin = SecurityBootstrap::paramStr($_POST['pin'] ?? '', 32);
    $pina = sha1(md5($pin));

    $result = SecurityBootstrap::queryOne($conn, 'SELECT pin FROM pin WHERE pin = ? LIMIT 1', 's', [$pina]);
    if ($result) {
        $_SESSION['pin_reset_verified'] = time() + 300;
        echo "<script type='text/javascript'>window.location = 'reset_user';</script>";
    } else {
        SecurityBootstrap::logEvent('reset_pin_failed', []);
        echo "<script type='text/javascript'>alert('PIN salah!');</script>";
    }
}
?>

<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
