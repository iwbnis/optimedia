<?php
ini_set('display_errors', 'On');
require __DIR__ . '/vendor/autoload.php'; 

// Your OAuth 2.0 credentials from the Xero Developer website
$clientID = 'AD4CA50DE4FC47AAB64B1DAECB395859';
$clientSecret = 'gttJ39rbXB4slhjXEeGjJQy74WQwPU3AkxfFEur0l-JLXHbz';
$redirectUri = 'https://localhost/xero-integration/callback.php';
$scope = 'openid profile email accounting.transactions offline_access';


// print_r('hello'); die();
// Step 1: Redirect the user to the Xero authorization URL
$authorizationUrl = 'https://login.xero.com/identity/connect/authorize' .
    '?response_type=code' .
    '&client_id=' . urlencode($clientID) .
    '&redirect_uri=' . urlencode($redirectUri) .
    '&scope=' . urlencode($scope);

// Redirect the user to the authorization URL.
header('Location: ' . $authorizationUrl);
exit;

