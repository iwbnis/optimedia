<?php
/**
 * Unified Order Entry Point
 * Redirects to cart with a default product added via WHMCS's native cart flow.
 * If cart already has items, goes straight to configure.
 */

session_start();

// If cart already has products, go straight to configure
if (!empty($_SESSION['cart']['products'])) {
    header("Location: cart.php?a=confproduct&i=0");
    exit;
}

// Otherwise, add default product (id=38) via WHMCS native cart URL
// cart.php?a=add&pid=38 adds the product and shows confproduct
header("Location: cart.php?a=add&pid=38");
exit;
