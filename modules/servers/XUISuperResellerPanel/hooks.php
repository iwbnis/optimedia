<?php

use WHMCS\Database\Capsule;

include_once 'functions.php';
add_hook('AdminAreaFooterOutput', 1, function ($vars) {
    if ($vars['filename'] == 'configproducts') {
        return super_moduleconfiguration();
    }
});
add_hook('ShoppingCartValidateProductUpdate', 1, function ($vars) {
    $existingReseller = "";
    foreach ($vars['customfield'] as $customfieldId => $value) {
        $tblcustomfields = Capsule::table('tblcustomfields')->where("id", $customfieldId)->get();
        $tblproducts = Capsule::table('tblproducts')->where("id", $tblcustomfields[0]->relid)->first();
        $fieldname = $tblcustomfields[0]->fieldname; //fieldname
        $servertype = $tblproducts->servertype;
        if (trim($servertype) == "XUISuperResellerPanel") {
            if (trim($fieldname) == "Already Have Reseller Account") {
                $existingReseller = 'true';
            }
            $customField = Capsule::table('tblcustomfields')->where("relid", $tblcustomfields[0]->relid)->whereIn("fieldname", ["Existing Reseller", "New Reseller"])->where("type", "product")->get();
            $new_reseller = $customField[0]->id;
            $existing_reseller = $customField[1]->id;
            if (!isset($vars['customfield'][$new_reseller]) && !isset($vars['customfield'][$existing_reseller])) {
                return 'You must select one option to continue';
            }
        }
    }
    if (trim($servertype) == "XUISuperResellerPanel") {
        $config = Capsule::table('xui_settings')->get();
        foreach ($config as $value) {
            $row[$value->setting] = $value->value;
        }
        if ($existingReseller == "true") {
            $tblcustomfield = Capsule::table('tblcustomfields')->where("relid", $tblcustomfields[0]->relid)->where("fieldname", "Enter Existing Reseller Username")->where("type", "product")->first();
            $reseller_username = $vars['customfield'][$tblcustomfield->id];
            if (empty(trim($reseller_username))) {
                return [
                    'Reseller Username is required.',
                ];
            } else {
                $usernameToSearch = trim($reseller_username);
                $tblproducts = Capsule::table('tblproducts')->where('id', $tblcustomfields[0]->relid)->first();
                $panel_id = $tblproducts->configoption1;
                $panel_details = Capsule::table('xui_paneldetails')->where('id', $panel_id)->get();
                $panel_url = $panel_details[0]->panel_link;
                $bar = "/";
                if (substr($panel_url, -1) == "/") {
                    $bar = "";
                }
                $panel_url = $panel_url . $bar;
                $username = $panel_details[0]->username;
                $password = $panel_details[0]->password;
                //curl to check credentials 
                $cookie_path = dirname(__FILE__) . '/Cookie.txt';
                $GetFileContent = file_get_contents($cookie_path);
                $Exploded = explode("PHPSESSID", $GetFileContent);
                $XSRF = "";
                if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
                    $againEXlpode = explode("\n", $Exploded['1']);
                    $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
                }
                if (empty($XSRF)) {
                    $ch = curl_init($panel_url . '/login');
                    curl_setopt($ch, CURLOPT_URL, $panel_url . "/login");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 0);
                    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                    $ret1 = curl_exec($ch);
                    $GetFileContent = file_get_contents($cookie_path);
                    $Exploded = explode("PHPSESSID", $GetFileContent);
                    $XSRF = "";
                    if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
                        $againEXlpode = explode("\n", $Exploded['1']);
                        $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
                    }
                }
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $panel_url . '/login');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "referrer=&username=$username&password=$password&login=");
                curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
                $headers = array();
                $headers[] = 'Connection: keep-alive';
                $headers[] = 'Cache-Control: max-age=0';
                $headers[] = 'Upgrade-Insecure-Requests: 1';
                $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36';
                $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
                $headers[] = 'Referer: ' . $panel_url . '/login';
                $headers[] = 'Accept-Language: en-US,en;q=0.9';
                $headers[] = 'Cookie: ' . $XSRF;
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_setopt($ch, CURLOPT_URL,  $panel_url . '/dashboard');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
                $result = curl_exec($ch);
                $login = "";
                $dom = new DOMDocument();
                @$dom->loadHTML($result);
                $tags = $dom->getElementsByTagName('span');
                for ($i = 0; $i < $tags->length; $i++) {
                    $grab = $tags->item($i);
                    if ($grab->nodeValue == "Logout") {
                        $login = "yes";
                    }
                }
                if ($login == "yes") {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $panel_url . 'table?draw=1&id=reg_users');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
                    $headers = array();
                    $headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
                    $headers[] = 'Accept-Language: en-US,en;q=0.9';
                    $headers[] = 'Connection: keep-alive';
                    $headers[] = 'Cookie: ' . $XSRF;
                    $headers[] = 'Cache-Control: max-age=0';
                    $headers[] = 'Referer: ' . $panel_url . 'users?order=0&dir=desc';
                    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36';
                    $headers[] = 'X-Requested-With: XMLHttpRequest';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result = curl_exec($ch);
                    $results = json_decode($result);
                    if ($results->recordsTotal > 0) {
                        $arry = array();
                        foreach ($results->data as $values) {
                            $Exploded =  explode('>', $values[1]);
                            $Exploded =  explode('<', $Exploded[1]);
                            $arry[] = trim($Exploded[0]);
                        }
                        if (!in_array($usernameToSearch, $arry)) {
                            return "Unable to find Reseller with this username";
                        }
                    }
                } else {
                    return "Unable to find Reseller with this username";
                }
            }
        } else {
            $tblcustomfield = Capsule::table('tblcustomfields')->where("relid", $tblcustomfields[0]->relid)->where("fieldname", "Enter New Reseller Username")->where("type", "product")->first();
            $reseller_username = $vars['customfield'][$tblcustomfield->id];
            if (empty(trim($reseller_username))) {
                return [
                    'Reseller Username is required.',
                ];
            } else {
                $usernameToSearch = trim($reseller_username);
                $tblproducts = Capsule::table('tblproducts')->where('id', $tblcustomfields[0]->relid)->first();
                $panel_id = $tblproducts->configoption1;
                $panel_details = Capsule::table('xui_paneldetails')->where('id', $panel_id)->get();
                $panel_url = $panel_details[0]->panel_link;
                $bar = "/";
                if (substr($panel_url, -1) == "/") {
                    $bar = "";
                }
                $panel_url = $panel_url . $bar;
                $username = $panel_details[0]->username;
                $password = $panel_details[0]->password;
                //curl to check credentials 
                $cookie_path = dirname(__FILE__) . '/Cookie.txt';
                $GetFileContent = file_get_contents($cookie_path);
                $Exploded = explode("PHPSESSID", $GetFileContent);
                $XSRF = "";
                if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
                    $againEXlpode = explode("\n", $Exploded['1']);
                    $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
                }
                if (empty($XSRF)) {
                    $ch = curl_init($panel_url . '/login');
                    curl_setopt($ch, CURLOPT_URL, $panel_url . "/login");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 0);
                    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                    $ret1 = curl_exec($ch);
                    $GetFileContent = file_get_contents($cookie_path);
                    $Exploded = explode("PHPSESSID", $GetFileContent);
                    $XSRF = "";
                    if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
                        $againEXlpode = explode("\n", $Exploded['1']);
                        $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
                    }
                }
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $panel_url . '/login');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "referrer=&username=$username&password=$password&login=");
                curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
                $headers = array();
                $headers[] = 'Connection: keep-alive';
                $headers[] = 'Cache-Control: max-age=0';
                $headers[] = 'Upgrade-Insecure-Requests: 1';
                $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36';
                $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
                $headers[] = 'Referer: ' . $panel_url . '/login';
                $headers[] = 'Accept-Language: en-US,en;q=0.9';
                $headers[] = 'Cookie: ' . $XSRF;
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_setopt($ch, CURLOPT_URL,  $panel_url . '/dashboard');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
                $result = curl_exec($ch);
                $login = "";
                $dom = new DOMDocument();
                @$dom->loadHTML($result);
                $tags = $dom->getElementsByTagName('span');
                for ($i = 0; $i < $tags->length; $i++) {
                    $grab = $tags->item($i);
                    if ($grab->nodeValue == "Logout") {
                        $login = "yes";
                    }
                }
                if ($login == "yes") {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $panel_url . 'table?draw=1&id=reg_users');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
                    $headers = array();
                    $headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
                    $headers[] = 'Accept-Language: en-US,en;q=0.9';
                    $headers[] = 'Connection: keep-alive';
                    $headers[] = 'Cookie: ' . $XSRF;
                    $headers[] = 'Cache-Control: max-age=0';
                    $headers[] = 'Referer: ' . $panel_url . 'users?order=0&dir=desc';
                    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36';
                    $headers[] = 'X-Requested-With: XMLHttpRequest';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result = curl_exec($ch);
                    $results = json_decode($result);
                    if ($results->recordsTotal > 0) {
                        $arry = array();
                        foreach ($results->data as $values) {
                            $Exploded =  explode('>', $values[1]);
                            $Exploded =  explode('<', $Exploded[1]);
                            $arry[] = trim($Exploded[0]);
                        }
                        if (in_array($usernameToSearch, $arry)) {
                            return "This Reseller Username is already in use";
                        }
                    }
                } else {
                    return "This Reseller Username is already in use";
                }
            }
        }
    }
});
add_hook('EmailPreSend', 1, function ($vars) {
    $merge_fields = [];
    $service_id = $vars["mergefields"]["service_id"];
    if ($vars["messagename"] == "IPTV Reseller Credits Email") {
        $tblhostingData = Capsule::table('tblhosting')
            ->where('id', "$service_id")
            ->get();

        $results = localAPI($command, $postData);
        if ($results['result'] == "success") {
            $decryptedPass = $results['password'];
        }
        $packageid = $tblhostingData[0]->packageid;
        $username = $tblhostingData[0]->username;
        $tblproductsData = Capsule::table('tblproducts')
            ->where('id', "$packageid")
            ->get();
        $XUISuperResellerPanel = $tblproductsData[0]->servertype;
        $credits = $tblproductsData[0]->configoption3;
        if ($XUISuperResellerPanel == "XUISuperResellerPanel") {
            $merge_fields['reseller_username'] = $username;
            $merge_fields['reseller_credits'] = $credits;
        }
    }
    if ($vars["messagename"] == "IPTV Reseller Email") {
        $clientemail = $vars["mergefields"]["client_email"];
        foreach ($vars["mergefields"]["service_custom_fields_by_name"] as $val) {
            if ($val['name'] == "Already Have Reseller Account") {
                if ($val['value'] == "on") {
                    // abort and send credits email  
                    $merge_fields['abortsend'] = true;

                    $command = 'SendEmail';
                    $postData = array(
                        'messagename' => 'IPTV Reseller Credits Email',
                        'id' => $service_id,
                    );
                    localAPI($command, $postData);
                } else {
                    $tblhostingData = Capsule::table('tblhosting')
                        ->where('id', "$service_id")
                        ->get();
                    $hostingEncryptedPass = $tblhostingData[0]->password;
                    $command = 'DecryptPassword';
                    $postData = array(
                        'password2' => $hostingEncryptedPass,
                    );

                    $results = localAPI($command, $postData);
                    if ($results['result'] == "success") {
                        $decryptedPass = $results['password'];
                    }
                    $packageid = $tblhostingData[0]->packageid;
                    $username = $tblhostingData[0]->username;
                    $tblproductsData = Capsule::table('tblproducts')
                        ->where('id', "$packageid")
                        ->get();
                    $XUISuperResellerPanel = $tblproductsData[0]->servertype;
                    $credits = $tblproductsData[0]->configoption3;
                    if ($XUISuperResellerPanel == "XUISuperResellerPanel") {
                        $panelid = $tblproductsData[0]->configoption1;
                        $panel_details = Capsule::table('xui_paneldetails')->where('id', $panelid)->get();
                        $panel_url = $panel_details[0]->panel_link;
                        $bar = "/";
                        if (substr($panel_url, -1) == "/") {
                            $bar = "";
                        }
                        $panel_url = $panel_url . $bar;
                        $merge_fields['panel_url'] = $panel_url;
                        $merge_fields['reseller_username'] = $username;
                        $merge_fields['reseller_credits'] = $credits;
                        $merge_fields['reseller_password'] = $decryptedPass;
                    }
                }
            }
        }
    }

    return $merge_fields;
});

