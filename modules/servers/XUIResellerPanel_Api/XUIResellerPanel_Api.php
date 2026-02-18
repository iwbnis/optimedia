<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use Illuminate\Database\Capsule\Manager as Capsule;

function XUIResellerPanel_Api_MetaData()
{

    return array(
        'DisplayName' => 'XUI Reseller API Panel',
        'APIVersion' => '1.0.6',
        'RequiresServer' => true,
    );
}

function XUIResellerPanel_Api_ConfigOptions()
{
    $licenseinfo = XUICheckLicenseByKey();

    if ($licenseinfo['status'] != 'Active') {
        return array('licenseKeyStatus' => array(
            'FriendlyName' => 'License Key Status',
            'Description' => "<span style='color:red;'>Invalid or Expired license key.<span>",
            'Size' => 80,
        ),);
    }

    $moduledetails = Capsule::table('tbladdonmodules')
        ->where('module', '=', 'XuiResellerDashboard')
        ->where('setting', '=', 'version')
        ->get();

    if (empty($moduledetails)) {
        return array('serverstatus' => array(
            'FriendlyName' => 'Module Status',
            'Description' => "<span style='color:red;'>Addon Module is not Activated Please Active it from Admin Area > Setup > Addon Modules > Xtream Reseller Panel Dashboard<span>",
            'Size' => 80
        ));
    }
    if (isset($_POST['action']) && $_POST['action'] == 'save') {
        if ($_POST['packageconfigoption']['10'] == 'on') {
            $config = Capsule::table('xtreamuione_config')->get();
            foreach ($config as $value) {
                $row[$value->setting] = $value->value;
            }
            $product_id = $_POST['id'];
            $mac_address_array = array(
                'fieldname' => $row['custom_field_mag'],
                'fieldtype' => 'text',
                'description' => 'Format 00:1A:79:12:34:5A',
                'regexpr' => "/([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})/",
                'required' => '',
                'showorder' => 'on',
                'showinvoice' => 'on',
            );

            $username = array(
                'fieldname' => $row['custom_field_username'],
                'fieldtype' => 'text',
                'description' => '(Panel Username)  - (Leave empty if you want system generates randomly)',
                'regexpr' => "",
                'required' => '',
                'showorder' => 'on',
                'showinvoice' => 'on',
            );
            $passwordfield = array(
                'fieldname' => $row['custom_field_password'],
                'fieldtype' => 'password',
                'description' => '(Panel Password) -(Leave empty if you want system generates randomly)',
                'regexpr' => "",
                'required' => '',
                'showorder' => 'on',
                'showinvoice' => 'on',
            );
            $eng_address_array = array(
                'fieldname' => $row['custom_field_eng'],
                'fieldtype' => 'text',
                'description' => 'Format 00:1A:79:12:34:5A',
                'regexpr' => "/([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})/",
                'required' => '',
                'showorder' => 'on',
                'showinvoice' => 'on',
            );
            if (isset($_POST['packageconfigoption']['3']) && !empty($_POST['packageconfigoption']['3'])) {
                if ($_POST['packageconfigoption']['3'] == 'magdevice') {
                    $custom_fields = array($row['custom_field_mag'] => $mac_address_array);
                } elseif ($_POST['packageconfigoption']['3'] == 'streamlineonly') {
                    $custom_fields = array($row['custom_field_username'] => $username, $row['custom_field_password'] => $passwordfield);
                } elseif ($_POST['packageconfigoption']['3'] == 'engdevice') {
                    $custom_fields = array($row['custom_field_eng'] => $eng_address_array);
                }
            }

            if (isset($custom_fields) && !empty($custom_fields)) {
                foreach ($custom_fields as $field_name => $field_value) {
                    if (0 == mysql_num_rows(mysql_query("SELECT * FROM `tblcustomfields` WHERE relid='$product_id' AND fieldname='$field_name'"))) {
                        if (mysql_query("INSERT INTO  `tblcustomfields` (`type`, `relid`, `fieldname`, `fieldtype`, `description`, `fieldoptions`, `regexpr`, `adminonly`, `required`, `showorder`, `showinvoice`, `sortorder`) VALUES ('product', '$product_id', '$field_name','" . $field_value['fieldtype'] . "','" . $field_value['description'] . "', '', '" . $field_value['regexpr'] . "', '', '" . $field_value['required'] . "', '" . $field_value['showorder'] . "','" . $field_value['showinvoice'] . "', '0')")) {
                            $result[] = 'success';
                        } else {
                            $result[] = 'error';
                        }
                    }
                }
                if (!in_array('error', $result)) {
                    logModuleCall('Xtream UI ONE', 'Custom Fields', 'Custom Fields Created', $custom_fields);
                }
            }
        }
    }

    $serversCustom = Capsule::table('xtreamui_servers')->count();
    if (isset($serversCustom) && !empty($serversCustom)) {
        $serversCustom = Capsule::table('xtreamui_servers')->get();
        $userdetails = array();
        foreach ($serversCustom as $server) {
            $user_info = XtreamUIAPICall($server->resellerurl . '/' . $server->accesscode . "/index.php?api_key=" . $server->apikey, 'GET', 'user_info');
            if ($user_info['status'] == 'STATUS_SUCCESS') {
                $userdetails[$server->id] = "<b id='usersinfo'>" . ucwords($user_info['data']['username']) . " (Credits - <font color='orange'><u>" . $user_info['data']['credits'] . "</u></font>)</b>";
            }
            $options[$server->id] = $server->servername;
        }
        if (!function_exists('array_key_first')) {

            function array_key_first(array $array)
            {
                if (count($array)) {
                    reset($array);
                    return key($array);
                }
                return null;
            }
        }
        return array(
            // a text field type allows for single line text input 
            'Select Your Xui Reseller Panel' => array(
                'Type' => 'dropdown',
                'Options' => $options,
                'Description' => '<a href="addonmodules.php?module=XuiResellerDashboard&page=addserver" target="__blank" class="btn btn-primary"> + Add New Xui Reseller Panel</a>',
                'Size' => 80
            ),
            'Reseller Details' => array(
                'Description' => $userdetails[array_key_first($options)],
            ),
            'Product' => array(
                'Type' => 'dropdown',
                'Options' => array(
                    'streamlineonly' => 'Stream Line',
                    'magdevice' => 'MAG Device',
                    'engdevice' => 'Enigma Device',
                ),
                'Description' => '<i>What type is this product?</i>',
                'Size' => '40'
            ),
            'M3U link' => array(
                'Type' => 'yesno',
                'Description' => 'Tick to Show M3U link in clientarea?',
            ),
            'Select Line Type' => array(
                'Type' => 'dropdown',
                'Options' => array(
                    'trial' => 'Trial',
                    'official' => 'Official'
                ),
                'Description' => ''
            ),
            'Watch Streams!' => array(
                'Type' => 'yesno',
                'Default' => 'yes',
                'Description' => 'Tick to show "Watch Stream" button for customers in their client area',
            ),
            'Select Trial Package' => array(
                'Type' => 'dropdown',
                'Options' => array(0 => 'No Package Found'),
            ),
            'Select Package' => array(
                'Type' => 'dropdown',
                'Options' => array(0 => 'No Package Found'),
            ),
            'Package Details' => array(
                'Description' => '<div id="package_info" style=""></div>',
            ),
            'Custom fields' => array(
                'Type' => 'yesno',
                'Default' => 'yes',
                'Description' => 'Tick to allow your customers to enter stream <br>username/password manually while ordering subscription',
            ),
            'ISP Lock' => array(
                'Type' => 'yesno',
                'Default' => 'yes',
                'Description' => 'Tick to allow ISP lock',
            ),
        );
    } else {
        return array(
            'Select Your Xui Reseller Panel' => array(
                'Type' => 'dropdown',
                'Options' => array(
                    'No Reseller Panel Found'
                ),
                'Description' => '<a href="addonmodules.php?module=XuiResellerDashboard&page=addserver" class="btn btn-primary"> + Add New Xui Reseller Panel</a>',
                'Size' => 80
            ),
        );
    }
}

