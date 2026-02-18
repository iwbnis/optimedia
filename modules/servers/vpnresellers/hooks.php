<?php

if (function_exists('add_hook')) {
    add_hook('ShoppingCartValidateProductUpdate', 1, 'vpnresellers_checkUsername');
}

use Illuminate\Database\Capsule\Manager as Capsule;

function vpnresellers_CheckUsername($vars)
{
    $customfieldId = "";
    $username = "";
    foreach ($vars['customfield'] as $key => $value) {
        $customfieldId = $key;
        $username = $value;
        break;
    }
    $tblcustomfields = Capsule::table('tblcustomfields')->where("id", $customfieldId)->get();
    $product_id = $tblcustomfields[0]->relid;
    $tblproducts = Capsule::table('tblproducts')->where("id", $product_id)->first();
    if ($tblproducts->servertype == "vpnresellers") {
        $baseUrl = "https://api.vpnresellers.com/v4/accounts/check_username?username=" . $username;
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_URL, $baseUrl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $result = curl_exec($curl);

        if (!$result) {
            return 'Connection error.';
        }
        $info = curl_getinfo($curl);
        $statusCode = $info['http_code'];
        curl_close($curl);
        $result = json_decode($result);

        if ($statusCode === 422) {
            if (isset($result->errors)) {
                foreach ($result->errors as $error) {
                    if (isset($error[0])) {
                        return $error[0];
                    }
                }
            }
            return 'Validation error';
        }
    }
}
