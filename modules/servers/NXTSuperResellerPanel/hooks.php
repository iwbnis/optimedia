<?php

use WHMCS\Database\Capsule;

add_hook('ClientAreaPageCart', 1, function ($vars) {
    if ($vars['action'] == "confproduct") {
        $tblproducts = Capsule::table('tblproducts')->where("id", $vars['productinfo']['pid'])->first();
        if ($tblproducts->servertype == "NXTSuperResellerPanel") {
            $config = Capsule::table('xui_settings')->get();
            foreach ($config as $value) {
                $row[$value->setting] = $value->value;
            }
            $tblcustomfields = Capsule::table('tblcustomfields')->whereIn("fieldname", ['Select Product Type', 'Enter Existing Reseller Username', $row['custom_field_username'], $row['custom_field_password'], $row['custom_field_mag']])->where("relid", $vars['productinfo']['pid'])->get();
            foreach ($tblcustomfields as $values) {
                if ($values->fieldname == "Select Product Type") {
                    $product_type = $values->id;
                }
                if ($values->fieldname == "Enter Existing Reseller Username") {
                    $reseller_username = $values->id;
                }
                if ($values->fieldname == $row['custom_field_username']) {
                    $username = $values->id;
                }
                if ($values->fieldname == $row['custom_field_password']) {
                    $password = $values->id;
                }
            }
?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#customfield<?php echo $username ?>").parent("div").hide();
                    $("#customfield<?php echo $password ?>").parent("div").hide();
                    $("#customfield<?php echo $reseller_username ?>").parent("div").hide();

                    onloadproducttype = $("#customfield<?php echo $product_type ?>").val();
                    if (onloadproducttype == "Become resller") {
                        $("#customfield<?php echo $username ?>").parent("div").show();
                        $("#customfield<?php echo $password ?>").parent("div").show();
                        $("#customfield<?php echo $reseller_username ?>").parent("div").hide();
                    }
                    if (onloadproducttype == "Buy Credits") {
                        $("#customfield<?php echo $username ?>").parent("div").hide();
                        $("#customfield<?php echo $password ?>").parent("div").hide();
                        $("#customfield<?php echo $reseller_username ?>").parent("div").show();
                    }

                    $("#customfield<?php echo $product_type ?>").change(function() {
                        if ($(this).val() == "Become resller") {
                            $("#customfield<?php echo $username ?>").parent("div").show();
                            $("#customfield<?php echo $password ?>").parent("div").show();
                            $("#customfield<?php echo $reseller_username ?>").parent("div").hide();
                        }
                        if ($(this).val() == "Buy Credits") {
                            $("#customfield<?php echo $username ?>").parent("div").hide();
                            $("#customfield<?php echo $password ?>").parent("div").hide();
                            $("#customfield<?php echo $reseller_username ?>").parent("div").show();
                        }
                    });
                });
            </script>
<?php
        }
    }
});