function xuiresellerclean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens. 
    return preg_replace('/[^A-Za-z0-9@.\-]/', '', $string); // Removes special chars.
}

function XUIResellerPanel_Api_CreateAccount(array $params)
{
    $licenseinfo = XUICheckLicenseByKey();

    if ($licenseinfo['status'] != 'Active') {
        return 'Invalid or Expired license key';
    }
    $xtreamConfig = Capsule::table('xtreamuione_config')->get();
    $returndata = array();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $returndata[$config->setting] = $config->value;
        }
    }
    $is_trial = $params['configoption5'];
    $is_isplock = $params['configoption11'];
    $package_id = ($is_trial == 'official') ? $params['configoption8'] : $params['configoption7'];
    if ($params['configoption3'] == 'streamlineonly') {
        $username = $params["username"];
        $password = (isset($params["password"]) && !empty($params["password"])) ? $params["password"] : "";

        if (isset($params['customfields'][$returndata['custom_field_password']]) && !empty($params['customfields'][$returndata['custom_field_password']])) {
            $password = $staticpassword = $params['customfields'][$returndata['custom_field_password']];
        } elseif ($returndata['passwordformat'] == 'onlydigits') {
            $passworddigits = isset($returndata['passworddigits']) && !empty($returndata['passworddigits']) ? $returndata['passworddigits'] : '10';
            $password = $staticpassword = XUIResellerPanel_Api_generate_ran($passworddigits, false, "d");
        } elseif ($returndata['passwordformat'] == 'static') {
            $password = $staticpassword = $returndata['staticPassword'];
        } elseif ($returndata['passwordformat'] == 'digits_alphabet') {
            $passworddigits = isset($returndata['passworddigits']) && !empty($returndata['passworddigits']) ? $returndata['passworddigits'] : '10';
            $password = $staticpassword = XUIResellerPanel_Api_generate_ran($passworddigits);
        } else if ($password != "" && $username != "") {
            $password = $staticpassword = $password;
        }

        if (isset($staticpassword) && !empty($staticpassword)) {
            $command = 'EncryptPassword';
            $postData = array(
                'password2' => $staticpassword,
            );
            $results = localAPI($command, $postData);
            if ($results['result'] == 'success') {
                Capsule::table('tblhosting')
                    ->where('id', $params["serviceid"])
                    ->update(['password' => $results['password']]);
            }
        }
        if (empty($username)) {
            if (isset($params['customfields'][$returndata['custom_field_username']]) && !empty($params['customfields'][$returndata['custom_field_username']])) {
                $username = $params['customfields'][$returndata['custom_field_username']];
            } else {
                $usernamedigits = isset($returndata['usernamedigits']) && !empty($returndata['usernamedigits']) ? $returndata['usernamedigits'] : '10';
                if ($returndata['usernameformat'] == 'onlydigits') {
                    $username = XUIResellerPanel_Api_generate_ran($usernamedigits, false, "d");
                } else {
                    $username = XUIResellerPanel_Api_generate_ran($usernamedigits);
                }
            }
            Capsule::table('tblhosting')
                ->where('id', $params["serviceid"])
                ->update(['username' => trim($username)]);
        }

        $params["username"] = trim($username);
        $params["password"] = $password;
        $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
        $serviceid = $tblhostingdetails[0]->id;
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        );

        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);

        $post_data = array(
            'package' => $package_id,
            'trial' => ($is_trial == "trial") ? 1 : 0,
            'reseller_notes' => $reseller_notes,
            'username' => $params["username"],
            'password' => $params["password"],
            'is_isplock' => ($is_isplock == "on") ? 1 : 0,
        );
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'create_line', $post_data);
            $post_data['action'] = 'create_line';
            logModuleCall('Xtream UI ONE', __FUNCTION__, $post_data, $api_result);
            if (!empty($api_result['status'])) {
                if ($api_result['status'] == 'STATUS_EXISTS_USERNAME') {
                    return $username . " Username already exists";
                } elseif ($api_result['status'] == 'STATUS_NO_TRIALS') {
                    return 'No trials available';
                } elseif ($api_result['status'] == 'STATUS_INSUFFICIENT_CREDITS') {
                    return 'Insufficient credits available.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_PACKAGE') {
                    return 'Invalid package ID supplied';
                } elseif ($api_result['status'] == 'STATUS_INVALID_USERNAME') {
                    return 'Invalid username supplied, length is insufficient.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_PASSWORD') {
                    return 'Invalid password supplied, length is insufficient.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_TYPE') {
                    return 'Package isn\'t user line. Maybe MAG / Enigma instead';
                } elseif ($api_result['status'] == 'STATUS_FAILURE') {
                    return 'Generic failure when inserting SQL';
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    $command = 'EncryptPassword';
                    $postData = array(
                        'password2' => $api_result["data"]["password"]
                    );
                    $results = localAPI($command, $postData);
                    if ($results['result'] == 'success') {
                        $exp_date = date("Y-m-d", $api_result['data']['exp_date']);
                        Capsule::table('tblhosting')->where('id', $params["serviceid"])->update(['username' => $api_result["data"]["username"], 'password' => $results['password'], 'dedicatedip' => $api_result["data"]["id"], 'nextduedate' => $exp_date]);
                        return 'success';
                    }
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    } elseif ($params['configoption3'] == 'magdevice') {
        $MagAddress = (isset($params["customfields"][$returndata['custom_field_mag']]) && !empty($params["customfields"][$returndata['custom_field_mag']])) ? $params["customfields"][$returndata['custom_field_mag']] : "";
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        );
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array(
            'mac' => "$MagAddress",
            'package' => $package_id,
            'trial' => ($is_trial == "trial") ? 1 : 0,
            'reseller_notes' => $reseller_notes,
            'is_isplock' => ($is_isplock == "on") ? 1 : 0,
        );
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'create_mag', $post_data);
            $post_data['action'] = 'create_mag';
            logModuleCall('Xtream UI ONE', __FUNCTION__, $post_data, $api_result);
            if (!empty($api_result['status'])) {
                if ($api_result['status'] == 'STATUS_INVALID_TYPE') {
                    return "Package isn't for MAG";
                } elseif ($api_result['status'] == 'STATUS_NO_TRIALS') {
                    return 'No trials available';
                } elseif ($api_result['status'] == 'STATUS_INSUFFICIENT_CREDITS') {
                    return 'Insufficient credits available.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_PACKAGE') {
                    return 'Invalid package ID supplied';
                } elseif ($api_result['status'] == 'STATUS_INVALID_MAC') {
                    return "Invalid MAC supplied, doesn't match MAC format.";
                } elseif ($api_result['status'] == 'STATUS_EXISTS_MAC') {
                    return 'MAC already exists for another device';
                } elseif ($api_result['status'] == 'STATUS_FAILURE') {
                    return 'Generic failure when inserting SQL';
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    Capsule::table('tblhosting')->where('id', $params["serviceid"])->update(['dedicatedip' => $api_result["data"]["mag_id"]]);
                    return 'success';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    } elseif ($params['configoption3'] == 'engdevice') {
        $EngimaAddress = (isset($params["customfields"][$returndata['custom_field_eng']]) && !empty($params["customfields"][$returndata['custom_field_eng']])) ? $params["customfields"][$returndata['custom_field_eng']] : "";
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        );
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array(
            'mac' => "$EngimaAddress",
            'package' => $package_id,
            'trial' => ($is_trial == "trial") ? 1 : 0,
            'reseller_notes' => $reseller_notes,
            'is_isplock' => ($is_isplock == "on") ? 1 : 0,
        );
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'create_enigma', $post_data);
            $post_data['action'] = 'create_enigma';
            logModuleCall('Xtream UI ONE', __FUNCTION__, $post_data, $api_result);
            if (!empty($api_result['status'])) {
                if ($api_result['status'] == 'STATUS_INVALID_TYPE') {
                    return "Package isn't for MAG";
                } elseif ($api_result['status'] == 'STATUS_NO_TRIALS') {
                    return 'No trials available';
                } elseif ($api_result['status'] == 'STATUS_INSUFFICIENT_CREDITS') {
                    return 'Insufficient credits available.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_PACKAGE') {
                    return 'Invalid package ID supplied';
                } elseif ($api_result['status'] == 'STATUS_INVALID_MAC') {
                    return "Invalid MAC supplied, doesn't match MAC format.";
                } elseif ($api_result['status'] == 'STATUS_EXISTS_MAC') {
                    return 'MAC already exists for another device';
                } elseif ($api_result['status'] == 'STATUS_FAILURE') {
                    return 'Generic failure when inserting SQL';
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    Capsule::table('tblhosting')->where('id', $params["serviceid"])->update(['dedicatedip' => $api_result["data"]["device_id"]]);
                    return 'success';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    }
}

