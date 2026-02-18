<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use Illuminate\Database\Capsule\Manager as Capsule;

function XUIResellerPanel_MetaData()
{
    return array(
        'DisplayName' => 'XUI Reseller Panel',
        'APIVersion' => '1.0.4',
        'RequiresServer' => true,
    );
}

function XUIResellerPanel_ConfigOptions()
{
    include_once '../modules/addons/XUIPanelCustom/XUIPanelCustom.php';
    $licenseinfo = XUIPanelCustom_doCheckLicense();
    if ($licenseinfo['status'] != 'licensekeynotfound') {
        if ($licenseinfo['status'] == 'Active') {
            $product_id = $_REQUEST['id'];
            $moduledetails = Capsule::table('tbladdonmodules')
                ->where('module', '=', 'XuiResellerDashboard')
                ->where('setting', '=', 'version')
                ->get();
            if (isset($product_id) && !empty($product_id)) {
                $tblproducts = Capsule::table('tblproducts')->where("id", $product_id)->get();
                $bouquets_cats = json_encode($tblproducts[0]->configoption13);
            }
            if (empty($moduledetails)) {
                return array('serverstatus' => array(
                    'FriendlyName' => 'Module Status',
                    'Description' => "<span style='color:red;'>Addon Module is not Activated Please Active it from Admin Area > Setup > Addon Modules > Xtream Reseller Panel Dashboard<span>",
                    'Size' => 80
                ));
            }
            if (isset($_POST['action']) && $_POST['action'] == 'save') {
                if (empty($_POST['packageconfigoption'][12])) {
                    Capsule::table('xui_cat_data')->where('productid', $product_id)->delete();
                }
                $config = Capsule::table('xui_settings')->get();
                foreach ($config as $value) {
                    $row[$value->setting] = $value->value;
                }
                $product_id = $_POST['id'];
                if ($_POST['packageconfigoption'][3] == 'streamlineonly') {
                    $result = array();
                    $custom_fields_forboth = array();
                    $custom_fields_forboth[] = array(
                        'fieldname' => $row['custom_field_username'],
                        'fieldtype' => 'text',
                        'fieldoptions' => '',
                        'description' => 'Leave it empty for auto generated',
                        'regexpr' => "",
                        'required' => '',
                        'showorder' => 'on',
                        'sortorder' => '1',
                        'showinvoice' => '',
                    );
                    $custom_fields_forboth[] = array(
                        'fieldname' => $row['custom_field_password'],
                        'fieldtype' => 'password',
                        'fieldoptions' => '',
                        'description' => 'Leave it blank to Auto Generate Random Chars',
                        'regexpr' => "",
                        'required' => '',
                        'showorder' => 'on',
                        'sortorder' => '2',
                        'showinvoice' => '',
                    );
                    $custom_fields_forboth[] = array(
                        'fieldname' => 'Select Bouquets',
                        'fieldtype' => 'text',
                        'fieldoptions' => '',
                        'description' => 'Leave empty for all bouquets.',
                        'regexpr' => "",
                        'required' => '',
                        'showorder' => 'on',
                        'sortorder' => '3',
                        'showinvoice' => '',
                    );
                }
                if ($_POST['packageconfigoption'][3] == 'magdevice') {
                    $result = array();
                    $custom_fields_forboth = array();
                    $custom_fields_forboth[] = array(
                        'fieldname' => $row['custom_field_mag'],
                        'fieldtype' => 'text',
                        'fieldoptions' => '',
                        'description' => 'Format 00:1A:79:12:34:5A',
                        'regexpr' => "/([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})/",
                        'required' => '',
                        'showorder' => 'on',
                        'sortorder' => '1',
                        'showinvoice' => '',
                    );
                    $custom_fields_forboth[] = array(
                        'fieldname' => 'Select Bouquets',
                        'fieldtype' => 'text',
                        'fieldoptions' => '',
                        'description' => 'Leave empty for all bouquets.',
                        'regexpr' => "",
                        'required' => '',
                        'showorder' => 'on',
                        'sortorder' => '2',
                        'showinvoice' => '',
                    );
                }
                if (isset($custom_fields_forboth) && !empty($custom_fields_forboth)) {
                    foreach ($custom_fields_forboth as $field_values) {
                        if (0 == mysql_num_rows(mysql_query("SELECT * FROM `tblcustomfields` WHERE relid='$product_id' AND fieldname='" . $field_values['fieldname'] . "' AND `type`='product'"))) {
                            if (mysql_query("INSERT INTO  `tblcustomfields` (`type`, `relid`, `fieldname`, `fieldtype`, `description`, `fieldoptions`, `regexpr`, `adminonly`, `required`, `showorder`, `showinvoice`, `sortorder`) VALUES ('product', '$product_id', '" . $field_values['fieldname'] . "','" . $field_values['fieldtype'] . "','" . $field_values['description'] . "', '" . $field_values['fieldoptions'] . "', '" . $field_values['regexpr'] . "', '', '" . $field_values['required'] . "', '" . $field_values['showorder'] . "','" . $field_values['showinvoice'] . "', '0')")) {
                                $result[] = 'success';
                            } else {
                                $result[] = 'error';
                            }
                        }
                    }
                    if (!in_array('error', $result)) {
                        logModuleCall('Xtream UI ONE', 'Custom Fields', 'Custom Fields Created', $custom_fields_forboth);
                    }
                }
            }
            $count = Capsule::table('xui_paneldetails')->count();
            if ($count > 0) {
                $serversCustom = Capsule::table('xui_paneldetails')->get();
                foreach ($serversCustom as $server) {
                    $options[$server->id] = $server->identifier;
                }
                return array(
                    'Select Your Xui Reseller Panel' => array(
                        'Type' => 'dropdown',
                        'Options' => $options,
                        'Description' => '<a href="addonmodules.php?module=XUIPanelCustom&action=addserver" target="__blank" class="btn btn-primary"> + Add New Xui Reseller Panel</a>',
                        'Size' => 80
                    ),
                    'Reseller Details' => array(
                        'Description' => '<span id="useroinfo"></span>',
                    ),
                    'Product' => array(
                        'Type' => 'dropdown',
                        'Options' => array(
                            'streamlineonly' => 'Stream Line',
                            'magdevice' => 'MAG Device',
                            // 'streamlineOrmagdevice' => 'Streamline/MAG Device',
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
                        'Description' => '<div id="package_info"></div>',
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
                    'Bouquets' => array(
                        'Type' => 'text',
                        "Size" => "25",
                        "Description" => "<a style='cursor: pointer;' onclick='getbouquets()'>Click here to show Bouquets</a>",
                    ),
                    'Add Bouquet Categories' => array(
                        'Type' => 'text',
                        "Size" => "25",
                        "Description" => "<a style='cursor: pointer;' onclick='getCategoriesBouquets($product_id)'>Click here to show Bouquet Categories</a>",
                    ),
                );
            } else {
                return array(
                    'Select Your Xui Reseller Panel' => array(
                        'Type' => 'dropdown',
                        'Options' => array(
                            'No Reseller Panel Found'
                        ),
                        'Description' => '<a href="addonmodules.php?module=XUIPanelCustom&page=addserver" class="btn btn-primary"> + Add New Xui Reseller Panel</a>',
                        'Size' => 80
                    ),
                );
            }
        } else {
            return array('licenseKeyStatus' => array(
                'FriendlyName' => 'License Key Status',
                'Description' => "<span style='color:red;'>Invalid or Expired license key.<span>",
                'Size' => 80,
            ));
        }
    } else {
        return array('licenseKeyStatus' => array(
            'FriendlyName' => 'License Key Status',
            'Description' => "<span style='color:red;'>Invalid or Expired license key.<span>",
            'Size' => 80,
        ));
    }
}

function XUIclean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens. 
    return preg_replace('/[^A-Za-z0-9@.\-]/', '', $string); // Removes special chars.
}

function XUIResellerPanel_CreateAccount(array $params)
{
    $panel_id = $params['configoption1'];
    $product_id = $params['packageid'];
    $xtreamConfig = Capsule::table('xui_settings')->get();
    $returndata = array();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $returndata[$config->setting] = $config->value;
        }
    }
    $is_trial = $params['configoption5'];
    $package_id = ($is_trial == 'official') ? $params['configoption8'] : $params['configoption7'];
    if ($params['configoption3'] == 'streamlineonly') {
        $result = streamlineonly($params, $returndata);
        return $result;
    } elseif ($params['configoption3'] == 'magdevice') {
        $result = magdevice($params, $returndata);
        return $result;
    }
}

