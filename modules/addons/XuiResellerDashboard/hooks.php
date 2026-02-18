<?php

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

use WHMCS\Database\Capsule;

add_hook('EmailPreSend', 1, function ($vars) {
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
        $portalurl = unserialize($server[0]->magportalurl);
        if (isset($portalurl[0]) && !empty($portalurl[0])) {
            $merge_fields['portal_url'] = $portalurl[0];
            $merge_fields['service_server_hostname'] = $portalurl[0];
        }
        return $merge_fields;
    }
});