function XUIResellerPanel_Api_Renew(array $params)
{
    $xtreamConfig = Capsule::table('xtreamuione_config')->get();
    $returndata = array();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $returndata[$config->setting] = $config->value;
        }
    }
    $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
    $is_trial = $params['configoption5'];
    $is_isplock = $params['configoption11'];
    $package_id = ($is_trial == 'official') ? $params['configoption8'] : $params['configoption7'];
    if ($params['configoption3'] == 'streamlineonly') {
        $username = $params["username"];
        $password = (isset($params["password"]) && !empty($params["password"])) ? $params["password"] : "";
        $params["username"] = $username;
        $params["password"] = $password;
        $serviceid = $tblhostingdetails[0]->id;
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        );

        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array(
            'id' => $tblhostingdetails[0]->dedicatedip,
            'package' => $package_id,
            'trial' => ($is_trial == "trial") ? 1 : 0,
            'reseller_notes' => $reseller_notes,
            'username' => $username,
            'password' => $password,
            'is_isplock' => ($is_isplock == "on") ? 1 : 0,
        );
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'edit_line', $post_data);
            $post_data['action'] = 'edit_line';
            logModuleCall('Xtream UI ONE', __FUNCTION__, $post_data, $api_result);
            if (!empty($api_result['status'])) {
                if ($api_result['status'] == 'STATUS_EXISTS_USERNAME') {
                    return $username . " Username already exists";
                } elseif ($api_result['status'] == 'STATUS_NO_TRIALS') {
                    return 'No trials available';
                } elseif ($api_result['status'] == 'STATUS_INSUFFICIENT_CREDITS') {
                    return 'Insufficient credits available.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_PACKAGE') {
                    return 'Invalid package ID supplied';
                } elseif ($api_result['status'] == 'STATUS_INVALID_USERNAME') {
                    return 'Invalid username supplied, length is insufficient.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_PASSWORD') {
                    return 'Invalid password supplied, length is insufficient.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_TYPE') {
                    return 'Package isn\'t user line. Maybe MAG / Enigma instead';
                } elseif ($api_result['status'] == 'STATUS_FAILURE') {
                    return 'Generic failure when inserting SQL';
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    $exp_date = date("Y-m-d", $api_result['data']['exp_date']);
                    Capsule::table('tblhosting')->where('id', $params["serviceid"])->update(['nextduedate' => $exp_date]);
                    return 'success';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {

            return 'No Server details found!';
        }
    } elseif ($params['configoption3'] == 'magdevice') {
        $MagAddress = (isset($params["customfields"][$returndata['custom_field_mag']]) && !empty($params["customfields"][$returndata['custom_field_mag']])) ? $params["customfields"][$returndata['custom_field_mag']] : "";
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        );
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array(
            'id' => $tblhostingdetails[0]->dedicatedip,
            'mac' => "$MagAddress",
            'package' => $package_id,
            'trial' => ($is_trial == "trial") ? 1 : 0,
            'reseller_notes' => $reseller_notes,
            'is_isplock' => ($is_isplock == "on") ? 1 : 0,
        );
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'edit_mag', $post_data);
            $post_data['action'] = 'edit_mag';
            logModuleCall('Xtream UI ONE', __FUNCTION__, $post_data, $api_result);
            if (!empty($api_result['status'])) {
                if ($api_result['status'] == 'STATUS_INVALID_TYPE') {
                    return "Package isn't for MAG";
                } elseif ($api_result['status'] == 'STATUS_NO_TRIALS') {
                    return 'No trials available';
                } elseif ($api_result['status'] == 'STATUS_INSUFFICIENT_CREDITS') {
                    return 'Insufficient credits available.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_PACKAGE') {
                    return 'Invalid package ID supplied';
                } elseif ($api_result['status'] == 'STATUS_INVALID_MAC') {
                    return "Invalid MAC supplied, doesn't match MAC format.";
                } elseif ($api_result['status'] == 'STATUS_EXISTS_MAC') {
                    return 'MAC already exists for another device';
                } elseif ($api_result['status'] == 'STATUS_FAILURE') {
                    return 'Generic failure when inserting SQL';
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    $exp_date = date("Y-m-d", $api_result['data']['exp_date']);
                    Capsule::table('tblhosting')->where('id', $params["serviceid"])->update(['nextduedate' => $exp_date]);
                    return 'success';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    } elseif ($params['configoption3'] == 'engdevice') {
        $EngimaAddress = (isset($params["customfields"][$returndata['custom_field_eng']]) && !empty($params["customfields"][$returndata['custom_field_eng']])) ? $params["customfields"][$returndata['custom_field_eng']] : "";
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        );
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array(
            'id' => $tblhostingdetails[0]->dedicatedip,
            'mac' => "$EngimaAddress",
            'package' => $package_id,
            'trial' => ($is_trial == "trial") ? 1 : 0,
            'reseller_notes' => $reseller_notes,
            'is_isplock' => ($is_isplock == "on") ? 1 : 0,
        );
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'edit_enigma', $post_data);
            $post_data['action'] = 'edit_enigma';
            logModuleCall('Xtream UI ONE', __FUNCTION__, $post_data, $api_result);
            if (!empty($api_result['status'])) {
                if ($api_result['status'] == 'STATUS_INVALID_TYPE') {
                    return "Package isn't for MAG";
                } elseif ($api_result['status'] == 'STATUS_NO_TRIALS') {
                    return 'No trials available';
                } elseif ($api_result['status'] == 'STATUS_INSUFFICIENT_CREDITS') {
                    return 'Insufficient credits available.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_PACKAGE') {
                    return 'Invalid package ID supplied';
                } elseif ($api_result['status'] == 'STATUS_INVALID_MAC') {
                    return "Invalid MAC supplied, doesn't match MAC format.";
                } elseif ($api_result['status'] == 'STATUS_EXISTS_MAC') {
                    return 'MAC already exists for another device';
                } elseif ($api_result['status'] == 'STATUS_FAILURE') {
                    return 'Generic failure when inserting SQL';
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    $exp_date = date("Y-m-d", $api_result['data']['exp_date']);
                    Capsule::table('tblhosting')->where('id', $params["serviceid"])->update(['nextduedate' => $exp_date]);
                    return 'success';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    }
}