function magdevice($params, $returndata)
{
    if ($returndata['passwordformat'] == 'onlydigits') {
        $passworddigits = isset($returndata['passworddigits']) && !empty($returndata['passworddigits']) ? $returndata['passworddigits'] : '10';
        $password = $staticpassword = XUIResellerPanel_generate_ran($passworddigits, false, "d");
    } elseif ($returndata['passwordformat'] == 'digits_alphabet') {
        $passworddigits = isset($returndata['passworddigits']) && !empty($returndata['passworddigits']) ? $returndata['passworddigits'] : '10';
        $password = $staticpassword = XUIResellerPanel_generate_ran($passworddigits);
    } else {
        $passworddigits = isset($returndata['passworddigits']) && !empty($returndata['passworddigits']) ? $returndata['passworddigits'] : '10';
        $password = $staticpassword = XUIResellerPanel_generate_ran($passworddigits);
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
                $username = XUIResellerPanel_generate_ran($usernamedigits, false, "d");
            } else {
                $username = XUIResellerPanel_generate_ran($usernamedigits);
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
    $selected_bouquets = isset($params['customfields']['Select Bouquets']) && !empty($params['customfields']['Select Bouquets']) ? trim($params['customfields']['Select Bouquets']) : $params['configoption12'];
    $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
    $is_trial = $params['configoption5'];
    $package_id = ($is_trial == 'official') ? $params['configoption8'] : $params['configoption7'];
    $count = Capsule::table('xui_paneldetails')->where('id', $params['configoption1'])->count();
    if ($count > 0) {
        $panel_details = Capsule::table('xui_paneldetails')->where('id', $params['configoption1'])->get();
        $panel_url = $panel_details[0]->panel_link;
        $username = $panel_details[0]->username;
        $password = $panel_details[0]->password;
        $response = checkcredentials($params['configoption1']);
        if ($response == "yes") {
            $MagAddress = (isset($params["customfields"][$returndata['custom_field_mag']]) && !empty($params["customfields"][$returndata['custom_field_mag']])) ? $params["customfields"][$returndata['custom_field_mag']] : "";
            $trial = ($is_trial == "trial") ? "trial=1" : "";
            $selected_bouquets = isset($params['customfields']['Select Bouquets']) && !empty($params['customfields']['Select Bouquets']) ? trim($params['customfields']['Select Bouquets']) : $params['configoption12'];
            $selected_bouquets = explode(",", $selected_bouquets);
            $bouquets_selected = "";
            if (count($selected_bouquets) > 0) {
                foreach ($selected_bouquets as $bouquet_id) {
                    $bouquets_selected .= 'bouquets_selected[]=' . $bouquet_id . '&';
                }
            }
            if (isset($bouquets_selected) && !empty($bouquets_selected)) {
                $bouquets_selected = $bouquets_selected;
            }
            $cookie_path = dirname(__FILE__) . '/Cookie.txt';
            $GetFileContent = file_get_contents($cookie_path);
            $Exploded = explode("PHPSESSID", $GetFileContent);
            $XSRF = "";
            if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
                $againEXlpode = explode("\n", $Exploded['1']);
                $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $panel_url . '/post.php?action=mag');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "$trial&mac=$MagAddress&" . $bouquets_selected . "package=$package_id&reseller_notes=$reseller_notes");
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
            $result = json_decode($result);
            if ($result->result == 1 || $result->status == 1) {
                $parameters = array(
                    'action' => 'Create line (MagDevice)',
                    'request' => $panel_url . '/post.php?action=mag',
                    'response' => json_encode($result),
                );
                customLogs($parameters);
                //get userid and next due date and update to hosting table
                $response = getXUIUserId($params['configoption1'], 'MAG', $params);
                if ($response['status'] == "success") {
                    $userid = $response['userid'];
                    $nextduedate = $response['nextduedate'];
                    $update = Capsule::table('tblhosting')
                        ->where('id', $params["serviceid"])
                        ->update(['dedicatedip' => trim($userid), 'nextduedate' => trim($nextduedate)]);
                    if ($update) {
                        return 'success';
                    } else {
                        return "Unable to create service.";
                    }
                }
                return 'success';
            } else {
                $parameters = array(
                    'action' => 'Create line (MagDevice)',
                    'request' => $panel_url . '/post.php?action=mag',
                    'response' => json_encode($result),
                );
                customLogs($parameters);
                return "Unable to create service.";
            }
        } else {
            $parameters = array(
                'action' => 'Create line (MagDevice)',
                'request' => $panel_url . '/post.php?action=mag',
                'response' => json_encode(array(
                    'result' => 'Error',
                    'message' => 'Not connected to the panel',
                )),
            );
            customLogs($parameters);
            return "Unable to create service.";
        }
    }
    return 'error';
}
function checkcredentials($panel_id)
{
    $panel_details = Capsule::table('xui_paneldetails')->where('id', $panel_id)->get();
    $panel_url = $panel_details[0]->panel_link;
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
        return "yes";
    } else {
        return "no";
    }
}
function streamlineonly($params, $returndata)
{
    $serviceid = $params['serviceid'];
    $tblproducts = Capsule::table('tblproducts')->where("id", $params['pid'])->get();
    if ($tblproducts[0]->configoption3 == "streamlineonly") {
        $LineType = $tblproducts[0]->configoption5;
        if (isset($params['customfields'][$returndata['custom_field_username']]) && !empty($params['customfields'][$returndata['custom_field_username']])) {
            $username_generated = $params['customfields'][$returndata['custom_field_username']];
        } else {
            $usernamedigits = isset($returndata['usernamedigits']) && !empty($returndata['usernamedigits']) ? $returndata['usernamedigits'] : '10';
            if ($returndata['usernameformat'] == 'onlydigits') {
                $username_generated = XUIResellerPanel_generate_ran($usernamedigits, false, "d");
            } else {
                $username_generated = XUIResellerPanel_generate_ran($usernamedigits);
            }
        }
        $params["username"] = strtolower($username_generated);
        $username = strtolower($username_generated);
    }
    $password = $staticpassword = $params['customfields']['Password'];
    if (isset($params['customfields']['Password']) && !empty($params['customfields']['Password'])) {
        $password = $staticpassword = $params['customfields']['Password'];
    } elseif ($password != "" && $username != "") {
        $password = $staticpassword = $password;
    } else {
        if ($returndata['passwordformat'] == 'onlydigits') {
            $passworddigits = isset($returndata['passworddigits']) && !empty($returndata['passworddigits']) ? $returndata['passworddigits'] : '10';
            $password = $staticpassword = XUIResellerPanel_generate_ran($passworddigits, false, "d");
        } elseif ($returndata['passwordformat'] == 'digits_alphabet') {
            $passworddigits = isset($returndata['passworddigits']) && !empty($returndata['passworddigits']) ? $returndata['passworddigits'] : '10';
            $password = $staticpassword = XUIResellerPanel_generate_ran($passworddigits);
        } else {
            $passworddigits = isset($returndata['passworddigits']) && !empty($returndata['passworddigits']) ? $returndata['passworddigits'] : '10';
            $password = $staticpassword = XUIResellerPanel_generate_ran($passworddigits);
        }
    }
    if (isset($password) && !empty($password)) {
        $command = 'EncryptPassword';
        $postData = array(
            'password2' => $password,
        );
        $results = localAPI($command, $postData);
        if ($results['result'] == 'success') {
            Capsule::table('tblhosting')
                ->where('id', $params["serviceid"])
                ->update(['password' => $results['password'], 'username' => trim($username)]);
        }
    }
    $params["username"] = trim($username);
    $params["password"] = $password;
    $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
    $serviceid = $tblhostingdetails[0]->id;
    $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
    $replacements = array(
        $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
    );
    $selected_bouquets = isset($params['customfields']['Select Bouquets']) && !empty($params['customfields']['Select Bouquets']) ? trim($params['customfields']['Select Bouquets']) : $params['configoption12'];

    $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
    $is_trial = $params['configoption5'];
    $package_id = ($is_trial == 'official') ? $params['configoption8'] : $params['configoption7'];
    $count = Capsule::table('xui_paneldetails')->where('id', $params['configoption1'])->count();
    if ($count > 0) {
        $panel_details = Capsule::table('xui_paneldetails')->where('id', $params['configoption1'])->get();
        $panel_url = $panel_details[0]->panel_link;
        $username = $panel_details[0]->username;
        $password = $panel_details[0]->password;
        $response = checkcredentials($params['configoption1']);
        if ($response == "yes") {
            $service_username = trim($params["username"]);
            $service_password = trim($params["password"]);
            $trial = ($is_trial == "trial") ? "trial=1" : "";
            $selected_bouquets = isset($params['customfields']['Select Bouquets']) && !empty($params['customfields']['Select Bouquets']) ? trim($params['customfields']['Select Bouquets']) : $params['configoption12'];
            $selected_bouquets = explode(",", $selected_bouquets);
            $bouquets_selected = "";
            if (count($selected_bouquets) > 0) {
                foreach ($selected_bouquets as $bouquet_id) {
                    $bouquets_selected .= 'bouquets_selected[]=' . $bouquet_id . '&';
                }
            }
            if (isset($bouquets_selected) && !empty($bouquets_selected)) {
                $bouquets_selected = $bouquets_selected;
            }
            $cookie_path = dirname(__FILE__) . '/Cookie.txt';
            $GetFileContent = file_get_contents($cookie_path);
            $Exploded = explode("PHPSESSID", $GetFileContent);
            $XSRF = "";
            if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
                $againEXlpode = explode("\n", $Exploded['1']);
                $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
            }


            //-------------------------------------------------------------------------------------------------------------- 
            
            // check this username exists or not
            $count = Capsule::table('tblhosting')
                ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
                ->select('tblproducts.servertype as servertype', 'tblproducts.configoption5', 'tblhosting.*')
                ->where('username', $params["username"])
                ->where('tblhosting.id', '!=', $params['serviceid'])
                ->where('tblproducts.configoption5', 'trial')
                ->where('tblproducts.servertype', 'XUIResellerPanel')
                ->count();

            if ($count > 0) {
                $tblhosting = Capsule::table('tblhosting')
                    ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
                    ->select('tblproducts.servertype as servertype', 'tblproducts.configoption5', 'tblhosting.*')
                    ->where('username', $params["username"])
                    ->where('tblhosting.id', '!=', $params['serviceid'])
                    ->where('tblproducts.configoption5', 'trial')
                    ->where('tblproducts.servertype', 'XUIResellerPanel')
                    ->get();

                foreach ($tblhosting as $value) {
                    if (isset($value->dedicatedip) && !empty($value->dedicatedip)) {
                        $dedicatedip = $value->dedicatedip;
                        //terminate trial service

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $panel_url . '/api?action=line&sub=delete&user_id=' . $dedicatedip);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
                        $headers = array();
                        $headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
                        $headers[] = 'Accept-Language: en-US,en;q=0.9';
                        $headers[] = 'Proxy-Connection: keep-alive';
                        $headers[] = 'Referer: ' . $panel_url . '/line';
                        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36';
                        $headers[] = 'X-Requested-With: XMLHttpRequest';
                        $headers[] = 'Cookie: ' . $XSRF;
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_exec($ch);
                    }
                }
            }

            //---------------------------------------------------------------------------------------------------------------------------------

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $panel_url . '/post.php?action=line');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "$trial&username=$service_username&password=$service_password&" . $bouquets_selected . "package=$package_id&reseller_notes=$reseller_notes");
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
            $result = json_decode($result);
            if ($result->result == 1 || $result->status == 1) {
                $parameters = array(
                    'action' => 'Create line (Streamline)',
                    'request' => $panel_url . '/post.php?action=line',
                    'response' => json_encode($result),
                );
                customLogs($parameters);

                //get userid and next due date and update to hosting table
                $response = getXUIUserId($params['configoption1'], 'M3U', $params);
                if ($response['status'] == "success") {
                    $userid = $response['userid'];
                    $tblhosting_data = Capsule::table('tblhosting')
                            ->where('id', $params["serviceid"])
                            ->first();
                    $billingcycle = $tblhosting_data->billingcycle;
                    $dt = date("Y-m-d");

                    $date=date_create($dt);

                    if ($billingcycle == 'Free Account') {
                        $nextduedate = $dt;
                    }elseif ($billingcycle == 'One Time') {
                        $nextduedate = $dt;
                    }elseif ($billingcycle == 'Monthly') {
                        date_add($date,date_interval_create_from_date_string("30 days"));
                        $nextduedate = date_format($date,"Y-m-d");
                    }elseif ($billingcycle == 'Semi-Annually') {
                        date_add($date,date_interval_create_from_date_string("06 month"));
                        $nextduedate = date_format($date,"Y-m-d");
                    }elseif ($billingcycle == 'Annually') {
                        date_add($date,date_interval_create_from_date_string("01 year"));
                        $nextduedate = date_format($date,"Y-m-d");
                    }else{

                        $nextduedate = $response['nextduedate'];
                    }



                    $update = Capsule::table('tblhosting')
                        ->where('id', $params["serviceid"])
                        ->update(['dedicatedip' => trim(intval($userid)), 'nextduedate' => trim($nextduedate)]);
                    if ($update) {
                        return 'success';
                    } else {
                        return "Unable to create service.";
                    }
                }
                return 'success';
            } else {
                $parameters = array(
                    'action' => 'Create line (Streamline)',
                    'request' => $panel_url . '/post.php?action=line',
                    'response' => json_encode($result),
                );
                customLogs($parameters);
                return "Unable to create service.";
            }
        } else {
            $parameters = array(
                'action' => 'Create line (Streamline)',
                'request' => $panel_url . '/post.php?action=line',
                'response' => json_encode(array(
                    'result' => 'Error',
                    'message' => 'Not connected to the panel',
                )),
            );
            customLogs($parameters);
            return "Unable to create service.";
        }
    }
    return 'error';
}