add_hook('ShoppingCartValidateProductUpdate', 1, function ($vars) {
    foreach ($vars['customfield'] as $customfieldId => $reseller_name) {
        $tblcustomfields = Capsule::table('tblcustomfields')->where("id", $customfieldId)->get();
        $product_id = $tblcustomfields[0]->relid;
        $tblproducts = Capsule::table('tblproducts')->where("id", $product_id)->first();
        $configoption1 = $tblproducts->configoption1;
        $servertype = $tblproducts->servertype;
        if ($servertype == "NXTSuperResellerPanel") {
            $fieldname = $tblcustomfields[0]->fieldname;
            if ($fieldname == "Select Product Type") {
                if ($vars['customfield'][$customfieldId] == "Buy Credits") {
                    $validate = "true";
                }
            }
        }
    }
    if ($validate == "true") {
        foreach ($vars['customfield'] as $customfieldId => $reseller_name) {
            $tblcustomfields = Capsule::table('tblcustomfields')->where("id", $customfieldId)->get();
            $product_id = $tblcustomfields[0]->relid;
            $tblproducts = Capsule::table('tblproducts')->where("id", $product_id)->first();
            $configoption1 = $tblproducts->configoption1;
            $servertype = $tblproducts->servertype;
            if ($servertype == "NXTSuperResellerPanel") {
                $fieldname = $tblcustomfields[0]->fieldname; 
                if ($fieldname == "Enter Existing Reseller Username") {
                    if (empty(trim($reseller_name))) {
                        return [
                            'Reseller Name is required',
                        ];
                    } else {
                        $count = Capsule::table('nxt_paneldetails')->where('id', $configoption1)->count();
                        if ($count > 0) {
                            $panel_details = Capsule::table('nxt_paneldetails')->where('id', $configoption1)->get();
                            $panel_url = $panel_details[0]->panel_link;
                            $bar = "/";
                            if (substr($panel_url, -1) == "/") {
                                $bar = "";
                            }
                            $panel_url = $panel_url . $bar;
                            $username = $panel_details[0]->username;
                            $password = $panel_details[0]->password;

                            $cookie_path = dirname(__FILE__) . '/Cookie.txt';
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $panel_url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POST, 0);
                            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                            $headers =  array();
                            $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.0.0 Safari/537.36';
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            $ret1 = curl_exec($ch);

                            //----------------------------------------------------------------------------------------------------------------
                            // get token
                            $dom = new DOMDocument();
                            @$dom->loadHTML($ret1);
                            $token = "";
                            $select = $dom->getElementsByTagName('meta');
                            if ($select->length > 0) {
                                for ($i = 0; $i < $select->length; $i++) {
                                    $selectgrab = $select->item($i);
                                    if ($selectgrab->getAttribute('name') == 'csrf-token') {
                                        $token = $selectgrab->getAttribute('content');
                                    }
                                }
                            }
                            //login request
                            curl_setopt($ch, CURLOPT_URL, $panel_url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, "_token=" . $token . "&username=$username&password=$password");
                            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
                            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

                            $headers = array();
                            $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.0.0 Safari/537.36';
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            $result = curl_exec($ch);

                            curl_setopt($ch, CURLOPT_URL, $panel_url . "dashboard");
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POST, 0);
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                            $headers =  array();
                            $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.0.0 Safari/537.36';
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            $ret2 = curl_exec($ch);

                            $login = "";
                            $dom = new DOMDocument();
                            @$dom->loadHTML($ret2);
                            $tags = $dom->getElementsByTagName('a');
                            for ($i = 0; $i < $tags->length; $i++) {
                                $grab = $tags->item($i);
                                if (trim($grab->nodeValue) == "Logout") {
                                    $login = "yes";
                                }
                            }
                            if ($login == "yes") {
                                // search reseller
                                $fields = array(
                                    'draw' => '10',
                                    'columns[1][data]' => 'expired',
                                    'columns[1][name]' => 'username',
                                    'columns[1][searchable]' => true,
                                    'columns[1][orderable]' => true,
                                    'columns[1][search][value]' => '',
                                    'columns[1][search][regex]' => false,
                                );
                                $fields_string = http_build_query($fields);
                                curl_setopt($ch, CURLOPT_URL, $panel_url . 'resellers/data');
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                                curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
                                $headers =  array();
                                $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.0.0 Safari/537.36';
                                $headers[] = 'X-Csrf-Token: ' . $token;
                                $headers[] = 'X-Requested-With: XMLHttpRequest';
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                $result = curl_exec($ch);
                                $result = json_decode($result);
                                if ($result->recordsFiltered > 0) {
                                    foreach ($result->data as $value) {
                                        if ($value->username == $reseller_name) {
                                            return '';
                                        }
                                    }
                                } else {
                                    return 'Please Enter Valid Reseller Name';
                                }
                            } else {
                                return 'Please Enter Valid Reseller Name';
                            }
                        } else {
                            return 'Please Enter Valid Reseller Name';
                        }
                        return 'Please Enter Valid Reseller Name';
                    }
                }
            }
        }
    }
});