function XUIResellerPanel_Api_ChangePackage(array $params)
{
    $xtreamConfig = Capsule::table('xtreamuione_config')->get();
    $returndata = array();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $returndata[$config->setting] = $config->value;
        }
    }
    $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
    $is_trial = $params['configoption5'];
    $is_isplock = $params['configoption11'];
    $package_id = ($is_trial == 'official') ? $params['configoption8'] : $params['configoption7'];
    if ($params['configoption3'] == 'streamlineonly') {
        $username = $params["username"];
        $password = (isset($params["password"]) && !empty($params["password"])) ? $params["password"] : "";
        $params["username"] = $username;
        $params["password"] = $password;
        $serviceid = $tblhostingdetails[0]->id;
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        );

        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array(
            'id' => $tblhostingdetails[0]->dedicatedip,
            'package' => $package_id,
            'trial' => ($is_trial == "trial") ? 1 : 0,
            'reseller_notes' => $reseller_notes,
            'username' => $username,
            'password' => $password,
            'is_isplock' => ($is_isplock == "on") ? 1 : 0,
        );
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'edit_line', $post_data);
            logModuleCall('Xtream UI ONE', __FUNCTION__, $post_data, $api_result);
            if (!empty($api_result['status'])) {
                if ($api_result['status'] == 'STATUS_EXISTS_USERNAME') {
                    return $username . " Username already exists";
                } elseif ($api_result['status'] == 'STATUS_NO_TRIALS') {
                    return 'No trials available';
                } elseif ($api_result['status'] == 'STATUS_INSUFFICIENT_CREDITS') {
                    return 'Insufficient credits available.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_PACKAGE') {
                    return 'Invalid package ID supplied';
                } elseif ($api_result['status'] == 'STATUS_INVALID_USERNAME') {
                    return 'Invalid username supplied, length is insufficient.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_PASSWORD') {
                    return 'Invalid password supplied, length is insufficient.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_TYPE') {
                    return 'Package isn\'t user line. Maybe MAG / Enigma instead';
                } elseif ($api_result['status'] == 'STATUS_FAILURE') {
                    return 'Generic failure when inserting SQL';
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    $command = 'EncryptPassword';
                    $postData = array(
                        'password2' => $api_result["data"]["password"]
                    );
                    $results = localAPI($command, $postData);
                    if ($results['result'] == 'success') {
                        Capsule::table('tblhosting')->where('id', $params["serviceid"])->update(['username' => $api_result["data"]["username"], 'password' => $results['password'], 'dedicatedip' => $api_result["data"]["id"]]);
                        return 'success';
                    }
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {

            return 'No Server details found!';
        }
    } elseif ($params['configoption3'] == 'magdevice') {
        $MagAddress = (isset($params["customfields"][$returndata['custom_field_mag']]) && !empty($params["customfields"][$returndata['custom_field_mag']])) ? $params["customfields"][$returndata['custom_field_mag']] : "";
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        );
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array(
            'id' => $tblhostingdetails[0]->dedicatedip,
            'mac' => "$MagAddress",
            'package' => $package_id,
            'trial' => ($is_trial == "trial") ? 1 : 0,
            'reseller_notes' => $reseller_notes,
            'is_isplock' => ($is_isplock == "on") ? 1 : 0,
        );
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'edit_mag', $post_data);
            logModuleCall('Xtream UI ONE', __FUNCTION__, $post_data, $api_result);
            if (!empty($api_result['status'])) {
                if ($api_result['status'] == 'STATUS_INVALID_TYPE') {
                    return "Package isn't for MAG";
                } elseif ($api_result['status'] == 'STATUS_NO_TRIALS') {
                    return 'No trials available';
                } elseif ($api_result['status'] == 'STATUS_INSUFFICIENT_CREDITS') {
                    return 'Insufficient credits available.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_PACKAGE') {
                    return 'Invalid package ID supplied';
                } elseif ($api_result['status'] == 'STATUS_INVALID_MAC') {
                    return "Invalid MAC supplied, doesn't match MAC format.";
                } elseif ($api_result['status'] == 'STATUS_EXISTS_MAC') {
                    return 'MAC already exists for another device';
                } elseif ($api_result['status'] == 'STATUS_FAILURE') {
                    return 'Generic failure when inserting SQL';
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    Capsule::table('tblhosting')->where('id', $params["serviceid"])->update(['dedicatedip' => $api_result["data"]["mag_id"]]);
                    return 'success';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    } elseif ($params['configoption3'] == 'engdevice') {
        $EngimaAddress = (isset($params["customfields"][$returndata['custom_field_eng']]) && !empty($params["customfields"][$returndata['custom_field_eng']])) ? $params["customfields"][$returndata['custom_field_eng']] : "";
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        );
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array(
            'id' => $tblhostingdetails[0]->dedicatedip,
            'mac' => "$EngimaAddress",
            'package' => $package_id,
            'trial' => ($is_trial == "trial") ? 1 : 0,
            'reseller_notes' => $reseller_notes,
            'is_isplock' => ($is_isplock == "on") ? 1 : 0,
        );
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'edit_enigma', $post_data);
            logModuleCall('Xtream UI ONE', __FUNCTION__, $post_data, $api_result);
            if (!empty($api_result['status'])) {
                if ($api_result['status'] == 'STATUS_INVALID_TYPE') {
                    return "Package isn't for MAG";
                } elseif ($api_result['status'] == 'STATUS_NO_TRIALS') {
                    return 'No trials available';
                } elseif ($api_result['status'] == 'STATUS_INSUFFICIENT_CREDITS') {
                    return 'Insufficient credits available.';
                } elseif ($api_result['status'] == 'STATUS_INVALID_PACKAGE') {
                    return 'Invalid package ID supplied';
                } elseif ($api_result['status'] == 'STATUS_INVALID_MAC') {
                    return "Invalid MAC supplied, doesn't match MAC format.";
                } elseif ($api_result['status'] == 'STATUS_EXISTS_MAC') {
                    return 'MAC already exists for another device';
                } elseif ($api_result['status'] == 'STATUS_FAILURE') {
                    return 'Generic failure when inserting SQL';
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    Capsule::table('tblhosting')->where('id', $params["serviceid"])->update(['dedicatedip' => $api_result["data"]["device_id"]]);
                    return 'success';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    }
}