function customLogs($parameters)
{
    Capsule::table('xui_logs')->insert([
        'date' => date("Y-m-d h:i:sa"),
        'action' => $parameters['action'],
        'request' => $parameters['request'],
        'response' => $parameters['response'],
    ]);
}

function XUIResellerPanel_Renew(array $params)
{
    $xtreamConfig = Capsule::table('xui_settings')->get();
    $returndata = array();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $returndata[$config->setting] = $config->value;
        }
    }
    if ($params['configoption3'] == 'streamlineonly') {
        $return = extendLineM3U($params, $returndata);
        return $return;
    } elseif ($params['configoption3'] == 'magdevice') {
        $return = extendLineMAG($params, $returndata);
        return $return;
    }
    return 'error';
}
function extendLineMAG($params, $returndata)
{
    $serviceid = $params['serviceid'];
    $tblhosting = Capsule::table('tblhosting')->where('id', $serviceid)->select('dedicatedip')->get();
    $response = checkcredentials($params['configoption1']);
    $panel_details = Capsule::table('xui_paneldetails')->where('id', $params['configoption1'])->get();
    $panel_url = $panel_details[0]->panel_link;
    if ($response == "yes") {
        $is_trial = $params['configoption5'];
        $trial = ($is_trial == "trial") ? "trial=1" : "";
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        );
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $selected_bouquets = isset($params['customfields']['Select Bouquets']) && !empty($params['customfields']['Select Bouquets']) ? trim($params['customfields']['Select Bouquets']) : $params['configoption12'];
        $selected_bouquets = explode(",", $selected_bouquets);
        $bouquets_selected = "";
        if (count($selected_bouquets) > 0) {
            foreach ($selected_bouquets as $bouquet_id) {
                $bouquets_selected .= 'bouquets_selected[]=' . $bouquet_id . '&';
            }
        }
        if (isset($bouquets_selected) && !empty($bouquets_selected)) {
            $bouquets_selected = $bouquets_selected;
        }
        $userid = $tblhosting[0]->dedicatedip;
        $MagAddress = (isset($params["customfields"][$returndata['custom_field_mag']]) && !empty($params["customfields"][$returndata['custom_field_mag']])) ? $params["customfields"][$returndata['custom_field_mag']] : "";
        if (isset($userid) && !empty($userid)) {
            $is_trial = $params['configoption5'];
            $package_id = ($is_trial == 'official') ? $params['configoption8'] : $params['configoption7'];
            // request to extend line for streamlineonly
            $cookie_path = dirname(__FILE__) . '/Cookie.txt';
            $GetFileContent = file_get_contents($cookie_path);
            $Exploded = explode("PHPSESSID", $GetFileContent);
            $XSRF = "";
            if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
                $againEXlpode = explode("\n", $Exploded['1']);
                $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $panel_url . '/post.php?action=mag');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "edit=$userid&mac=$MagAddress&" . $bouquets_selected . "package=$package_id&reseller_notes=$reseller_notes");
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
            $result = json_decode($result);
            if ($result->result == 1 || $result->status == 1) {
                $parameters = array(
                    'action' => 'Renew line (MagDevice)',
                    'request' => $panel_url . '/post.php?action=mag',
                    'response' => json_encode($result),
                );
                customLogs($parameters);
                return 'success';
            } else {
                $parameters = array(
                    'action' => 'Renew line (MagDevice)',
                    'request' => $panel_url . '/post.php?action=mag',
                    'response' => json_encode($result),
                );
                customLogs($parameters);
                return "Unable to renew service.";
            }
        } else {
            $parameters = array(
                'action' => 'Renew line (MagDevice)',
                'request' => $panel_url . '/post.php?action=mag',
                'response' => json_encode(array(
                    'result' => 'Error',
                    'message' => 'User id not found!',
                )),
            );
            customLogs($parameters);
            return "Unable to renew service.";
        }
    } else {
        $parameters = array(
            'action' => 'Renew line (MagDevice)',
            'request' => $panel_url . '/post.php?action=mag',
            'response' => json_encode(array(
                'result' => 'Error',
                'message' => 'Not connected to the panel',
            )),
        );
        customLogs($parameters);
    }
}
function extendLineM3U($params, $returndata)
{
    $serviceid = $params['serviceid'];
    $tblhosting = Capsule::table('tblhosting')->where('id', $serviceid)->select('dedicatedip')->get();
    $response = checkcredentials($params['configoption1']);
    $panel_details = Capsule::table('xui_paneldetails')->where('id', $params['configoption1'])->get();
    $panel_url = $panel_details[0]->panel_link;
    if ($response == "yes") {
        $is_trial = $params['configoption5'];
        $trial = ($is_trial == "trial") ? "trial=1" : "";
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
        $replacements = array(
            $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
        );
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $selected_bouquets = isset($params['customfields']['Select Bouquets']) && !empty($params['customfields']['Select Bouquets']) ? trim($params['customfields']['Select Bouquets']) : $params['configoption12'];
        $selected_bouquets = explode(",", $selected_bouquets);
        $bouquets_selected = "";
        if (count($selected_bouquets) > 0) {
            foreach ($selected_bouquets as $bouquet_id) {
                $bouquets_selected .= 'bouquets_selected[]=' . $bouquet_id . '&';
            }
        }
        if (isset($bouquets_selected) && !empty($bouquets_selected)) {
            $bouquets_selected = $bouquets_selected;
        }
        $service_username = trim($params["username"]);
        $service_password = trim($params["password"]);
        $userid = $tblhosting[0]->dedicatedip;
        if (isset($userid) && !empty($userid)) {
            $is_trial = $params['configoption5'];
            $package_id = ($is_trial == 'official') ? $params['configoption8'] : $params['configoption7'];
            // request to extend line for streamlineonly
            $cookie_path = dirname(__FILE__) . '/Cookie.txt';
            $GetFileContent = file_get_contents($cookie_path);
            $Exploded = explode("PHPSESSID", $GetFileContent);
            $XSRF = "";
            if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
                $againEXlpode = explode("\n", $Exploded['1']);
                $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $panel_url . '/post.php?action=line');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "edit=$userid&username=$service_username&password=$service_password&" . $bouquets_selected . "package=$package_id&reseller_notes=$reseller_notes");
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
            $result = json_decode($result);
            if ($result->result == 1 || $result->status == 1) {
                $parameters = array(
                    'action' => 'Renew line (Streamline)',
                    'request' => $panel_url . '/post.php?action=line',
                    'response' => json_encode($result),
                );
                customLogs($parameters);
                return 'success';
            } else {
                $parameters = array(
                    'action' => 'Renew line (Streamline)',
                    'request' => $panel_url . '/post.php?action=line',
                    'response' => json_encode($result),
                );
                customLogs($parameters);
                return "Unable to renew service.";
            }
        } else {
            $parameters = array(
                'action' => 'Renew line (Streamline)',
                'request' => $panel_url . '/post.php?action=line',
                'response' => json_encode(array(
                    'result' => 'Error',
                    'message' => 'User id not found!',
                )),
            );
            customLogs($parameters);
            return 'Unable to perfom renew action.';
        }
    } else {
        $parameters = array(
            'action' => 'Renew line (Streamline)',
            'request' => $panel_url . '/post.php?action=line',
            'response' => json_encode(array(
                'result' => 'Error',
                'message' => 'Not connected to the panel',
            )),
        );
        customLogs($parameters);
    }
}

