<?php

use WHMCS\Database\Capsule;

$modulelink = "addonmodules.php?module=XUIPanelCustom";
if (isset($_REQUEST["action"])) {
    if ($_REQUEST["action"] == "addpanels") {
        $tab2 = "active";
    } elseif ($_REQUEST["action"] == "addserver") {
        $tab2 = "active";
    } elseif ($_REQUEST["action"] == "logs") {
        $tab3 = "active";
    } elseif ($_REQUEST["action"] == "categories") {
        $tab4 = "active";
    } elseif ($_REQUEST["action"] == "edit") {
        $tab2 = "active";
    } elseif ($_REQUEST["action"] == "applinks") {
        $tab5 = "active";
    } else {
        $tab1 = "active";
    }
} else {
    $tab1 = "active";
}
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="https://www.whmcssmarters.com/" style="display: inline-flex;padding:0px;" class="navbar-brand"><img style="width: 100%;height: 50px;" src="../modules/addons/XUIPanelCustom/logo.png"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="<?php if (isset($tab1)) echo $tab1; ?>"><a style="font-weight: 900;" href="<?php echo $modulelink; ?>"><i class="fa fa-server fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;General Settings</a></li>
                <li class="<?php if (isset($tab2)) echo $tab2; ?>"><a style="font-weight: 900;" href="<?php echo $modulelink; ?>&action=addpanels"><i class="fas fa-list fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Add Panels Details</a></li>
                <li class="<?php if (isset($tab5)) echo $tab5; ?>"><a style="font-weight: 900;" href="<?php echo $modulelink; ?>&action=applinks"><i class="fas fa-list fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Application Links</a></li>
                <li class="<?php if (isset($tab4)) echo $tab4; ?>"><a style="font-weight: 900;" href="<?php echo $modulelink; ?>&action=categories"><svg style="width: 16px;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="grid-2" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-grid-2 fa-lg">
                            <path fill="currentColor" d="M192 176C192 202.5 170.5 224 144 224H48C21.49 224 0 202.5 0 176V80C0 53.49 21.49 32 48 32H144C170.5 32 192 53.49 192 80V176zM192 432C192 458.5 170.5 480 144 480H48C21.49 480 0 458.5 0 432V336C0 309.5 21.49 288 48 288H144C170.5 288 192 309.5 192 336V432zM256 80C256 53.49 277.5 32 304 32H400C426.5 32 448 53.49 448 80V176C448 202.5 426.5 224 400 224H304C277.5 224 256 202.5 256 176V80zM448 432C448 458.5 426.5 480 400 480H304C277.5 480 256 458.5 256 432V336C256 309.5 277.5 288 304 288H400C426.5 288 448 309.5 448 336V432z" class=""></path>
                        </svg>&nbsp;&nbsp;Add Bouquet Categories</a></li>
                <li class="<?php if (isset($tab3)) echo $tab3; ?>"><a style="font-weight: 900;" href="<?php echo $modulelink; ?>&action=logs"><i class="fas fa-info-circle fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Logs</a></li>
            </ul>
        </div>
    </div>
</nav>