<?php
require_once __DIR__ . '/_init.php';

if (SecurityBootstrap::hasDeletePermission($chmod)) {
    $deleted = SecurityBootstrap::deleteWhere($conn, $forward, 'no', $no, 'i');
    if ($deleted !== false) {
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