function XUIResellerPanel_ChangePackage(array $params)
{
    $xtreamConfig = Capsule::table('xui_settings')->get();
    $returndata = array();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $returndata[$config->setting] = $config->value;
        }
    }
    if ($params['configoption3'] == 'streamlineonly') {
        $return = extendLineM3U($params, $returndata);
        return $return;
    } elseif ($params['configoption3'] == 'magdevice') {
        $return = extendLineMAG($params, $returndata);
        return $return;
    }
    return 'error';
}
function WSxtreamUI_millisecondssss()
{
    $mt = explode(' ', microtime());
    return ((int) $mt[1]) * 1000 + ((int) round($mt[0] * 1000));
}
function getXUIUserId($panel_id, $type, $params)
{
    $xtreamConfig = Capsule::table('xui_settings')->get();
    $returndata = array();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $returndata[$config->setting] = $config->value;
        }
    }
    $panel_details = Capsule::table('xui_paneldetails')->where('id', $panel_id)->get();
    $panel_url = $panel_details[0]->panel_link;
    $cookie_path = dirname(__FILE__) . '/Cookie.txt';
    $GetFileContent = file_get_contents($cookie_path);
    $Exploded = explode("PHPSESSID", $GetFileContent);
    $XSRF = "";
    if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
        $againEXlpode = explode("\n", $Exploded['1']);
        $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
    }
    if ($type == "MAG") {
        $Searchfor = "mags";
        $MagAddress = (isset($params["customfields"][$returndata['custom_field_mag']]) && !empty($params["customfields"][$returndata['custom_field_mag']])) ? $params["customfields"][$returndata['custom_field_mag']] : "";
        $usernameTosearch =  $MagAddress;
    }
    if ($type == "M3U") {
        $Searchfor = "lines";
        $usernameTosearch = $params['username'];
    }

    $message = array();
    $nUrl = $panel_url . '/table?';
    $NewPostData = array();
    $NewPostData["draw"] = 1;
    for ($i = 0; $i <= 11; $i++) {
        $NewPostData['columns[' . $i . '][data]'] = $i;
        $NewPostData['columns[' . $i . '][name]'] = "";
        $NewPostData['columns[' . $i . '][searchable]'] = 'true';
        $NewPostData['columns[' . $i . '][orderable]'] = 'true';
        $NewPostData['columns[' . $i . '][search][value]'] = "";
        $NewPostData['columns[' . $i . '][search][regex]'] = "";
    }
    $NewPostData['order[0][column]'] = 2;
    $NewPostData['order[0][dir]'] = "desc";
    $NewPostData['start'] = 0;
    $NewPostData['length'] = 25;
    $NewPostData['search[value]'] = $usernameTosearch;
    $NewPostData['search[regex]'] = 'false';
    $NewPostData['id'] = $Searchfor;
    $NewPostData['filter'] = "";
    $NewPostData['reseller'] = "";
    $NewPostData['_'] = WSxtreamUI_millisecondssss();
    $FinalData = $nUrl . http_build_query($NewPostData);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $FinalData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    $headers = array();
    $headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    $headers[] = 'Cookie: ' . $XSRF;
    $headers[] = 'Proxy-Connection: keep-alive';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36';
    $headers[] = 'X-Requested-With: XMLHttpRequest';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    $dom = new DOMDocument();
    @$dom->loadHTML($result);
    $textContent = $dom->textContent;
    $textContent = json_decode($textContent);
    if ($textContent->recordsTotal > 0) {
        $data = $textContent->data;
        $userid = $data[0][0];
        if ($type == "M3U") {
            $next_due_date = date("Y-m-d", strtotime($data[0][9]));
        }
        if ($type == "MAG") {
            $next_due_date = date("Y-m-d", strtotime($data[0][8]));
        }
        return array(
            'status' => 'success',
            'userid' =>  $userid,
            'nextduedate' => $next_due_date,
        );
    } else {
        return 'error';
    }
}
function XUIResellerPanel_SuspendAccount(array $params)
{
    $serviceid = $params['serviceid'];
    $tblhosting = Capsule::table('tblhosting')->where('id', $serviceid)->select('dedicatedip')->get();
    $response = checkcredentials($params['configoption1']);
    if ($response == "yes") {
        $xtreamConfig = Capsule::table('xui_settings')->get();
        $returndata = array();
        if (isset($xtreamConfig) && !empty($xtreamConfig)) {
            foreach ($xtreamConfig as $config) {
                $returndata[$config->setting] = $config->value;
            }
        }
        $cookie_path = dirname(__FILE__) . '/Cookie.txt';
        $GetFileContent = file_get_contents($cookie_path);
        $Exploded = explode("PHPSESSID", $GetFileContent);
        $XSRF = "";
        if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
            $againEXlpode = explode("\n", $Exploded['1']);
            $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
        }
        $userid = $tblhosting[0]->dedicatedip;
        if ($params['configoption3'] == 'streamlineonly') {
            if (isset($userid) && !empty($userid)) {
                $res = diableLine($params['configoption1'], $userid, 'M3U');
                if ($res == 1 || $res == true) {
                    return true;
                } else {
                    return 'Unable to perfom suspend action.';
                }
            } else {
                return 'Unable to perfom suspend action.';
            }
        }

        if ($params['configoption3'] == 'magdevice') {
            if (isset($userid) && !empty($userid)) {
                $res = diableLine($params['configoption1'], $userid, 'MAG');
                if ($res == 1 || $res == true) {
                    return true;
                } else {
                    return 'Unable to perfom suspend action.';
                }
            } else {
                return 'Unable to perfom suspend action.';
            }
        }
    } else {
        return 'Unable to perfom suspend action.';
    }
}
function diableLine($panel_id, $userid, $type)
{
    if ($type == "M3U") {
        $action = '/api?action=line&sub=disable&user_id=' . $userid;
    }
    if ($type == "MAG") {
        $action = '/api?action=mag&sub=disable&mag_id=' . $userid;
    }
    $panel_details = Capsule::table('xui_paneldetails')->where('id', $panel_id)->get();
    $panel_url = $panel_details[0]->panel_link;
    $cookie_path = dirname(__FILE__) . '/Cookie.txt';
    $GetFileContent = file_get_contents($cookie_path);
    $Exploded = explode("PHPSESSID", $GetFileContent);
    $XSRF = "";
    if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
        $againEXlpode = explode("\n", $Exploded['1']);
        $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $panel_url . $action);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    $headers = array();
    $headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    $headers[] = 'Proxy-Connection: keep-alive';
    $headers[] = 'Referer: ' . $panel_url . '/line';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36';
    $headers[] = 'X-Requested-With: XMLHttpRequest';
    $headers[] = 'Cookie: ' . $XSRF;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    $res = json_decode($result);
    if ($res->result == 1 || $res->result == "success") {
        if ($type == "MAG") {
            $parameters = array(
                'action' => 'Suspend line (Mag Device)',
                'request' => $panel_url . $action,
                'response' => json_encode($result),
            );
            customLogs($parameters);
        } else {
            $parameters = array(
                'action' => 'Suspend line (Streamline)',
                'request' => $panel_url . $action,
                'response' => json_encode($result),
            );
            customLogs($parameters);
        }
        return true;
    } else {
        if ($type == "MAG") {
            $parameters = array(
                'action' => 'Suspend line (Mag Device)',
                'request' => $panel_url . $action,
                'response' => json_encode($result),
            );
            customLogs($parameters);
        } else {
            $parameters = array(
                'action' => 'Suspend line (Streamline)',
                'request' => $panel_url . $action,
                'response' => json_encode($result),
            );
            customLogs($parameters);
        }
        return false;
    }
}
function enableLine($panel_id, $userid, $type)
{
    if ($type == "M3U") {
        $action = '/api?action=line&sub=enable&user_id=' . $userid;
    }
    if ($type == "MAG") {
        $action = '/api?action=mag&sub=enable&mag_id=' . $userid;
    }
    $panel_details = Capsule::table('xui_paneldetails')->where('id', $panel_id)->get();
    $panel_url = $panel_details[0]->panel_link;
    $cookie_path = dirname(__FILE__) . '/Cookie.txt';
    $GetFileContent = file_get_contents($cookie_path);
    $Exploded = explode("PHPSESSID", $GetFileContent);
    $XSRF = "";
    if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
        $againEXlpode = explode("\n", $Exploded['1']);
        $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $panel_url . $action);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    $headers = array();
    $headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    $headers[] = 'Proxy-Connection: keep-alive';
    $headers[] = 'Referer: ' . $panel_url . '/line';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36';
    $headers[] = 'X-Requested-With: XMLHttpRequest';
    $headers[] = 'Cookie: ' . $XSRF;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    $res = json_decode($result);
    if ($res->result == 1 || $res->result == "success") {
        if ($type == "MAG") {
            $parameters = array(
                'action' => 'Unsuspend line (Mag Device)',
                'request' => $panel_url . $action,
                'response' => json_encode($result),
            );
            customLogs($parameters);
        } else {
            $parameters = array(
                'action' => 'Unsuspend line (Streamline)',
                'request' => $panel_url . $action,
                'response' => json_encode($result),
            );
            customLogs($parameters);
        }
        return true;
    } else {
        if ($type == "MAG") {
            $parameters = array(
                'action' => 'Unsuspend line (Mag Device)',
                'request' => $panel_url . $action,
                'response' => json_encode($result),
            );
            customLogs($parameters);
        } else {
            $parameters = array(
                'action' => 'Unsuspend line (Streamline)',
                'request' => $panel_url . $action,
                'response' => json_encode($result),
            );
            customLogs($parameters);
        }
        return false;
    }
}

