<?php
require_once __DIR__ . '/_init.php';

if (SecurityBootstrap::hasDeletePermission($chmod)) {
    $deleted = SecurityBootstrap::deleteWhere($conn, $forward, 'nota', $nota, 's');
    if ($deleted !== false) {
        SecurityBootstrap::deleteWhere($conn, $tabel, 'nota', $nota, 's');

        if ($tipe == '1') {
            SecurityBootstrap::execute($conn, 'DELETE FROM hutang WHERE nota = ?', 's', [$nota]);
            SecurityBootstrap::execute($conn, "DELETE FROM payment WHERE tipe = '1' AND nota = ?", 's', [$nota]);
        } else {
            SecurityBootstrap::execute($conn, "DELETE FROM payment WHERE tipe = '2' AND nota = ?", 's', [$nota]);
        }

        secureDeleteSuccessForm($forwardpage);
    } else {
        secureDeleteDeniedForm($forwardpage);
    }
} else {
    secureDeleteDeniedForm($forwardpage);
}
secureDeleteSpinner();
?>
<meta http-equiv="refresh" content="10;url=<?php echo htmlspecialchars(secureDeleteJumpUrl(['forward' => $forward, 'forwardpage' => $forwardpage, 'chmod' => $chmod]), ENT_QUOTES, 'UTF-8'); ?>">
