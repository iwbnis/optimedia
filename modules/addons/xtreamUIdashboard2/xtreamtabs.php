<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

if (isset($_REQUEST["action"])) {
    if ($_REQUEST["action"] == "logs") {
        $tab3 = "active";
    } else {
        if ($_REQUEST["action"] == "manualaction") {
            $tab4 = "active";
        } else {
            $tab2 = "active";
        }
    }
} else {
    $tab2 = "active";
}
echo "  \n<div style=\"float: right;\" class=\"navbar-header\"> \n        <img style=\"margin-top: -35px;width: 300px;\" alt=\"Xtream Code\" src=\"https://www.whmcssmarters.com/clients/assets/img/logo.png\"> \n</div> \n<ul class=\"nav nav-tabs admin-tabs\" role=\"tablist\">  \n    <li class=\"";
if (isset($tab2)) {
    echo $tab2;
}
echo "\"><a style=\"font-size: 15px;\"class=\"tab-top\" href=\"";
echo $modulelink;
echo "\" >Customisations</a></li>\n    <li class=\"";
if (isset($tab3)) {
    echo $tab3;
}
echo "\"><a style=\" font-size: 14px; \"class=\"tab-top\" href=\"";
echo $modulelink;
echo "&action=logs\">Logs</a></li> \n    <!--li class=\"";
if (isset($tab4)) {
    echo $tab4;
}
echo "\"><a style=\" font-size: 14px; \"class=\"tab-top\" href=\"";
echo $modulelink;
echo "&action=manualaction\">Manual Action(if reCaptcha is enabled)</a></li--> \n</ul> \n\n";

?>