function deleteLine($panel_id, $userid, $type)
{
    if ($type == "M3U") {
        $action = '/api?action=line&sub=delete&user_id=' . $userid;
    }
    if ($type == "MAG") {
        $action = '/api?action=mag&sub=delete&mag_id=' . $userid;
    }
    $panel_details = Capsule::table('xui_paneldetails')->where('id', $panel_id)->get();
    $panel_url = $panel_details[0]->panel_link;
    $cookie_path = dirname(__FILE__) . '/Cookie.txt';
    $GetFileContent = file_get_contents($cookie_path);
    $Exploded = explode("PHPSESSID", $GetFileContent);
    $XSRF = "";
    if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
        $againEXlpode = explode("\n", $Exploded['1']);
        $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $panel_url . $action);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    $headers = array();
    $headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    $headers[] = 'Proxy-Connection: keep-alive';
    $headers[] = 'Referer: ' . $panel_url . '/line';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36';
    $headers[] = 'X-Requested-With: XMLHttpRequest';
    $headers[] = 'Cookie: ' . $XSRF;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    $res = json_decode($result);
    if ($res->result == 1 || $res->result == "success") {
        if ($type == "MAG") {
            $parameters = array(
                'action' => 'Terminate line (Mag Device)',
                'request' => $panel_url . $action,
                'response' => json_encode($result),
            );
            customLogs($parameters);
        } else {
            $parameters = array(
                'action' => 'Terminate line (Streamline)',
                'request' => $panel_url . $action,
                'response' => json_encode($result),
            );
            customLogs($parameters);
        }
        return true;
    } else {
        if ($type == "MAG") {
            $parameters = array(
                'action' => 'Terminate line (Mag Device)',
                'request' => $panel_url . $action,
                'response' => json_encode($result),
            );
            customLogs($parameters);
        } else {
            $parameters = array(
                'action' => 'Terminate line (Streamline)',
                'request' => $panel_url . $action,
                'response' => json_encode($result),
            );
            customLogs($parameters);
        }
        return false;
    }
}
function XUIResellerPanel_UnsuspendAccount(array $params)
{
    $serviceid = $params['serviceid'];
    $tblhosting = Capsule::table('tblhosting')->where('id', $serviceid)->select('dedicatedip')->get();
    $response = checkcredentials($params['configoption1']);
    if ($response == "yes") {
        $xtreamConfig = Capsule::table('xui_settings')->get();
        $returndata = array();
        if (isset($xtreamConfig) && !empty($xtreamConfig)) {
            foreach ($xtreamConfig as $config) {
                $returndata[$config->setting] = $config->value;
            }
        }
        $cookie_path = dirname(__FILE__) . '/Cookie.txt';
        $GetFileContent = file_get_contents($cookie_path);
        $Exploded = explode("PHPSESSID", $GetFileContent);
        $XSRF = "";
        if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
            $againEXlpode = explode("\n", $Exploded['1']);
            $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
        }
        $userid = $tblhosting[0]->dedicatedip;
        if ($params['configoption3'] == 'streamlineonly') {
            if (isset($userid) && !empty($userid)) {
                $res = enableLine($params['configoption1'], $userid, 'M3U');
                if ($res == 1 || $res == true) {
                    return true;
                } else {
                    return 'Unable to perfom unsuspend action.';
                }
            } else {
                return 'Unable to perfom unsuspend action.';
            }
        }

        if ($params['configoption3'] == 'magdevice') {
            if (isset($userid) && !empty($userid)) {
                $res = enableLine($params['configoption1'], $userid, 'MAG');
                if ($res == 1 || $res == true) {
                    return true;
                } else {
                    return 'Unable to perfom unsuspend action.';
                }
            } else {
                return 'Unable to perfom unsuspend action.';
            }
        }
    } else {
        return 'Unable to perfom unsuspend action.';
    }
}