function XUIResellerPanel_Api_SuspendAccount(array $params)
{
    $xtreamConfig = Capsule::table('xtreamuione_config')->get();
    $returndata = array();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $returndata[$config->setting] = $config->value;
        }
    }
    if ($params['configoption3'] == 'streamlineonly') {
        $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        ); 
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array('id' => $tblhostingdetails[0]->dedicatedip, 'reseller_notes' => $reseller_notes,);
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'disable_line', $post_data);
            $post_data['action'] = 'disable_line';
            logModuleCall('Xtream UI ONE', __FUNCTION__, array('id' => $tblhostingdetails[0]->dedicatedip, "Username" => $params['username']), $api_result);
            if (!empty($api_result)) {
                if (!empty($api_result['status']) && $api_result['status'] == 'STATUS_FAILURE') {
                    return "Suspend Fail - Line id didn't found!";
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    return 'success';
                } else {
                    return 'No Response from the server! Please check the logs for more details';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    }

    if ($params['configoption3'] == 'magdevice') {
        $MagAddress = (isset($params["customfields"][$returndata['custom_field_mag']]) && !empty($params["customfields"][$returndata['custom_field_mag']])) ? $params["customfields"][$returndata['custom_field_mag']] : "";
        $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        ); 
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array('id' => $tblhostingdetails[0]->dedicatedip,'reseller_notes' => $reseller_notes,);
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'disable_mag', $post_data);
            $post_data['action'] = 'disable_mag';
            logModuleCall('Xtream UI ONE', __FUNCTION__, array('id' => $tblhostingdetails[0]->dedicatedip, "MAC Address" => $MagAddress), $api_result);
            if (!empty($api_result)) {
                if (!empty($api_result['status']) && $api_result['status'] == 'STATUS_FAILURE') {
                    return "Suspend Fail - MAG Device not found!";
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    return 'success';
                } else {
                    return 'No Response from the server! Please check the logs for more details';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    }

    if ($params['configoption3'] == 'engdevice') {
        $EngimaAddress = (isset($params["customfields"][$returndata['custom_field_eng']]) && !empty($params["customfields"][$returndata['custom_field_eng']])) ? $params["customfields"][$returndata['custom_field_eng']] : "";
        $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        ); 
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array('id' => $tblhostingdetails[0]->dedicatedip,'reseller_notes' => $reseller_notes,);
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'disable_enigma', $post_data);
            $post_data['action'] = 'disable_enigma';
            logModuleCall('Xtream UI ONE', __FUNCTION__, array('id' => $tblhostingdetails[0]->dedicatedip, "MAC Address" => $EngimaAddress), $api_result);
            if (!empty($api_result)) {
                if (!empty($api_result['status']) && $api_result['status'] == 'STATUS_FAILURE') {
                    return "Suspend Fail - Enigma Device not found!";
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    return 'success';
                } else {
                    return 'No Response from the server! Please check the logs for more details';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    }
}

function XUIResellerPanel_Api_UnsuspendAccount(array $params)
{
    $xtreamConfig = Capsule::table('xtreamuione_config')->get();
    $returndata = array();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $returndata[$config->setting] = $config->value;
        }
    }
    if ($params['configoption3'] == 'streamlineonly') {
        $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        ); 
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array('id' => $tblhostingdetails[0]->dedicatedip,'reseller_notes' => $reseller_notes,);
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'enable_line', $post_data);
            $post_data['action'] = 'enable_line';
            logModuleCall('Xtream UI ONE', __FUNCTION__, array('id' => $tblhostingdetails[0]->dedicatedip, "Username" => $params['username']), $api_result);
            if (!empty($api_result)) {
                if (!empty($api_result['status']) && $api_result['status'] == 'STATUS_FAILURE') {
                    return "Activate Service Fail - Line id didn't found!";
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    return 'success';
                } else {
                    return 'No Response from the server! Please check the logs for more details';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    }
    if ($params['configoption3'] == 'magdevice') {
        $MagAddress = (isset($params["customfields"][$returndata['custom_field_mag']]) && !empty($params["customfields"][$returndata['custom_field_mag']])) ? $params["customfields"][$returndata['custom_field_mag']] : "";
        $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        ); 
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array('id' => $tblhostingdetails[0]->dedicatedip,'reseller_notes' => $reseller_notes,);
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'enable_mag', $post_data);
            $post_data['action'] = 'enable_mag';
            logModuleCall('Xtream UI ONE', __FUNCTION__, array('id' => $tblhostingdetails[0]->dedicatedip, "MAC Address" => $MagAddress), $api_result);
            if (!empty($api_result)) {
                if (!empty($api_result['status']) && $api_result['status'] == 'STATUS_FAILURE') {
                    return "Activate Service Fail  - MAG Device not found!";
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    return 'success';
                } else {
                    return 'No Response from the server! Please check the logs for more details';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    }

    if ($params['configoption3'] == 'engdevice') {
        $EngimaAddress = (isset($params["customfields"][$returndata['custom_field_eng']]) && !empty($params["customfields"][$returndata['custom_field_eng']])) ? $params["customfields"][$returndata['custom_field_eng']] : "";
        $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        ); 
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $post_data = array('id' => $tblhostingdetails[0]->dedicatedip,'reseller_notes' => $reseller_notes,);
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'enable_enigma', $post_data);
            $post_data['action'] = 'enable_enigma';
            logModuleCall('Xtream UI ONE', __FUNCTION__, array('id' => $tblhostingdetails[0]->dedicatedip, "MAC Address" => $EngimaAddress), $api_result);
            if (!empty($api_result)) {
                if (!empty($api_result['status']) && $api_result['status'] == 'STATUS_FAILURE') {
                    return "Activate Service Fail  - Enigma Device not found!";
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    return 'success';
                } else {
                    return 'No Response from the server! Please check the logs for more details';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    }
}

function XUIResellerPanel_Api_TerminateAccount(array $params)
{
    $xtreamConfig = Capsule::table('xtreamuione_config')->get();
    $returndata = array();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $returndata[$config->setting] = $config->value;
        }
    }
    if ($params['configoption3'] == 'streamlineonly') {
        $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        $post_data = array('id' => $tblhostingdetails[0]->dedicatedip);
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'delete_line', $post_data);
            $post_data['action'] = 'delete_line';
            logModuleCall('Xtream UI ONE', __FUNCTION__, array('id' => $tblhostingdetails[0]->dedicatedip, "Username" => $params['username']), $api_result);
            if (!empty($api_result)) {
                if (!empty($api_result['status']) && $api_result['status'] == 'STATUS_FAILURE') {
                    return "Delete Fail - Line id didn't found!";
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    return 'success';
                } else {
                    return 'No Response from the server! Please check the logs for more details';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    }
    if ($params['configoption3'] == 'magdevice') {
        $MagAddress = (isset($params["customfields"][$returndata['custom_field_mag']]) && !empty($params["customfields"][$returndata['custom_field_mag']])) ? $params["customfields"][$returndata['custom_field_mag']] : "";
        $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        $post_data = array('id' => $tblhostingdetails[0]->dedicatedip);
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'delete_mag', $post_data);
            $post_data['action'] = 'delete_mag';
            logModuleCall('Xtream UI ONE', __FUNCTION__, array('id' => $tblhostingdetails[0]->dedicatedip, "MAC Address" => $MagAddress), $api_result);
            if (!empty($api_result)) {
                if (!empty($api_result['status']) && $api_result['status'] == 'STATUS_FAILURE') {
                    return "Delete Fail - MAG Device not found!";
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    return 'success';
                } else {
                    return 'No Response from the server! Please check the logs for more details';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    }

    if ($params['configoption3'] == 'engdevice') {
        $EngimaAddress = (isset($params["customfields"][$returndata['custom_field_eng']]) && !empty($params["customfields"][$returndata['custom_field_eng']])) ? $params["customfields"][$returndata['custom_field_eng']] : "";
        $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
        $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
        $post_data = array('id' => $tblhostingdetails[0]->dedicatedip);
        if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
            $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'delete_enigma', $post_data);
            $post_data['action'] = 'delete_enigma';
            logModuleCall('Xtream UI ONE', __FUNCTION__, array('id' => $tblhostingdetails[0]->dedicatedip, "MAC Address" => $EngimaAddress), $api_result);
            if (!empty($api_result)) {
                if (!empty($api_result['status']) && $api_result['status'] == 'STATUS_FAILURE') {
                    return "Delete Fail - Enigma Device not found!";
                } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                    return 'success';
                } else {
                    return 'No Response from the server! Please check the logs for more details';
                }
            } else {
                return 'No Response from the server! Please check the logs for more details';
            }
        } else {
            return 'No Server details found!';
        }
    }
}

