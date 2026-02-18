<?php

use WHMCS\Database\Capsule;

include_once 'function.php';
add_hook('AdminAreaFooterOutput', 1, function($vars) {
    if ($vars['filename'] == 'configproducts') {
        return moduleconfiguration();
    }
});
?> 