function XUIResellerPanel_TerminateAccount(array $params)
{
    $serviceid = $params['serviceid'];
    $tblhosting = Capsule::table('tblhosting')->where('id', $serviceid)->select('dedicatedip')->get();
    $response = checkcredentials($params['configoption1']);
    if ($response == "yes") {
        $xtreamConfig = Capsule::table('xui_settings')->get();
        $returndata = array();
        if (isset($xtreamConfig) && !empty($xtreamConfig)) {
            foreach ($xtreamConfig as $config) {
                $returndata[$config->setting] = $config->value;
            }
        }
        $cookie_path = dirname(__FILE__) . '/Cookie.txt';
        $GetFileContent = file_get_contents($cookie_path);
        $Exploded = explode("PHPSESSID", $GetFileContent);
        $XSRF = "";
        if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
            $againEXlpode = explode("\n", $Exploded['1']);
            $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
        }
        $userid = $tblhosting[0]->dedicatedip;
        if ($params['configoption3'] == 'streamlineonly') {
            if (isset($userid) && !empty($userid)) {
                $res = deleteLine($params['configoption1'], $userid, 'M3U');
                if ($res == 1 || $res == true) {
                    return true;
                } else {
                    return 'Unable to perfom terminate action.';
                }
            } else {
                return 'Unable to perfom terminate action.';
            }
        }

        if ($params['configoption3'] == 'magdevice') {
            if (isset($userid) && !empty($userid)) {
                $res = deleteLine($params['configoption1'], $userid, 'MAG');
                if ($res == 1 || $res == true) {
                    return true;
                } else {
                    return 'Unable to perfom terminate action.';
                }
            } else {
                return 'Unable to perfom terminate action.';
            }
        }
    } else {
        return 'Unable to perfom terminate action.';
    }
}
function streamline_clientarea($params, $REQUEST)
{
    $serviceid = $params['serviceid'];
    $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $serviceid)->get();

    $xtreamConfig = Capsule::table('xui_settings')->get();
    $returndata = array();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $returndata[$config->setting] = $config->value;
        }
    }
    $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
    $replacements = array(
        $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
    );
    $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);

    $nextduedate = $tblhostingdetails[0]->nextduedate;
    $userid = $tblhostingdetails[0]->dedicatedip;
    //---------------------------------------------------------------------------------------------------------------------------------
    if ($REQUEST['customAction'] == "update_pass") {
        $serviceid = $REQUEST['serviceid'];
        $password = $REQUEST['pass_word'];
        $response = checkcredentials($params['configoption1']);
        if ($response == "yes") {
            $is_trial = $params['configoption5'];
            $panel_details = Capsule::table('xui_paneldetails')->where('id', $params['configoption1'])->get();
            $panel_url = $panel_details[0]->panel_link;
            if (isset($userid) && !empty($userid)) {
                $savedBouquets = $REQUEST['clientSelectedBouquets'];
                // update selected bouquets in the custom fields
                $tblcustomfields = Capsule::table('tblcustomfields')->where('fieldname', 'Select Bouquets')->where('relid', $params['packageid'])->select('id')->get();
                $fieldid =  $tblcustomfields[0]->id;
                Capsule::table('tblcustomfieldsvalues')->where('relid', $serviceid)->where('fieldid', $fieldid)->update(['value' => $savedBouquets]);
                $cookie_path = dirname(__FILE__) . '/Cookie.txt';
                $GetFileContent = file_get_contents($cookie_path);
                $Exploded = explode("PHPSESSID", $GetFileContent);
                $XSRF = "";
                if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
                    $againEXlpode = explode("\n", $Exploded['1']);
                    $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
                }
                $selected_bouquets = explode(",", $savedBouquets);
                $bouquets_selected = "";
                if (count($selected_bouquets) > 0) {
                    foreach ($selected_bouquets as $bouquet_id) {
                        $bouquets_selected .= 'bouquets_selected[]=' . $bouquet_id . '&';
                    }
                }
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $panel_url . '/post.php?action=line');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "edit=$userid&password=$password&" . $bouquets_selected . "&reseller_notes=$reseller_notes");
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
                $result = json_decode($result);
                if ($result->result == 1 || $result->status == 1) {
                    //encrypt hosting pass 
                    $command = 'EncryptPassword';
                    $postData = array(
                        'password2' => $password,
                    );
                    $results = localAPI($command, $postData);
                    if ($results['result'] == 'success') {
                        $updated = Capsule::table('tblhosting')->where('id', $serviceid)->update(['password' => $results['password']]);
                        if ($updated) {
                            header("location: clientarea.php?action=productdetails&id=" . $serviceid);
                            exit;
                        }
                    }
                }
            } else {
                $status = "Unable to update Password.";
            }
        }
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    $server = Capsule::table('xui_paneldetails')->where('id', $params['configoption1'])->get();
    if ($userid) {
        $templateFile = 'templates/overview.tpl';
    } else {
        $error = 'User Not found!';
        $templateFile = 'templates/error.tpl';
    }
    $is_trial = $params['configoption5'];
    $applink = Capsule::table('xtreamui_applinks')->count();
    if ($applink > 0) {
        $applink = Capsule::table('xtreamui_applinks')->get();
        foreach ($applink as $app) {
            // $appdata[][$app->appfor] = $app->applink;
            $appdata[] = array('applink' => $app->applink, 'name' => $app->appname, 'apptype' => $app->appfor);
        }
    }
    $xtreamConfig = Capsule::table('xui_settings')->get();
    $return = array();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $return[$config->setting] = $config->value;
        }
    }
    $m3uurl = $server[0]->m3uurl;
    $mag_portal = $server[0]->mag_portal;
    $watchstrmurl = $server[0]->watchstrmurl;
    $variabledata = array(
        'appdata' => $appdata,
        'iptv_username' => $params['username'],
        'iptv_password' => $params['password'],
        'response' => 'success',
        'lang' => $return,
        'is_trial' => ($is_trial == "trial") ? 1 : 0,
        'm3ulink' => $params['configoption4'],
        'watchstream' => $params['configoption6'],
        'outputfirst' => 'ts',
        'mag_portal' => $mag_portal,
        'm3uurl' => $m3uurl,
        'watchstrmurl' => $watchstrmurl,
        'usefulErrorHelper' => isset($error) && !empty($error) ? $error : '',
        'status' => $params['status'],
        'exp_date' => ((empty($nextduedate)) ? 'Unlimited' : date('Y-m-d H:i:s', strtotime($nextduedate)))
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
    $returndata = array('templateFile' => $templateFile, 'variabledata' => $variabledata);
    return $returndata;
}

