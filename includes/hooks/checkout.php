<?php
use WHMCS\View\Menu\Item as MenuItem;

add_hook('ClientAreaFooterOutput', 1, function($vars) {
    if ($_SERVER['PHP_SELF'] == '/cart.php' && isset($_REQUEST['a']) && $_REQUEST['a'] == 'checkout' && isset($_REQUEST['e']) && $_REQUEST['e'] == 'false') {
        $script = '<script>
                    $(document).ready(function() {
                        var ccInputContainer = $(".cc-input-container.w-hidden");
                        var message = "<div class=\'center-message\'>VISA &amp; MASTERCARD ONLY</div>";

                        if (ccInputContainer.length && ccInputContainer.is(":visible") && ccInputContainer.css("display") === "block") {
                            ccInputContainer.append(message);
                        } else {
                            $(".center-message").remove();
                        }
                    });
                  </script>';

        $css = '<style>
                    .center-message {
                        text-align: center;
                        font-weight: bold;
                        font-size: 20px;
                        margin-top: 10px;
                    }
                </style>';

        return $script . $css;
    }
});
