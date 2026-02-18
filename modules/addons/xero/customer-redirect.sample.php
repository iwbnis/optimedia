<?php

namespace EdgeHosting;

// Change this to your WHMCS admin path
$adminpath = '/whmcs/admin';
if (isset($_GET['userid'])) {
    // strip the default prefix of WHMCS from the given ID
    $userid = \substr($_GET['userid'], 5);
    \header("Location: https://{$_SERVER['HTTP_HOST']}{$adminpath}/clientssummary.php?userid={$userid}");
}
exit;