function XtreamUIAPICall($url, $method, $action, $data = NULL)
{
    $requesturl = $url . '&action=' . $action;
    $curl = curl_init($requesturl);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POST, true);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT"); // note the PUT here  
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;
    }
    curl_setopt($curl, CURLOPT_TIMEOUT, 100);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array());
    $jsondata = curl_exec($curl);
    if (curl_error($curl)) {
        $error = "Connection Error: " . curl_errno($curl) . ' - ' . curl_error($curl);
        return array(
            'errorCode' => 007,
            'userMessage' => $error
        );
    }
    curl_close($curl);
    $arr = json_decode($jsondata, true); # Decode JSON String 
    return $arr;
}

function XUIResellerPanel_Api_ClientArea(array $params)
{
    if ($params['status'] == 'Active') {
        $xtreamConfig = Capsule::table('xtreamuione_config')->get();
        $returndata = array();
        if (isset($xtreamConfig) && !empty($xtreamConfig)) {
            foreach ($xtreamConfig as $config) {
                $returndata[$config->setting] = $config->value;
            }
        }
        $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
        if ($params['configoption3'] == 'streamlineonly') {

            $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
            $replacements = array(
                $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
            ); 
            $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
            $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
            $post_data = array('id' => $tblhostingdetails[0]->dedicatedip,'reseller_notes' => $reseller_notes,);
            if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {

                $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'get_line', $post_data);
                if (!empty($api_result)) {
                    if (!empty($api_result['status']) && $api_result['status'] == 'STATUS_SUCCESS') {
                        $templateFile = 'templates/overview.tpl';
                    } else {
                        $error = 'User Not found!';
                        $templateFile = 'templates/error.tpl';
                    }
                    $is_trial = $params['configoption5'];
                    $applink = Capsule::table('xtreamui_applinks')->count();
                    if ($applink > 0) {
                        $applink = Capsule::table('xtreamui_applinks')->get();
                        // print_r($applink);
                        // exit;
                        foreach ($applink as $app) {
                            // $appdata[][$app->appfor] = $app->applink;
                            $appdata[] = array('applink' => $app->applink, 'name' => $app->appname, 'apptype' => $app->appfor);
                        }
                    }
                    $portalurl = unserialize($server[0]->magportalurl);
                    $variabledata = array(
                        'appdata' => $appdata,
                        'iptv_username' => $params['username'],
                        'iptv_password' => $params['password'],
                        'response' => $response,
                        'message' => isset($result) && !empty($result) ? $result : $response,
                        'lang' => $returndata,
                        'is_trial' => ($is_trial == "trial") ? 1 : 0,
                        'm3ulink' => $params['configoption4'],
                        'watchstream' => $params['configoption6'],
                        'outputfirst' => 'ts',
                        'mag_portal' => $portalurl[0],
                        'm3uurl' => $portalurl[1],
                        'watchstrmurl' => $portalurl[2],
                        'usefulErrorHelper' => isset($error) && !empty($error) ? $error : '',
                        'status' => $params['status'],
                        'exp_date' => ((empty($api_result['data']['exp_date'])) ? 'Unlimited' : date('Y-m-d H:i:s', $api_result['data']['exp_date']))
                    );
                    $checkupgrade = Capsule::table('tblhosting')
                        ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
                        ->join('tblproduct_upgrade_products', 'tblproducts.id', '=', 'tblproduct_upgrade_products.product_id')
                        ->select('tblproduct_upgrade_products.*')
                        ->where('tblhosting.id', $params['serviceid'])
                        ->count();
                    $checkupgrade = ($checkupgrade > 0) ? '1' : '0';
                    $variabledata['service_id'] = $params['serviceid'];
                    $variabledata['checkupgrade'] = $checkupgrade;
                }
            }
        } elseif ($params['configoption3'] == 'magdevice') {
            if (isset($_POST['customAction']) && !empty($_POST['customAction'])) {
                if ($_POST['customAction'] == 'changeMAG') {
                    $is_trial = $params['configoption5'];
                    $package_id = ($is_trial == 'official') ? $params['configoption8'] : $params['configoption7'];
                    $MagAddress = (isset($_POST['newMAC']) && !empty($_POST['newMAC'])) ? $_POST['newMAC'] : "";
                    $replacements = array(
                        $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
                    );
                    $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
                    $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
                    $post_data = array(
                        'id' => $tblhostingdetails[0]->dedicatedip,
                        'mac' => "$MagAddress",
                        'reseller_notes' => $reseller_notes,
                    );
                    $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
                    if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
                        $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'edit_mag', $post_data);
                        $post_data['action'] = 'edit_mag';
                        logModuleCall('Xtream UI ONE', __FUNCTION__, $post_data, $api_result);
                        if (!empty($api_result['status'])) {
                            if ($api_result['status'] == 'STATUS_INVALID_TYPE') {
                                $response = "Package isn't for MAG";
                            } elseif ($api_result['status'] == 'STATUS_NO_TRIALS') {
                                $response = 'No trials available';
                            } elseif ($api_result['status'] == 'STATUS_INSUFFICIENT_CREDITS') {
                                $response = 'Insufficient credits available.';
                            } elseif ($api_result['status'] == 'STATUS_INVALID_PACKAGE') {
                                $response = 'Invalid package ID supplied';
                            } elseif ($api_result['status'] == 'STATUS_INVALID_MAC') {
                                $response = "Invalid MAC supplied, doesn't match MAC format.";
                            } elseif ($api_result['status'] == 'STATUS_EXISTS_MAC') {
                                $response = 'MAC already exists for another device';
                            } elseif ($api_result['status'] == 'STATUS_FAILURE') {
                                $response = 'Generic failure when inserting SQL';
                            } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                                Capsule::table('tblhosting')->where('id', $params["serviceid"])->update(['dedicatedip' => $api_result["data"]["mag_id"]]);
                                $response = 'success';
                                $result = 'MAG Address updated Successfully!!';
                            }
                        } else {
                            $response = 'No Response from the server! Please check the logs for more details';
                        }
                    } else {
                        $response = 'No Server details found!';
                    }

                    $responsedata['variabledata'] = array(
                        'response' => $response,
                        'message' => isset($result) && !empty($result) ? $result : $response,
                    );
                }
            }
            $responsedata = XUIONEMAGDetails_Api($params, $returndata, $response, $result);
            $templateFile = $responsedata['templateFile'];
            $variabledata = $responsedata['variabledata'];
        } elseif ($params['configoption3'] == 'engdevice') {
            if (isset($_POST['customAction']) && !empty($_POST['customAction'])) {
                if ($_POST['customAction'] == 'changeENG') {
                    $is_trial = $params['configoption5'];
                    $package_id = ($is_trial == 'official') ? $params['configoption8'] : $params['configoption7'];
                    $MagAddress = (isset($_POST['newMAC']) && !empty($_POST['newMAC'])) ? $_POST['newMAC'] : "";
                    $replacements = array(
                        $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
                    );
                    $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
                    $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
                    $post_data = array(
                        'id' => $tblhostingdetails[0]->dedicatedip,
                        'mac' => "$MagAddress",
                        'reseller_notes' => $reseller_notes
                    );
                    $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
                    if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
                        $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'edit_enigma', $post_data);
                        $post_data['action'] = 'edit_enigma';
                        logModuleCall('Xtream UI ONE', __FUNCTION__, $post_data, $api_result);
                        if (!empty($api_result['status'])) {
                            if ($api_result['status'] == 'STATUS_INVALID_TYPE') {
                                $response = "Package isn't for Enigma.";
                            } elseif ($api_result['status'] == 'STATUS_NO_TRIALS') {
                                $response = 'No trials available';
                            } elseif ($api_result['status'] == 'STATUS_INSUFFICIENT_CREDITS') {
                                $response = 'Insufficient credits available.';
                            } elseif ($api_result['status'] == 'STATUS_INVALID_PACKAGE') {
                                $response = 'Invalid package ID supplied';
                            } elseif ($api_result['status'] == 'STATUS_INVALID_MAC') {
                                $response = "Invalid MAC supplied, doesn't match MAC format.";
                            } elseif ($api_result['status'] == 'STATUS_EXISTS_MAC') {
                                $response = 'MAC already exists for another device';
                            } elseif ($api_result['status'] == 'STATUS_FAILURE') {
                                $response = 'Generic failure when inserting SQL';
                            } elseif ($api_result['status'] == 'STATUS_SUCCESS') {
                                Capsule::table('tblhosting')->where('id', $params["serviceid"])->update(['dedicatedip' => $api_result["data"]["device_id"]]);
                                $response = 'success';
                                $result = 'Enigma Address updated Successfully!!';
                            }
                        } else {
                            $response = 'No Response from the server! Please check the logs for more details';
                        }
                    } else {
                        $response = 'No Server details found!';
                    }

                    $responsedata['variabledata'] = array(
                        'response' => $response,
                        'message' => isset($result) && !empty($result) ? $result : $response,
                    );
                }
            }
            $responsedata = XUIONEengDetails_Api($params, $returndata, $response, $result);
            $templateFile = $responsedata['templateFile'];
            $variabledata = $responsedata['variabledata'];
        }
        try {
            return array(
                'tabOverviewReplacementTemplate' => $templateFile,
                'templateVariables' => $variabledata,
            );
        } catch (Exception $e) {
            logModuleCall(
                'xtreamCode',
                __FUNCTION__,
                $params,
                $e->getMessage(),
                $e->getTraceAsString()
            );
            return array(
                'tabOverviewReplacementTemplate' => 'error.tpl',
                'templateVariables' => array(
                    'usefulErrorHelper' => $e->getMessage(),
                ),
            );
        }
    }
}