function magdevice_cliebtarea($params, $REQUEST)
{
    $serviceid = $params['serviceid'];
    $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $serviceid)->get();
    $config = Capsule::table('xui_settings')->get();
    foreach ($config as $value) {
        $row[$value->setting] = $value->value;
    }
    $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
    $replacements = array(
        $params["serviceid"], $params["userid"], $params["clientsdetails"]["fullname"], $params["clientsdetails"]["email"], $params["clientsdetails"]["phonenumber"]
    );
    $reseller_notes = str_replace($patterns, $replacements, $row['common_identifier']);
    //---------------------------------------------------------------------------------------------------------------------------------
    if ($REQUEST['customAction'] == "changeBouquets") {
        $existingMac = $REQUEST['newMAC'];
        $panel_details = Capsule::table('xui_paneldetails')->where('id', $params['configoption1'])->get();
        $panel_url = $panel_details[0]->panel_link;
        $savedBouquets = $REQUEST['clientSelectedBouquets'];
        // update selected bouquets in the custom fields
        $tblcustomfields = Capsule::table('tblcustomfields')->where('fieldname', 'Select Bouquets')->where('relid', $params['packageid'])->select('id')->get();
        $fieldid =  $tblcustomfields[0]->id;
        Capsule::table('tblcustomfieldsvalues')->where('relid', $serviceid)->where('fieldid', $fieldid)->update(['value' => $savedBouquets]);
        $cookie_path = dirname(__FILE__) . '/Cookie.txt';
        $GetFileContent = file_get_contents($cookie_path);
        $Exploded = explode("PHPSESSID", $GetFileContent);
        $XSRF = "";
        if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
            $againEXlpode = explode("\n", $Exploded['1']);
            $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
        }
        //request to check mag address 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $panel_url . '/table?draw=1&id=mags');
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
                $Exploded =  explode('>', $values[2]);
                $Exploded =  explode('<', $Exploded[1]);
                $arry[] = trim($Exploded[0]);
            }
            if (in_array($existingMac, $arry)) {
                $macStatus = 1; // MAC address exists
            } else {
                $macStatus = 0; // MAC address does not exists
            }
        }
        if ($macStatus == 1) {
            $selected_bouquets = explode(",", $savedBouquets);
            $bouquets_selected = "";
            if (count($selected_bouquets) > 0) {
                foreach ($selected_bouquets as $bouquet_id) {
                    $bouquets_selected .= 'bouquets_selected[]=' . $bouquet_id . '&';
                }
            }
            $userid = $tblhostingdetails[0]->dedicatedip;
            if (isset($userid) && !empty($userid)) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $panel_url . '/post.php?action=mag');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "edit=$userid&mac=$existingMac&" . $bouquets_selected . "reseller_notes=$reseller_notes");
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
                $result = json_decode($result);
                if ($result->result == 1 || $result->status == 1) {
                    $tblcustomfields = Capsule::table('tblcustomfields')->where('fieldname', $row['custom_field_mag'])->where('relid', $params['packageid'])->select('id')->get();
                    $fieldid =  $tblcustomfields[0]->id;
                    $updated = Capsule::table('tblcustomfieldsvalues')->where('relid', $serviceid)->where('fieldid', $fieldid)->update(['value' => $existingMac]);
                    if ($updated) {
                        header("location: clientarea.php?action=productdetails&id=" . $serviceid);
                        exit;
                    }
                }
            }
        }
    }
    if ($REQUEST['customAction'] == "changeMAG") {
        $newMAC = $REQUEST['newMAC'];
        $userid = $tblhostingdetails[0]->dedicatedip;
        $response = checkcredentials($params['configoption1']);
        if ($response == "yes") {
            $is_trial = $params['configoption5'];
            $panel_details = Capsule::table('xui_paneldetails')->where('id', $params['configoption1'])->get();
            $panel_url = $panel_details[0]->panel_link;
            if (isset($userid) && !empty($userid)) {
                $savedBouquets = $REQUEST['clientSelectedBouquets'];
                // update selected bouquets in the custom fields
                $tblcustomfields = Capsule::table('tblcustomfields')->where('fieldname', 'Select Bouquets')->where('relid', $params['packageid'])->select('id')->get();
                $fieldid =  $tblcustomfields[0]->id;
                Capsule::table('tblcustomfieldsvalues')->where('relid', $serviceid)->where('fieldid', $fieldid)->update(['value' => $savedBouquets]);
                $cookie_path = dirname(__FILE__) . '/Cookie.txt';
                $GetFileContent = file_get_contents($cookie_path);
                $Exploded = explode("PHPSESSID", $GetFileContent);
                $XSRF = "";
                if (!empty($Exploded) && isset($Exploded['1']) && !empty(trim($Exploded['1']))) {
                    $againEXlpode = explode("\n", $Exploded['1']);
                    $XSRF = "PHPSESSID=" . trim($againEXlpode['0']);
                }

                //request to check mag address 
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $panel_url . '/table?draw=1&id=mags');
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
                        $Exploded =  explode('>', $values[2]);
                        $Exploded =  explode('<', $Exploded[1]);
                        $arry[] = trim($Exploded[0]);
                    }
                    if (in_array($newMAC, $arry)) {
                        $macStatus = 0; // MAC address already exists
                    } else {
                        $macStatus = 1; // MAC address is available
                    }
                }
                if ($macStatus == 1) {
                    $selected_bouquets = explode(",", $savedBouquets);
                    $bouquets_selected = "";
                    if (count($selected_bouquets) > 0) {
                        foreach ($selected_bouquets as $bouquet_id) {
                            $bouquets_selected .= 'bouquets_selected[]=' . $bouquet_id . '&';
                        }
                    }
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $panel_url . '/post.php?action=mag');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "edit=$userid&mac=$newMAC&" . $bouquets_selected . "reseller_notes=$reseller_notes");
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
                    $result = json_decode($result);
                    if ($result->result == 1 || $result->status == 1) {
                        $tblcustomfields = Capsule::table('tblcustomfields')->where('fieldname', $row['custom_field_mag'])->where('relid', $params['packageid'])->select('id')->get();
                        $fieldid =  $tblcustomfields[0]->id;
                        $updated = Capsule::table('tblcustomfieldsvalues')->where('relid', $serviceid)->where('fieldid', $fieldid)->update(['value' => $newMAC]);
                        if ($updated) {
                            header("location: clientarea.php?action=productdetails&id=" . $serviceid);
                            exit;
                        }
                    } else {
                        $macUpdated = 0;
                        $message = "Unable to update Mac Address.";
                    }
                } else {
                    $macUpdated = 0;
                    $message = "Mac Address already exists.";
                }
            } else {
                $macUpdated = 0;
                $message = "Unable to update Mac Address.";
            }
        }
    } else {
        $macUpdated = 1;
    }
    $return = array();
    $xtreamConfig = Capsule::table('xui_settings')->get();
    if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        foreach ($xtreamConfig as $config) {
            $return[$config->setting] = $config->value;
        }
    }
    $responsedata = XUIONEMAGDetails($params, $return, $macUpdated, $message);
    $templateFile = $responsedata['templateFile'];
    $variabledata = $responsedata['variabledata'];
    $returndata = array('templateFile' => $templateFile, 'variabledata' => $variabledata,);
    return $returndata;
}

