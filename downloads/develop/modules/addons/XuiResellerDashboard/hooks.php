<?php

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

use WHMCS\Database\Capsule;

add_hook('EmailPreSend', 1, function($vars) {
    $merge_fields = [];
    $GettingPortalLInkDatra = Capsule::table('tblhosting')
            ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
            ->where('tblhosting.id', '=', $vars['relid'])
            ->select('tblproducts.*'
                    , 'tblhosting.id as serviceid'
            )
            ->get();
    if (!empty($GettingPortalLInkDatra)) {
        $server = Capsule::table('xtreamui_servers')->where('id', $GettingPortalLInkDatra[0]->configoption1)->get();
        if (isset($server[0]->magportalurl) && !empty($server[0]->magportalurl)) {
            $merge_fields['portal_url'] = $server[0]->magportalurl;
            $merge_fields['service_server_hostname'] = $server[0]->magportalurl;
            return $merge_fields;
        }
    }
});