/*
 * Help Function 
 */

function XUIONEMAGDetails_Api($params, $returndata, $response, $result)
{
    $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
    $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
    $decoded = unserialize($server[0]->magportalurl);
    $mag_portal_url = $decoded[0];
    $replacements = array(
        $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
    ); 
    $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
    $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
    $post_data = array('id' => $tblhostingdetails[0]->dedicatedip,'reseller_notes' => $reseller_notes,);
    if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
        $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'get_mag', $post_data);
        $responsedata = array();

        if (isset($api_result) && !empty($api_result)) {
            if (!empty($api_result['status']) && $api_result['status'] == 'STATUS_SUCCESS') {
                $responsedata['templateFile'] = 'templates/magtemplate.tpl';
                $responsedata['variabledata'] = array(
                    'mag' => $api_result['data']['mac'],
                    'mag_portal' => $mag_portal_url,
                    'response' => $response,
                    'magdevice' => 'yes',
                    'message' => isset($result) && !empty($result) ? $result : $response,
                    'lang' => $returndata,
                    'status' => $params['status'],
                    'exp_date' => ((empty($api_result['data']['user']['exp_date'])) ? 'Unlimited' : date('Y-m-d H:i:s', $api_result['data']['user']['exp_date']))
                );
                return $responsedata;
            } else {
                $responsedata['templateFile'] = 'templates/error.tpl';
                $responsedata['variabledata'] = array('usefulErrorHelper' => "FAILED - No Record found!");
                return $responsedata;
            }
        }
        $responsedata['templateFile'] = 'templates/magtemplate.tpl';
        $responsedata['variabledata'] = array('usefulErrorHelper' => 'No Response From API. Please contact Administrator');
        return $responsedata;
    }
}

function XUIONEengDetails_Api($params, $returndata, $response, $result)
{
    $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
    $server = Capsule::table('xtreamui_servers')->where('id', $params['configoption1'])->get();
    $decoded = unserialize($server[0]->magportalurl);
    $mag_portal_url = $decoded[0];
    $replacements = array(
        $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
    ); 
    $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
    $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
    $post_data = array('id' => $tblhostingdetails[0]->dedicatedip,'reseller_notes' => $reseller_notes,);
    if (isset($server[0]->resellerurl) && !empty($server[0]->resellerurl)) {
        $api_result = XtreamUIAPICall($server[0]->resellerurl . '/' . $server[0]->accesscode . "/index.php?api_key=" . $server[0]->apikey, 'POST', 'get_enigma', $post_data);
        $responsedata = array();

        if (isset($api_result) && !empty($api_result)) {
            if (!empty($api_result['status']) && $api_result['status'] == 'STATUS_SUCCESS') {
                $responsedata['templateFile'] = 'templates/magtemplate.tpl';
                $responsedata['variabledata'] = array(
                    'mag' => $api_result['data']['mac'],
                    'mag_portal' => $mag_portal_url,
                    'response' => $response,
                    'engma' => 'yes',
                    'message' => isset($result) && !empty($result) ? $result : $response,
                    'lang' => $returndata,
                    'status' => $params['status'],
                    'exp_date' => ((empty($api_result['data']['user']['exp_date'])) ? 'Unlimited' : date('Y-m-d H:i:s', $api_result['data']['user']['exp_date']))
                );
                return $responsedata;
            } else {
                $responsedata['templateFile'] = 'templates/error.tpl';
                $responsedata['variabledata'] = array('usefulErrorHelper' => "FAILED - No Record found!");
                return $responsedata;
            }
        }
        $responsedata['templateFile'] = 'templates/magtemplate.tpl';
        $responsedata['variabledata'] = array('usefulErrorHelper' => 'No Response From API. Please contact Administrator');
        return $responsedata;
    }
}