function XUIResellerPanel_ClientArea(array $params)
{
    if ($params['status'] == 'Active') {
        $xtreamConfig = Capsule::table('xui_settings')->get();
        $returndata = array();
        if (isset($xtreamConfig) && !empty($xtreamConfig)) {
            foreach ($xtreamConfig as $config) {
                $returndata[$config->setting] = $config->value;
            }
        }
        $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $params["serviceid"])->get();
        if ($params['configoption3'] == 'streamlineonly') {
            $returndata = streamline_clientarea($params, $_REQUEST);
            $templateFile = $returndata['templateFile'];
            $variabledata = $returndata['variabledata'];
        } elseif ($params['configoption3'] == 'magdevice') {
            $returndata = magdevice_cliebtarea($params, $_REQUEST);
            $templateFile = $returndata['templateFile'];
            $variabledata = $returndata['variabledata'];
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

function XUIONEMAGDetails($params, $returndata, $status, $message)
{
    $serviceid = $params['serviceid'];
    $tblhostingdetails = Capsule::table('tblhosting')->where('id', '=', $serviceid)->get();
    $nextduedate = $tblhostingdetails[0]->nextduedate;
    $server = Capsule::table('xui_paneldetails')->where('id', $params['configoption1'])->get();
    $responsedata = array();
    $magportalurl = $server[0]->portal_url;
    $MagAddress = (isset($params["customfields"][$returndata['custom_field_mag']]) && !empty($params["customfields"][$returndata['custom_field_mag']])) ? $params["customfields"][$returndata['custom_field_mag']] : "";
    if ($MagAddress) {
        $responsedata['templateFile'] = 'templates/magtemplate.tpl';
        $mag_portal = $server[0]->mag_portal;
        //check upgrade
        $checkupgrade = Capsule::table('tblhosting')
            ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
            ->join('tblproduct_upgrade_products', 'tblproducts.id', '=', 'tblproduct_upgrade_products.product_id')
            ->select('tblproduct_upgrade_products.*')
            ->where('tblhosting.id', $params['serviceid'])
            ->count();
        $checkupgrade = ($checkupgrade > 0) ? '1' : '0';
        $responsedata['variabledata'] = array(
            'mag' => $MagAddress,
            'mag_portal' => $mag_portal,
            'response' => 'success',
            'magdevice' => 'yes',
            'message' => 'success',
            'serviceid' => $params['serviceid'],
            'lang' => $returndata,
            'macUpdatedStatus' => $status,
            'macUpdatedMessage' => $message,
            'status' => $params['status'],
            'exp_date' => ((empty($nextduedate)) ? 'Unlimited' : date('Y-m-d H:i:s', strtotime($nextduedate))),
            'checkupgrade' => $checkupgrade,
        );
        return $responsedata;
    } else {
        $responsedata['templateFile'] = 'templates/error.tpl';
        $responsedata['variabledata'] = array('usefulErrorHelper' => "FAILED - No Record found!");
        return $responsedata;
    }
    $responsedata['templateFile'] = 'templates/magtemplate.tpl';
    $responsedata['variabledata'] = array('usefulErrorHelper' => 'No Response From API. Please contact Administrator');
    return $responsedata;
}

function XUIONEengDetails($params, $returndata, $response, $result)
{
}

function XUIResellerPanel_generate_ran($length = 9, $add_dashes = false, $available_sets = 'lud')
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