add_hook('ClientAreaPage', 1, function ($vars) {
    $pid = isset($vars['productinfo']['pid']) ? $vars['productinfo']['pid'] : $vars['pid'];
    $tblproducts = Capsule::table('tblproducts')->where("id", $pid)->get();
    if (($vars['pagetitle'] == "Shopping Cart" && $vars['displayTitle'] == "Shopping Cart" && $vars['action'] == "confproduct") || ($vars['pagetitle'] == "Client Area" && $vars['displayTitle'] == "Manage Product" && $vars['action'] == "productdetails")) {
        $config = Capsule::table('xui_settings')->get();
        foreach ($config as $value) {
            $row[$value->setting] = $value->value;
        }
        $tblcustomfields = Capsule::table('tblcustomfields')->whereIn("fieldname", ['Enter Existing Reseller Username', 'Enter New Reseller Username', 'Already Have Reseller Account', $row['custom_field_username'], 'Enter New Reseller Password', 'Existing Reseller', 'New Reseller'])->where("relid", $pid)->get();

        foreach ($tblcustomfields as $values) {
            if ($values->fieldname == "Already Have Reseller Account") {
                $resellerProductType = $values->id;
            }
            if ($values->fieldname == "Enter Existing Reseller Username") {
                $existing_reseller = $values->id;
            }
            if ($values->fieldname == "Existing Reseller") {
                $existing_reseller_checkbox = $values->id;
            }
            if ($values->fieldname == "Enter New Reseller Username") {
                $new_reseller_text_field = $values->id;
            }
            if ($values->fieldname == "New Reseller") {
                $new_reseller = $values->id;
            }
            if ($values->fieldname == 'Enter New Reseller Password') {
                $custom_field_password = $values->id;
            }
        }
?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                var enterexistingid = "#customfield<?php echo $existing_reseller; ?>";
                var newResellerId = "#customfield<?php echo $new_reseller_text_field; ?>";
                var custom_field_password_hide = "#customfield<?php echo $custom_field_password; ?>";
                $(enterexistingid).parent().hide();
                $(newResellerId).parent().hide();
                $(custom_field_password_hide).parent().hide();
                $("#customfield<?php echo $resellerProductType; ?>").closest(".form-group").hide();
                $('input').on('ifChecked', function(event) {
                    if ($(this).attr("id") == '<?php echo "customfield" . $existing_reseller_checkbox ?>') {
                        $(enterexistingid).parent().show();
                        $(newResellerId).parent().hide();
                        $(custom_field_password_hide).parent().hide();
                        $("#customfield<?php echo $new_reseller; ?>").prop('checked', false);
                        $("#iCheck-customfield<?php echo $new_reseller; ?>").removeClass('checked');
                        $("#customfield<?php echo $resellerProductType; ?>").prop('checked', true);
                        $("#iCheck-customfield<?php echo $resellerProductType; ?>").addClass('checked');
                    }
                    if ($(this).attr("id") == '<?php echo "customfield" . $new_reseller ?>') {
                        $(enterexistingid).parent().hide();
                        $(enterexistingid).val('');
                        $(newResellerId).parent().show();
                        $(custom_field_password_hide).parent().show();
                        $(newResellerId).val('');
                        $("#customfield<?php echo $existing_reseller_checkbox; ?>").prop('checked', false);
                        $("#iCheck-customfield<?php echo $existing_reseller_checkbox; ?>").removeClass('checked');
                        $("#customfield<?php echo $resellerProductType; ?>").prop('checked', false);
                        $("#iCheck-customfield<?php echo $resellerProductType; ?>").removeClass('checked');
                    }
                });
                $('input').on('ifUnchecked', function(event) {
                    if ($(this).attr("id") == '<?php echo "customfield" . $existing_reseller_checkbox ?>') {
                        $(enterexistingid).parent().hide();
                        $(newResellerId).parent().hide();
                        $(custom_field_password_hide).parent().hide();
                        $("#customfield<?php echo $resellerProductType; ?>").prop('checked', false);
                        $("#iCheck-customfield<?php echo $resellerProductType; ?>").removeClass('checked');
                    }
                    if ($(this).attr("id") == '<?php echo "customfield" . $new_reseller ?>') {
                        $(enterexistingid).parent().hide();
                        $(newResellerId).parent().hide();
                        $(custom_field_password_hide).parent().hide();
                        $("#customfield<?php echo $resellerProductType; ?>").prop('checked', false);
                        $("#iCheck-customfield<?php echo $resellerProductType; ?>").removeClass('checked');
                    }
                });
            });
        </script>
<?php
    }
});
?>