function XUIResellerPanel_Api_generate_ran($length = 9, $add_dashes = false, $available_sets = 'lud')
{
    $sets = array();
    if (strpos($available_sets, 'l') !== false)
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';

    if (strpos($available_sets, 'u') !== false)
        $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';

    if (strpos($available_sets, 'd') !== false)
        $sets[] = '23456789';
    $all = '';
    $password = '';
    foreach ($sets as $set) {
        $password .= $set[array_rand(str_split($set))];
        $all .= $set;
    }
    $all = str_split($all);
    for ($i = 0; $i < $length - count($sets); $i++)
        $password .= $all[array_rand($all)];

    $password = str_shuffle($password);
    if (!$add_dashes)
        return $password;

    $dash_len = floor(sqrt($length));
    $dash_str = '';
    while (strlen($password) > $dash_len) {
        $dash_str .= substr($password, 0, $dash_len) . '-';
        $password = substr($password, $dash_len);
    }
    $dash_str .= $password;
    return $dash_str;
}

function XUICheckLicenseByKey()
{
    $result = Capsule::table('tbladdonmodules')
        ->where('module', '=', 'XuiResellerDashboard')
        ->get();

    foreach ($result as $row) {
        $settings[$row->setting] = $row->value;
    }

    if ($settings['license']) {
        $localkey = $settings['localkey'];
        $result = XUICheckLicense($settings['license'], $localkey);
        $result['licensekey'] = $settings['license'];
    } else {
        $result['status'] = 'licensekeynotfound';
    }
    return $result;
}

function XUICheckLicense($licensekey, $localkey = '')
{
    $whmcsurl = "https://www.whmcssmarters.com/clients/";
    $licensing_secret_key = "XUIResellerOne";
    $localkeydays = 14;
    $allowcheckfaildays = 5;
    $check_token = time() . md5(mt_rand(1000000000, 9999999999) . $licensekey);
    $checkdate = date("Ymdhis");
    if (!isset($_SERVER['SERVER_NAME']) && empty($_SERVER['SERVER_NAME'])) {
        $results['status'] = "Active";
        return $results;
    }

    $domain = $_SERVER['SERVER_NAME'];
    $usersip = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR'];
    $dirpath = dirname(dirname(__DIR__)) . '/addons/XuiResellerDashboard';
    $verifyfilepath = 'modules/servers/licensing/verify.php';

    $localkeyvalid = false;

    if ($localkey) {
        $localkey = str_replace("\n", '', $localkey); # Remove the line breaks 
        $localdata = substr($localkey, 0, strlen($localkey) - 32); # Extract License Data 
        $md5hash = substr($localkey, strlen($localkey) - 32); # Extract MD5 Hash 
        if ($md5hash == md5($localdata . $licensing_secret_key)) {
            $localdata = strrev($localdata); # Reverse the string 
            $md5hash = substr($localdata, 0, 32); # Extract MD5 Hash 
            $localdata = substr($localdata, 32); # Extract License Data 
            $localdata = base64_decode($localdata);
            $localkeyresults = unserialize($localdata);
            $originalcheckdate = $localkeyresults['checkdate'];
            if ($md5hash == md5($originalcheckdate . $licensing_secret_key)) {
                $localexpiry = date("Ymdhis", mktime(date("h"), date("i"), date("s"), date("m"), date("m"), date("d") - $localkeydays, date("Y")));
                if ($originalcheckdate > $localexpiry) {
                    $localkeyvalid = true;
                    $results = $localkeyresults;
                    $validdomains = explode(',', $results['validdomain']);
                    if (!in_array($_SERVER['SERVER_NAME'], $validdomains)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }

                    $validips = explode(',', $results['validip']);
                    if (!in_array($usersip, $validips)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                    $validdirs = explode(',', $results['validdirectory']);
                    if (!in_array($dirpath, $validdirs)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                }
            }
        }
    }

    if (!$localkeyvalid) {
        $responseCode = 0;
        $postfields = array(
            'licensekey' => $licensekey,
            'domain' => $domain,
            'ip' => $usersip,
            'dir' => $dirpath,
        );
        if ($check_token)
            $postfields['check_token'] = $check_token;

        $query_string = '';
        foreach ($postfields as $k => $v) {
            $query_string .= $k . '=' . urlencode($v) . '&';
        }
        if (function_exists('curl_exec')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $whmcsurl . $verifyfilepath);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $responseCodePattern = '/^HTTP\/\d+\.\d+\s+(\d+)/';
            $fp = @fsockopen($whmcsurl, 80, $errno, $errstr, 5);
            if ($fp) {
                $newlinefeed = "\r\n";
                $header = "POST " . $whmcsurl . $verifyfilepath . " HTTP/1.0" . $newlinefeed;
                $header .= "Host: " . $whmcsurl . $newlinefeed;
                $header .= "Content-type: application/x-www-form-urlencoded" . $newlinefeed;
                $header .= "Content-length: " . @strlen($query_string) . $newlinefeed;
                $header .= "Connection: close" . $newlinefeed . $newlinefeed;
                $header .= $query_string;
                $data = $line = '';
                @stream_set_timeout($fp, 20);
                @fputs($fp, $header);
                $status = @socket_get_status($fp);
                while (!@feof($fp) && $status) {
                    $line = @fgets($fp, 1024);
                    $patternMatches = array();
                    if (
                        !$responseCode && preg_match($responseCodePattern, trim($line), $patternMatches)
                    ) {
                        $responseCode = (empty($patternMatches[1])) ? 0 : $patternMatches[1];
                    }
                    $data .= $line;
                    $status = @socket_get_status($fp);
                }
                @fclose($fp);
            }
        }
        if ($responseCode != 200) {
            $localexpiry = date("Ymdhis", mktime(date("h"), date("i"), date("s"), date("m"), date("m"), date("d") - ($localkeydays + $allowcheckfaildays), date("Y")));
            if ($originalcheckdate > $localexpiry) {
                $results = $localkeyresults;
            } else {
                $results = array();
                $results['status'] = "Invalid";
                $results['description'] = "Remote Check Failed";
                return $results;
            }
        } else {
            preg_match_all('/<(.*?)>([^<]+)<\/\\1>/i', $data, $matches);
            $results = array();
            foreach ($matches[1] as $k => $v) {
                $results[$v] = $matches[2][$k];
            }
        }
        if (!is_array($results)) {
            die("Invalid License Server Response");
        }

        if ($results['md5hash']) {
            if ($results['md5hash'] != md5($licensing_secret_key . $check_token)) {
                $results['status'] = "Invalid";
                $results['description'] = "MD5 Checksum Verification Failed";
                return $results;
            }
        }
        if ($results['status'] == "Active") {
            $results['checkdate'] = $checkdate;
            $data_encoded = serialize($results);
            $data_encoded = base64_encode($data_encoded);
            $data_encoded = md5($checkdate . $licensing_secret_key) . $data_encoded;
            $data_encoded = strrev($data_encoded);
            $data_encoded = $data_encoded . md5($data_encoded . $licensing_secret_key);
            $data_encoded = wordwrap($data_encoded, 80, "\n", true);
            $results['localkey'] = $data_encoded;
        }
        $results['remotecheck'] = true;
    }
    unset($postfields, $data, $matches, $whmcsurl, $licensing_secret_key, $checkdate, $usersip, $localkeydays, $allowcheckfaildays, $md5hash);
    return $results;
}
