<?php

use WHMCS\Database\Capsule;

include_once 'functions.php';
add_hook('AdminAreaFooterOutput', 1, function ($vars) {
    if ($vars['filename'] == 'configproducts') {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $product_id = $_GET['id'];
            $product = Capsule::table('tblproducts')->where('id', $product_id)->first();
            if ($product->servertype == "XUIResellerPanel") {
                return moduleconfiguration_xuione();
            }
        }
    }
});


add_hook('InvoicePaid', 1, function($vars) {
});


add_hook('ShoppingCartValidateProductUpdate', 1, function ($vars) {
    foreach ($vars['customfield'] as $customfieldId => $value) {
        $tblcustomfields = Capsule::table('tblcustomfields')->where("id", $customfieldId)->get();
        $tblproducts = Capsule::table('tblproducts')->where("id", $tblcustomfields[0]->relid)->first();
        $servertype = $tblproducts->servertype;
        if (trim($servertype) == "XUIResellerPanel") {
            $config = Capsule::table('xui_settings')->get();
            foreach ($config as $value) {
                $row[$value->setting] = $value->value;
            }
            if ($tblproducts->configoption3 == "magdevice") {
                //mag part
                $tblcustomfieldsData = Capsule::table('tblcustomfields')->where("relid", $tblcustomfields[0]->relid)->where("fieldname", $row['custom_field_mag'])->where("type", "product")->get();
                $str = trim($vars['customfield'][$tblcustomfieldsData[0]->id]);
                $pattern = "/^([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}$/";
                if (empty($str)) {
                    return [
                        'MAG Address is required',
                    ];
                } else if (preg_match($pattern, $str) != 1) {
                    return [
                        'MAG Address value is not valid',
                    ];
                } else {
                    $magAddresstoSearch = $str;
                    //check mag address
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
                        //request to check mag address 
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $panel_url . 'table?draw=1&id=mags');
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
                            if (in_array($magAddresstoSearch, $arry)) {
                                return "MAG Address already exists.";
                            }
                        }
                        curl_close($ch);
                    }
                }
            } else {
                if ($tblproducts->configoption3 == 'streamlineonly') {

                    //m3u part
                    $tblcustomfieldsData = Capsule::table('tblcustomfields')->where("relid", $tblcustomfields[0]->relid)->where("fieldname", $row['custom_field_username'])->where("type", "product")->get();
                    $usernameToSearch = trim($vars['customfield'][$tblcustomfieldsData[0]->id]);
                    //check username
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
                        //request to check username
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $panel_url . 'table?draw=1&id=lines');
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
                                $checkusername = "2";
                            }
                        }
                        curl_close($ch);
                    }

                    $arrayreturn = array();
                    foreach ($vars['customfield'] as $customfieldIdinarray => $valueinarray) {
                        $tblcustomfieldsname = Capsule::table('tblcustomfields')->where('id', $customfieldIdinarray)->get();
                        if ($tblcustomfieldsname[0]->fieldname == 'Select service type') {
                            $valueinarray_selectservicetype = $valueinarray;
                        }
                        if ($tblcustomfieldsname[0]->fieldname == 'Username') {
                            $valueinarray_username = $valueinarray;
                        }
                        if ($tblcustomfieldsname[0]->fieldname == 'Password') {
                            $valueinarray_Password = $valueinarray;
                        }
                    }
                    if ($valueinarray_selectservicetype == '') {
                        $arrayreturn[] = 'Please Select A Service Type To Continue';
                    }
                    if ($valueinarray_selectservicetype == 'Create new service') {
                        if ($valueinarray_username == '') {
                            $arrayreturn[] = 'Username is required';
                        }
                        if ($valueinarray_username != '' && $checkusername == '2') {
                            $arrayreturn[] = 'Username Already Exists';
                        }
                        if ($valueinarray_Password == '') {
                            $arrayreturn[] = 'Password is required';
                        }
                    }
                    if ($valueinarray_selectservicetype == 'Renew Existing Service') {
                        if ($valueinarray_username == '') {
                            $arrayreturn[] = 'Username is required';
                        }
                        if ($valueinarray_username != '' && $checkusername != '2') {
                            $arrayreturn[] = 'Username Does not Exists';
                        }
                    }
                    return $arrayreturn;
                }
            }
        }
    }
});
add_hook('InvoiceCreation', 1, function ($vars) {
    $invoiceid = $vars['invoiceid'];
    $tblinvoiceitems = Capsule::table('tblinvoiceitems')->where('invoiceid', $invoiceid)->get();
    foreach ($tblinvoiceitems as $values) {
        $serviceid = $values->relid;
        $tblhosting = Capsule::table('tblhosting')->where('id', $serviceid)->first();
        $packageid = $tblhosting->packageid;
        $tblproducts = Capsule::table('tblproducts')->where('id', $packageid)->first();
        $productType = $tblproducts->configoption3;
        $servertype = $tblproducts->servertype;
        if ($servertype == "XUIResellerPanel" && ($productType == "streamlineonly" || $productType == "magdevice")) {
            $config = Capsule::table('xui_settings')->get();
            foreach ($config as $value) {
                $row[$value->setting] = $value->value;
            }
            $explodedInvoiceItems = explode(PHP_EOL, $values->description);
            $newDescription = "";
            foreach ($explodedInvoiceItems as $value) {
                if (stripos(trim($value), trim($row['custom_field_mag'])) !== false) {
                    if ($tblproducts->configoption3 == "magdevice") {
                        $newDescription .= trim($value) . "<br>";
                    }
                } else if (stripos(trim($value), trim($row['custom_field_username'])) !== false) {
                    if ($tblproducts->configoption3 == "streamlineonly") {
                        // $newDescription .= trim($value) . "<br>";
                    }
                } else {
                    $newDescription .= trim($value) . "<br>";
                }
            }
            $tblinvoiceitems = Capsule::table('tblinvoiceitems')->where('id', $values->id)->update(['description' => $newDescription]);
        }
    }
});
add_hook('ClientAreaPage', 1, function ($vars) {
    if ($vars['productinfo']['module'] == 'XUIResellerPanel' || $vars['module'] == 'XUIResellerPanel') {
        $pid = isset($vars['productinfo']['pid']) ? $vars['productinfo']['pid'] : $vars['pid'];
        $tblproducts = Capsule::table('tblproducts')->where("id", $pid)->get();
        if ($tblproducts[0]->configoption3 == "streamlineonly" || $tblproducts[0]->configoption3 == "magdevice" || ($vars['pagetitle'] == "Client Area" && $vars['displayTitle'] == "Manage Product" && $vars['action'] == "productdetails")) {
            if (($vars['pagetitle'] == "Shopping Cart" && $vars['displayTitle'] == "Shopping Cart" && $vars['action'] == "confproduct") || ($vars['pagetitle'] == "Client Area" && $vars['displayTitle'] == "Manage Product" && $vars['action'] == "productdetails")) {
                $tblcustomfields = Capsule::table('tblcustomfields')->whereIn("fieldname", ['Select Bouquets'])->where("relid", $pid)->get();
                foreach ($tblcustomfields as $values) {
                    if ($values->fieldname == "Select Bouquets") {
                        $fieldid =  $values->id;
                        $tblcustomfieldsvalues = Capsule::table('tblcustomfieldsvalues')->where('relid', $vars['serviceid'])->where('fieldid', $fieldid)->first();
                        $Bouquets = $tblcustomfieldsvalues->value;
                        if (isset($Bouquets) && !empty($Bouquets)) {
                            $getBouquets = $Bouquets;
                        } else {
                            $getBouquets = $tblproducts[0]->configoption12;
                        }
                        $bouquets = $values->id;
                    }
                }
                $getcustomfieldid = Capsule::table('tblcustomfields')->where('fieldname', 'Select service type')->where('type', 'product')->where('relid', $pid)->get();
                $getcustomfieldid_Username = Capsule::table('tblcustomfields')->where('fieldname', 'Username')->where('type', 'product')->where('relid', $pid)->get();
                $getcustomfieldid_Password = Capsule::table('tblcustomfields')->where('fieldname', 'Password')->where('type', 'product')->where('relid', $pid)->get();
                $customfieldIdselectservicetype = $getcustomfieldid[0]->id;
                $customfieldIdselectservicetype_Username = $getcustomfieldid_Username[0]->id;
                $customfieldIdselectservicetype_Password = $getcustomfieldid_Password[0]->id;
?>
                <div style="display:none" id="organizebouquetsCategoriesmodal" class="modal" role="dialog">
                    <form action="" method="POST" id="saveCategorizeBouquetsform">
                        <div class="modal-dialog" style="width:900px;">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Bouquets List</h4>
                                </div>
                                <div class="modal-body" style="padding-bottom:0px;height: 450px;overflow:auto">
                                    <div class="conatiner-fluid">
                                        <!-- categories    -->
                                        <div id="categories_title"></div>
                                    </div>
                                    <div class="conatiner-fluid">
                                        <div class="col-sm-12">
                                            <div class="row" id="bouquest_section" style="padding: 10px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <?php
                                    if ($vars['action'] == "confproduct") {
                                    ?>
                                        <button type="button" class="btn btn-primary" id="savebouquetcategories" onclick="saveCategorizeBouquets()">Save Changes</button>
                                        <?php
                                    }
                                    if ($vars['action'] == "productdetails") {
                                        if ($pid) {
                                            if ($tblproducts[0]->configoption3 == "magdevice") {
                                        ?>
                                                <input type="hidden" id="MagAddressCustom" name="newMAC" value="">
                                                <input type="hidden" id="customAction" name="customAction" value="changeBouquets">
                                            <?php
                                            }
                                            if ($tblproducts[0]->configoption3 == "streamlineonly") {
                                            ?>
                                                <input type="hidden" id="passwordCustom" name="pass_word" value="">
                                                <input type="hidden" id="customAction" name="customAction" value="update_pass">
                                        <?php
                                            }
                                        }
                                        ?>
                                        <input type="hidden" id="clientSelectedBouquets" name="clientSelectedBouquets" value="<?php echo $getBouquets ?>">
                                        <input type="hidden" id="serviceid" name="serviceid" value="<?php echo $vars['serviceid'] ?>">
                                        <button type="button" class="btn btn-primary" id="savebouquetcategories" onclick="saveCategorizeBouquetsServicePage()">Save Changes</button>
                                    <?php
                                    }
                                    ?>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <style>
                    @media (max-width: 1000px) {
                        #order-standard_cart {
                            width: 100% !important;
                            height: 700px !important;
                            overflow: auto !important;
                        }

                        /* Hide scrollbar for Chrome, Safari and Opera */
                        #order-standard_cart::-webkit-scrollbar {
                            display: none;
                        }

                        /* Hide scrollbar for IE, Edge and Firefox */
                        #order-standard_cart {
                            -ms-overflow-style: none;
                            /* IE and Edge */
                            scrollbar-width: none;
                            /* Firefox */
                        }
                    }

                    #lightbox {
                        display: none !important;
                    }
                </style>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                    $(document).ready(function() {
                        if ($("#customfield<?php echo $customfieldIdselectservicetype ?>").val() == "") {
                            $("#customfield<?php echo $customfieldIdselectservicetype_Password ?>").parent('.form-group').hide();
                            $("#customfield<?php echo $customfieldIdselectservicetype_Username ?>").parent('.form-group').hide();
                        }
                        if ($("#customfield<?php echo $customfieldIdselectservicetype ?>").val() == "Create new service") {
                            $("#customfield<?php echo $customfieldIdselectservicetype_Username ?>").siblings('.field-help-text').text("4 to 28 characters in length, alpha-numeric, or underscores only.");
                        }
                        if ($("#customfield<?php echo $customfieldIdselectservicetype ?>").val() == "Renew Existing Service") {
                            $("#customfield<?php echo $customfieldIdselectservicetype_Password ?>").parent('.form-group').hide();
                            $("#customfield<?php echo $customfieldIdselectservicetype_Username ?>").siblings('.field-help-text').text("Enter username to renew");
                        }
                        $("#customfield<?php echo $customfieldIdselectservicetype ?>").on('change', function() {
                            if ($("#customfield<?php echo $customfieldIdselectservicetype ?>").val() == "") {
                                $("#customfield<?php echo $customfieldIdselectservicetype_Password ?>").parent('.form-group').hide();
                                $("#customfield<?php echo $customfieldIdselectservicetype_Username ?>").parent('.form-group').hide();
                            }
                            if ($("#customfield<?php echo $customfieldIdselectservicetype ?>").val() == "Create new service") {
                                $("#customfield<?php echo $customfieldIdselectservicetype_Password ?>").parent('.form-group').show();
                                $("#customfield<?php echo $customfieldIdselectservicetype_Username ?>").parent('.form-group').show();
                                $("#customfield<?php echo $customfieldIdselectservicetype_Username ?>").siblings('.field-help-text').text("4 to 28 characters in length, alpha-numeric, or underscores only.");
                            }
                            if ($("#customfield<?php echo $customfieldIdselectservicetype ?>").val() == "Renew Existing Service") {
                                $("#customfield<?php echo $customfieldIdselectservicetype_Password ?>").parent('.form-group').hide();
                                $("#customfield<?php echo $customfieldIdselectservicetype_Username ?>").parent('.form-group').show();
                                $("#customfield<?php echo $customfieldIdselectservicetype_Username ?>").siblings('.field-help-text').text("Enter username to renew");
                            }
                        });

                    });

                    function categoriseBouquets(catid, bouquets, savedbouquets, cat_data, clientSavedBouquets) {
                        ClientSavedBouquets = "";
                        if (clientSavedBouquets.length > 0) {
                            ClientSavedBouquets = clientSavedBouquets;
                        }
                        savedbouquets = jQuery.parseJSON(JSON.stringify(savedbouquets));
                        $('.categories_select').removeClass('active');
                        $('.categories_select').removeClass('activecat');
                        $('.categories_select').find('a').removeClass('selected_cat');
                        $("[data-catid=" + catid + "]").parent('.categories_select').addClass('active');
                        $("[data-catid=" + catid + "]").parent('.categories_select').addClass('activecat');
                        $('.categories_select').find('a').addClass('selected_cat');
                        var html = "";
                        if (cat_data == 0 || cat_data == null || cat_data == undefined || cat_data == "") {
                            alert('No bouquets available.');
                        } else {
                            selectedBouquests = localStorage.getItem('selectedBouquests');
                            if (selectedBouquests == "" || selectedBouquests == null || selectedBouquests == "null" || selectedBouquests == undefined) {
                                selectedBouquests = [];
                            } else {
                                selectedBouquests = jQuery.parseJSON(selectedBouquests);
                            }
                            if (ClientSavedBouquets == "") {
                                //show all the bouquets unchecked
                                html += '<div style="margin-bottom: 10px;" class="col-sm-12"><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input id="selectAll" type="checkbox">&nbsp&nbsp Select All</label></div>';
                                $.each(bouquets, function(bouquet_id, channel_name) {
                                    $.each(savedbouquets, function(index, val) {
                                        if (val == bouquet_id) {
                                            checked = "";
                                            $.each(selectedBouquests, function(index, seleted_bouquet_id) {
                                                if (seleted_bouquet_id == val) {
                                                    checked = "checked";
                                                    return true;
                                                }
                                            });
                                            if (cat_data[bouquet_id] == catid && cat_data[bouquet_id] != null && cat_data[bouquet_id] != "null" && cat_data[bouquet_id] != undefined && cat_data[bouquet_id] != "uncategorized") {
                                                html += '<div><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input name="selectedbouquets" class="allbouquets" onchange="saveselectedbouquets()" data-bouquetname="' + channel_name + '" type="checkbox" value="' + bouquet_id + '" ' + checked + '>&nbsp&nbsp <span class="textToSort">' + channel_name + '</span></label></div>';
                                            }
                                            if (cat_data[bouquet_id] == catid && cat_data[bouquet_id] == "uncategorized" && cat_data[bouquet_id] != null && cat_data[bouquet_id] != "null" && cat_data[bouquet_id] != undefined) {
                                                html += '<div><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input name="selectedbouquets" class="allbouquets" onchange="saveselectedbouquets()" data-bouquetname="' + channel_name + '" type="checkbox" value="' + bouquet_id + '" ' + checked + '>&nbsp&nbsp <span class="textToSort">' + channel_name + '</span></label></div>';
                                            }
                                        }
                                    });
                                });
                            } else {
                                //show client selected bouquets checked  
                                html += '<div class="col-sm-12"><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input id="selectAll" type="checkbox">&nbsp&nbsp Select All</label></div>';
                                $.each(bouquets, function(bouquet_id, channel_name) {
                                    $.each(savedbouquets, function(index, val) {
                                        if (val == bouquet_id) {
                                            checked = "";
                                            $.each(selectedBouquests, function(index, seleted_bouquet_id) {
                                                if (seleted_bouquet_id == val) {
                                                    checked = "checked";
                                                    return true;
                                                }
                                            });
                                            if (cat_data[bouquet_id] == catid && cat_data[bouquet_id] != null && cat_data[bouquet_id] != "null" && cat_data[bouquet_id] != undefined && cat_data[bouquet_id] != "uncategorized") {
                                                html += '<div><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input name="selectedbouquets" class="allbouquets" onchange="saveselectedbouquets()" data-bouquetname="' + channel_name + '" type="checkbox" value="' + bouquet_id + '" ' + checked + '>&nbsp&nbsp <span class="textToSort">' + channel_name + '</span></label></div>';
                                            }
                                            if (cat_data[bouquet_id] == catid && cat_data[bouquet_id] == "uncategorized" && cat_data[bouquet_id] != null && cat_data[bouquet_id] != "null" && cat_data[bouquet_id] != undefined) {
                                                html += '<div><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input name="selectedbouquets" class="allbouquets" onchange="saveselectedbouquets()" data-bouquetname="' + channel_name + '" type="checkbox" value="' + bouquet_id + '" ' + checked + '>&nbsp&nbsp <span class="textToSort">' + channel_name + '</span></label></div>';
                                            }
                                        }
                                    });
                                });
                            }
                        }
                        $("#bouquest_section").html('<div class="row">' + html + '</div>');
                        $("#selectAll").bind("click", function() {
                            if ($(this).is(":checked")) {
                                $(".allbouquets").prop("checked", true);
                            } else {
                                $(".allbouquets").prop("checked", false);
                            }
                            saveselectedbouquets();
                        });
                        checkifchecked();
                    }

                    function saveCategorizeBouquets() {
                        var newArraySelected = [];
                        selectedBouquests = localStorage.getItem('selectedBouquests');
                        if (selectedBouquests == "" || selectedBouquests == null || selectedBouquests == "null" || selectedBouquests == undefined) {
                            selectedBouquests = [];
                        } else {
                            selectedBouquests = jQuery.parseJSON(selectedBouquests);
                        }
                        $.each(selectedBouquests, function(index, val) {
                            if (val != "" && val != null && val != "null" && val != undefined) {
                                newArraySelected.push(val);
                            }
                        });
                        $("#customfield<?php echo $bouquets ?>").val(newArraySelected);
                        $("#organizebouquetsCategoriesmodal").modal("hide");
                    }

                    function saveCategorizeBouquetsServicePage() {
                        var newArraySelected = [];
                        selectedBouquests = localStorage.getItem('selectedBouquests');
                        if (selectedBouquests == "" || selectedBouquests == null || selectedBouquests == "null" || selectedBouquests == undefined) {
                            selectedBouquests = [];
                        } else {
                            selectedBouquests = jQuery.parseJSON(selectedBouquests);
                        }
                        $.each(selectedBouquests, function(index, val) {
                            if (val != "" && val != null && val != "null" && val != undefined) {
                                newArraySelected.push(val);
                            }
                        });
                        //request to edit bouquets
                        $("#clientSelectedBouquets").val(newArraySelected);
                        $("#passwordCustom").val($("#pass_word").val());
                        $("#MagAddressCustom").val($("#MagAddress").val());
                        $("#saveCategorizeBouquetsform").submit();
                        $("#organizebouquetsCategoriesmodal").modal("hide");
                    }

                    function saveselectedbouquets() {
                        selected = localStorage.getItem('selectedBouquests');
                        if (selected == "" || selected == null || selected == "null" || selected == undefined) {
                            selected = [];
                        } else {
                            selected = jQuery.parseJSON(selected);
                        }
                        $(".allbouquets").each(function(index) {
                            if ($(this).is(":checked")) {
                                selected[$(this).val()] = $(this).val();
                            } else {
                                delete selected[$(this).val()];
                            }
                        });
                        localStorage.setItem('selectedBouquests', JSON.stringify(selected));
                        checkifchecked();
                    }

                    function saveselectedbouquetsForServicePage(clientSavedBouquets) {
                        selected = localStorage.getItem('selectedBouquests');
                        if (selected == "" || selected == null || selected == "null" || selected == undefined) {
                            selected = [];
                        } else {
                            selected = jQuery.parseJSON(selected);
                        }
                        $.each(clientSavedBouquets, function(index, value) {
                            selected[value] = value;
                        });
                        localStorage.setItem('selectedBouquests', JSON.stringify(selected));
                        checkifchecked();
                    }

                    function checkifchecked() {
                        totallength = $(".allbouquets").length;
                        totallengthchecked = $('input[class="allbouquets"]:checked').length;
                        if (totallength == totallengthchecked) {
                            $("#selectAll").prop("checked", true);
                        } else {
                            $("#selectAll").prop("checked", false);
                        }
                    }

                    function selectbouquets(category_Id) {
                        response = localStorage.getItem('bouquetsforclientarea');
                        var obj = jQuery.parseJSON(response);
                        clientSavedBouquets = obj.clientSavedBouquets;
                        uncategorizedLength = obj.uncategorizedLength;
                        if (obj.status == "success") {
                            cat_data = obj.cat_data;
                            catid = $(".activecat").find(".selected_cat").data('catid');
                            categories = obj.data;
                            categories_title = "";
                            categories_title += '<ul class="nav nav-tabs">';
                            count = 0;
                            savedbouquets = obj.savedbouquets;
                            bouquets = obj.bouquets;
                            savedbouquets = savedbouquets.split(",");
                            $.each(categories, function(index, val) {
                                $.each(val, function(index, category_name) {
                                    category_id = index;
                                    count++;
                                    active = "";
                                    selected_cat = "";
                                    if (category_Id != "" && category_Id != undefined && category_Id && "undefined" && category_Id != null && category_Id != "null") {
                                        if (category_id == category_Id) {
                                            active = "active activecat";
                                            selected_cat = "selected_cat";
                                        }
                                    } else {
                                        if (count == 1) {
                                            active = "active activecat";
                                            selected_cat = "selected_cat";
                                        }
                                    }
                                    categories_title += '<li role="presentation" class="categories_select ' + active + '"><a style="cursor: pointer;" data-catid="' + category_id + '" data-catname="' + category_name + '" class="' + selected_cat + '" onclick="selectbouquets(' + category_id + ')">' + category_name + '</a></li>';
                                });
                            });
                            if (category_Id == "uncatgorized") {
                                activeuncat = "active activecat";
                                selected_uncat = "selected_cat";
                            } else {
                                activeuncat = "";
                                selected_uncat = "";
                            }
                            uncatgorized = "uncatgorized";
                            if (uncategorizedLength > 0) {
                                categories_title += '<li role="presentation" class="categories_select ' + activeuncat + '"><a style="cursor: pointer;" data-catid="uncategorized" data-catname="uncategorized" class="' + selected_uncat + '" onclick="selectbouquets(' + uncatgorized + ')">Uncategorized</a></li></ul>';
                            }
                            $("#categories_title").html(categories_title);
                            var html = "";
                            if (cat_data == 0 || cat_data == null || cat_data == undefined || cat_data == "" || cat_data == "null" || cat_data == "undefined") {
                                alert('No Bouquets available.');
                            } else {
                                catid = $(".activecat").find('.selected_cat').data('catid');
                                categoriseBouquets(catid, bouquets, savedbouquets, cat_data, clientSavedBouquets);
                                //----------------------------------------------------------------------------------------------------------------------------
                                //sort channels alphabetically 
                                sortedTextArray = $(".textToSort").sort(Ascending_sort);
                                append = '<div class="row"><div style="margin-bottom: 10px;" class="col-sm-12"><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input id="selectAll" type="checkbox">&nbsp;&nbsp; Select All</label></div>';
                                rowshouldbe = 3;
                                totalaarray = sortedTextArray.length;
                                perow = Math.ceil(totalaarray / rowshouldbe);
                                nextperlow = perow;
                                totalrows = 0;
                                counter = 1;
                                $.each(sortedTextArray, function(key, val) {
                                    if (counter == 1) {
                                        append += '<div style="padding:0px" class = "col-md-4 col-sm-4">';
                                    }
                                    Parent = $(this).closest('div');
                                    labelToAppend = Parent[0].outerHTML;
                                    append += '<div class = "col-md-12 col-sm-12">' + labelToAppend + '</div>';

                                    if (nextperlow == counter) {
                                        nextperlow = nextperlow + perow;
                                        totalrows = totalrows + 1;
                                        append += '</div>';
                                        if (totalrows < rowshouldbe) {
                                            append += '<div style="padding:0px" class = "col-md-4 col-sm-4">';
                                        }
                                    }
                                    ++counter;
                                });
                                append += '</div>';
                                //----------------------------------------------------------------------------------------------------------------------------
                                $("#bouquest_section").html(append);
                                checkifchecked();
                                $("#message").hide();
                                $("#organizebouquetsCategoriesmodal").modal("show");
                            }
                        } else {
                            alert('No Bouquets found!');
                        }
                        checkifchecked();
                        $("#selectAll").bind("click", function() {
                            if ($(this).is(":checked")) {
                                $(".allbouquets").prop("checked", true);
                            } else {
                                $(".allbouquets").prop("checked", false);
                            }
                            saveselectedbouquets();
                        });
                    }

                    function selectbouquetsFirst() {
                        //request to fetch bouquets
                        $.ajax({
                            type: "POST",
                            url: "modules/servers/XUIResellerPanel/Config.php",
                            data: {
                                action: 'getBouquetCategoriesOnClientArea',
                                productid: '<?php echo $pid ?>',
                                serviceid: '<?php echo isset($vars['serviceid']) ? $vars['serviceid'] : "" ?>'
                            },
                            success: function(response) {
                                var obj = jQuery.parseJSON(response);
                                clientSavedBouquets = obj.clientSavedBouquets;
                                uncategorizedLength = obj.uncategorizedLength;
                                localStorage.setItem('bouquetsforclientarea', response);
                                if (obj.status == "success") {
                                    cat_data = obj.cat_data;
                                    catid = $(".activecat").find(".selected_cat").data('catid');
                                    categories = obj.data;
                                    categories_title = "";
                                    categories_title += '<ul class="nav nav-tabs">';
                                    count = 0;
                                    savedbouquets = obj.savedbouquets;
                                    bouquets = obj.bouquets;
                                    savedbouquets = savedbouquets.split(",");
                                    $.each(categories, function(index, val) {
                                        $.each(val, function(index, category_name) {
                                            category_id = index;
                                            count++;
                                            active = "";
                                            selected_cat = "";
                                            if (count == 1) {
                                                active = "active activecat";
                                                selected_cat = "selected_cat";
                                            }
                                            categories_title += '<li role="presentation" class="categories_select ' + active + '"><a style="cursor: pointer;" data-catid="' + category_id + '" data-catname="' + category_name + '" class="' + selected_cat + '" onclick="selectbouquets(' + category_id + ')">' + category_name + '</a></li>';
                                        });
                                    });
                                    uncatgorized = "uncatgorized";
                                    if (uncategorizedLength > 0) {
                                        categories_title += '<li role="presentation" class="categories_select"><a style="cursor: pointer;" data-catid="uncategorized" data-catname="uncategorized" onclick="selectbouquets(' + uncatgorized + ')">Uncategorized</a></li></ul>';
                                    }
                                    $("#categories_title").html(categories_title);
                                    var html = "";
                                    if (cat_data == 0 || cat_data == null || cat_data == undefined || cat_data == "" || cat_data == "null" || cat_data == "undefined") {
                                        alert('No Bouquets available.');
                                    } else {
                                        // $("#bouquest_section").html('<div class="row">' + html + '</div>');
                                        catid = $(".activecat").find('.selected_cat').data('catid');
                                        saveselectedbouquetsForServicePage(clientSavedBouquets);
                                        categoriseBouquets(catid, bouquets, savedbouquets, cat_data, clientSavedBouquets);
                                        $("#message").hide();
                                        //----------------------------------------------------------------------------------------------------------------------------
                                        //sort channels alphabetically 
                                        sortedTextArray = $(".textToSort").sort(Ascending_sort);
                                        append = '<div class="row"><div style="margin-bottom: 10px;" class="col-sm-12"><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input id="selectAll" type="checkbox">&nbsp;&nbsp; Select All</label></div>';
                                        rowshouldbe = 3;
                                        totalaarray = sortedTextArray.length;
                                        perow = Math.ceil(totalaarray / rowshouldbe);
                                        nextperlow = perow;
                                        totalrows = 0;
                                        counter = 1;
                                        $.each(sortedTextArray, function(key, val) {
                                            if (counter == 1) {
                                                append += '<div style="padding:0px" class = "col-md-4 col-sm-4">';
                                            }
                                            Parent = $(this).closest('div');
                                            labelToAppend = Parent[0].outerHTML;
                                            append += '<div class = "col-md-12 col-sm-12">' + labelToAppend + '</div>';

                                            if (nextperlow == counter) {
                                                nextperlow = nextperlow + perow;
                                                totalrows = totalrows + 1;
                                                append += '</div>';
                                                if (totalrows < rowshouldbe) {
                                                    append += '<div style="padding:0px" class = "col-md-4 col-sm-4">';
                                                }
                                            }
                                            ++counter;
                                        });
                                        append += '</div>';
                                        //----------------------------------------------------------------------------------------------------------------------------
                                        $("#bouquest_section").html(append);
                                        checkifchecked();
                                        $("#organizebouquetsCategoriesmodal").modal("show");
                                        $("#selectAll").bind("click", function() {
                                            if ($(this).is(":checked")) {
                                                $(".allbouquets").prop("checked", true);
                                            } else {
                                                $(".allbouquets").prop("checked", false);
                                            }
                                            saveselectedbouquets();
                                        });
                                    }
                                } else {
                                    alert('No Bouquets found!');
                                }
                            },
                            error: function() {
                                alert('No Bouquets found!');
                            }
                        });
                        checkifchecked();
                    }

                    function Ascending_sort(a, b) {
                        return ($(b).text().toUpperCase()) <
                            ($(a).text().toUpperCase()) ? 1 : -1;
                    }
                    $(document).ready(function() {
                        $("#selectAll").bind("click", function() {
                            if ($(this).is(":checked")) {
                                $(".allbouquets").prop("checked", true);
                            } else {
                                $(".allbouquets").prop("checked", false);
                            }
                            saveselectedbouquets();
                        });
                        $("#customfield<?php echo $bouquets ?>").parent('.form-group').hide();
                        localStorage.setItem('selectedBouquests', '');
                        $("#customfield<?php echo $bouquets ?>").parent('div').after('<div align="center"><button onclick="selectbouquetsFirst()" type="button" class="btn btn-primary">Select Bouquets</button></div>');
                    });
                </script>
<?php
            }
        }
    }
});
add_hook('EmailPreSend', 1, function ($vars) {
    $merge_fields = [];
    $messagename = $vars['messagename'];
    $serviceID = $vars['relid'];
    if ($messagename == "IPTV Service Details") {
        $getserviceData = gethostingandproductbyserviceid($serviceID);
        if (isset($getserviceData->id) && !empty($getserviceData->id)) {
            $productID = (isset($getserviceData->id) && !empty($getserviceData->id)) ? $getserviceData->id : "";
            $serviceid = (isset($getserviceData->serviceid) && !empty($getserviceData->serviceid)) ? $getserviceData->serviceid : "";
            $ptype = (isset($getserviceData->configoption3) && !empty($getserviceData->configoption3)) ? $getserviceData->configoption3 : "";
            if ($ptype == "magdevice") {
                $getemailtemplate = Capsule::table('tblemailtemplates')
                    ->where('name', '=', "IPTV MAG Service Details")
                    ->where('type', '=', "product")
                    ->count();
                if ($getemailtemplate > 0) {
                    $command = 'SendEmail';
                    $postData = array(
                        'messagename' => 'IPTV MAG Service Details',
                        'id' => $serviceid
                    );
                    $results = localAPI($command, $postData);

                    $merge_fields['abortsend'] = true;
                    return $merge_fields;
                }
            }
        }
    }

    $getserviceData = gethostingandproductbyserviceid($serviceID);
    if (isset($getserviceData->id) && !empty($getserviceData->id)) {
        $productID = (isset($getserviceData->id) && !empty($getserviceData->id)) ? $getserviceData->id : "";
        $serviceid = (isset($getserviceData->serviceid) && !empty($getserviceData->serviceid)) ? $getserviceData->serviceid : "";
        $tblproducts = Capsule::table('tblproducts')->where('id', $productID)->first();
        $serverid = $tblproducts->configoption1;
        $count = Capsule::table('xui_paneldetails')->where('id', $serverid)->count();
        if ($count > 0) {
            $Portallink = Capsule::table('xui_paneldetails')->where('id', $serverid)->first();
            $mag_portal = $Portallink->mag_portal;
            $m3uurl = $Portallink->m3uurl;
            $watchstrmurl = $Portallink->watchstrmurl;
            $portalUrl = "";
            $ptype = (isset($getserviceData->configoption3) && !empty($getserviceData->configoption3)) ? $getserviceData->configoption3 : "";
            if ($ptype == "streamlineonly" || $ptype == "magdevice") {
                if ($messagename == "IPTV MAG Service Details") {
                    $portalUrl = $mag_portal;
                } else if ($messagename == "IPTV Service Details") {
                    $portalUrl = $m3uurl;
                }
                if (isset($portalUrl) && !empty($portalUrl)) {
                    $bar = "/";
                    if (substr($portalUrl, -1) == "/") {
                        $bar = "";
                    }
                    $portalUrl = $portalUrl . $bar;

                    $fielddata = getcustomfieldsandvaluesbyserviceid($serviceid, $productID);

                    if ($messagename == "IPTV MAG Service Details") {
                        $magAddressIs = (isset($fielddata["MAG Address"]) && !empty($fielddata["MAG Address"])) ? $fielddata["MAG Address"] : "";
                        $merge_fields['mag_address'] = $magAddressIs;
                    }
                    $merge_fields['portal_url'] = $portalUrl;
                    $merge_fields['service_server_hostname'] = $portalUrl;
                    return $merge_fields;
                }
            }
        }
    }
});

function getcustomfieldsandvaluesbyserviceid($serviceID = "", $productid = "")
{
    $returnData = array();
    $checkcustomfield = Capsule::table('tblcustomfields')
        ->join('tblcustomfieldsvalues', 'tblcustomfields.id', '=', 'tblcustomfieldsvalues.fieldid')
        ->where('tblcustomfields.relid', '=', $productid)
        ->where('tblcustomfields.type', '=', "product")
        ->where('tblcustomfieldsvalues.relid', '=', $serviceID)
        ->select(
            'tblcustomfieldsvalues.*'
        )
        ->count();
    if ($checkcustomfield > 0) {
        $getcustomfield = Capsule::table('tblcustomfields')
            ->join('tblcustomfieldsvalues', 'tblcustomfields.id', '=', 'tblcustomfieldsvalues.fieldid')
            ->where('tblcustomfields.relid', '=', $productid)
            ->where('tblcustomfields.type', '=', "product")
            ->where('tblcustomfieldsvalues.relid', '=', $serviceID)
            ->select(
                'tblcustomfieldsvalues.*',
                'tblcustomfields.fieldname'
            )
            ->get();
        foreach ($getcustomfield as $fielddata) {
            $returnData[$fielddata->fieldname] = $fielddata->value;
        }
    }
    return $returnData;
}

function gethostingandproductbyserviceid($serviceID = "")
{
    $returnData = array();
    $checkdata = Capsule::table('tblhosting')
        ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
        ->where('tblhosting.id', '=', $serviceID)
        ->where('tblproducts.servertype', '=', "XUIResellerPanel")
        ->select(
            'tblproducts.*',
            'tblhosting.id as serviceid'
        )
        ->count();
    if ($checkdata > 0) {
        $getdata = Capsule::table('tblhosting')
            ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
            ->where('tblhosting.id', '=', $serviceID)
            ->where('tblproducts.servertype', '=', "XUIResellerPanel")
            ->select(
                'tblproducts.*',
                'tblhosting.id as serviceid'
            )
            ->get();
        $returnData = $getdata[0];
    }
    return $returnData;
}




 
add_hook('UserLogin', 0, function($vars) {
    
        $redirect = $_SESSION['stored_data'];
        
        $cookieValue = $_COOKIE['productitem'];
        
        
        if(!empty($cookieValue)){
            $result_status = Capsule::table('tblproducts')->where('name', $cookieValue)->value('id');
        
            $redirect = "/cart.php?a=add&pid=" . $result_status;
            
            header("Location: $redirect");
            
            $_COOKIE['productitem'] = '';
            
            exit;
        }    
            
            
        

});


add_hook('ClientAreaHeaderOutput', 1, function($vars) {
    
    
    global $smarty;
    global $CONFIG; 
    
    $moduleName = 'XUIModule'; 

    $result_status = Capsule::table('tbladdonmodules')
    ->where('module', $moduleName)
    ->first();
    
    $output = $result_status->value;
    
    $smarty->assign('output', $output);

});

add_hook('ClientAreaFooterOutput', 1, function($vars) {
    $template = $vars['templatefile'];
    if($template == 'configureproduct'){
        return <<<HTML
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() { 
                    var labels = document.getElementsByTagName('label');
        for (var i = 0; i < labels.length; i++) {
            if (labels[i].textContent.trim() === 'Username') {
                var UsernameID = labels[i].getAttribute('for');
                break; 
            }
        }
        
        var labels = document.getElementsByTagName('label');
        for (var i = 0; i < labels.length; i++) {
            if (labels[i].textContent.trim() === 'Password') {
                var passwordInput = document.querySelector('label[for="' + labels[i].getAttribute('for') + '"]');
                if (passwordInput) {
                    var PasswordID = passwordInput.getAttribute('for');
                    break;
                }
            }
        }
        
      //Select Options *
      var labels = document.getElementsByTagName('label');
        for (var i = 0; i < labels.length; i++) {
            if (labels[i].textContent.trim() === 'Select account *') {
                var selectId = labels[i].getAttribute('for');
                break;
            }
        }
        
        //Select service type *
        var labels = document.getElementsByTagName('label');
        for (var i = 0; i < labels.length; i++) {
            if (labels[i].textContent.trim() === 'Select service type *') {
                var selectserviceId = labels[i].getAttribute('for');
                break;
            }
        }

        $('#' + UsernameID).css('display', 'none');
        $('label[for="' + UsernameID + '"]').css('display', 'none');
        
        $('#' + PasswordID).css('display', 'none');
        $('label[for="' + PasswordID + '"]').css('display', 'none');
        
        $('#' + selectId).css('display', 'none');
        $('label[for="' + selectId + '"]').css('display', 'none');
        
        //Select Account
        $('#customfield2173').css('display', 'none');
        $("label[for='customfield2173']").css('display', 'none');
        
        //Username
        $('#customfield2170').css('display', 'none');
        $("label[for='customfield2170']").css('display', 'none');
        
        //Password 
        $('#customfield2172').css('display', 'none');
        $("label[for='customfield2172']").css('display', 'none');
        
        $('.field-help-text').css('display', 'none');
        
        var selectElement = document.getElementById(selectserviceId);
        
        var newAccountOption = selectElement.querySelector('option[value="Select Service"]');
         
        newAccountOption.setAttribute("selected", "disabled");
        
        //checkServiceType();
        
        var selectserviceId = selectserviceId;

        $('#' + selectserviceId).change(function () {
            checkServiceType();
        });


        function checkServiceType() {
            
            var selectedServiceType = $('#' + selectserviceId).val();
            
            if (selectedServiceType === 'Create new service') {

                $('.form-group:has(label[for="' + UsernameID + '"])').css('display', 'block');
                $('.form-group:has(label[for="' + PasswordID + '"])').css('display', 'block');
                $('.form-group:has(label[for="' + selectId + '"])').css('display', 'none');
                
                $('.generate-password').css('display', 'block');
                
                $('#' + PasswordID).css('display', 'block');
                $('label[for="' + PasswordID + '"]').css('display', 'block');
                
                $('#' + UsernameID).css('display', 'block');
                $('label[for="' + UsernameID + '"]').css('display', 'block');
                
                $('.field-help-text').css('display', 'block');
                
                
            } if(selectedServiceType === 'Renew Existing Service') {
                
                makeAjaxRequest();
                
                 $('#' + selectId).css('display', 'none');
                 $('label[for="' + selectId + '"]').css('display', 'none');
                
                $('#' + UsernameID).css('display', 'none');
                $('label[for="' + UsernameID + '"]').css('display', 'none');
                
                $('#' + PasswordID).css('display', 'block');
                $('label[for="' + PasswordID + '"]').css('display', 'block');
                
                $('.field-help-text').css('display', 'none');
                $('.generate-password').css('display', 'block');
                
                $('.form-group:has(label[for="' + UsernameID + '"])').css('display', 'none');
                
                $('.form-group:has(label[for="' + PasswordID + '"])').css('display', 'none');
                
                $('.form-group:has(label[for="' + selectId + '"])').css('display', 'none');
            } 
        }
        
        var labels = document.getElementsByTagName('label');
        for (var i = 0; i < labels.length; i++) {
            if (labels[i].textContent.trim() === 'Select account *') {
                var selectId = labels[i].getAttribute('for');
                break;
            }
        }
        
        const selectElementss = document.getElementById(selectId);
        
        selectElementss.addEventListener('change', function() {
            const selectedValue = selectElementss.value;
            if (selectElementss.value !== '') {
                makeupgradeservices(selectedValue);
            }
        });

            function generatePasswordWithOptions(length, useUppercase, useLowercase, useNumbers, useSymbols, useMixedCaseAlpha, useMixedCaseSpecialChars) {
              const uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
              const lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
              const numberChars = '0123456789';
              const symbolChars = '@#$%^&*()_+-=[]{}|;:,.<>?';
              let characterPool = '';
            
              if (useUppercase) {
                characterPool += uppercaseChars;
              }
            
              if (useLowercase) {
                characterPool += lowercaseChars;
              }
            
              if (useNumbers) {
                characterPool += numberChars;
              }
            
              if (useSymbols) {
                characterPool += symbolChars;
              }
            
              if (useMixedCaseAlpha) {
                characterPool += 'aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ';
              }
            
              if (useMixedCaseSpecialChars) {
                characterPool += '1@3$';
              }
            
              if (characterPool === '') {
                return 'Select at least one character set.';
              }
            
              let password = '';
            
              for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characterPool.length);
                password += characterPool.charAt(randomIndex);
              }
            
              return password;
            }
            
            document.getElementById('frmGeneratePassword').addEventListener('submit', function(event) {
              event.preventDefault(); // Prevent the default form submission
            
              const pwLength = parseInt(document.getElementById('inputGeneratePasswordLength').value);
              const useUppercase = document.getElementById('uppercaseCheckbox').checked;
              const useLowercase = document.getElementById('lowercaseCheckbox').checked;
              const useNumbers = document.getElementById('numbersCheckbox').checked;
              const useSymbols = document.getElementById('symbolsCheckbox').checked;
              const useMixedCaseAlpha = document.getElementById('mixedCaseAlphaCheckbox').checked;
              const useMixedCaseSpecialChars = document.getElementById('mixedCaseSpecialCharsCheckbox').checked;
            
              const generatedPassword = generatePasswordWithOptions(pwLength, useUppercase, useLowercase, useNumbers, useSymbols, useMixedCaseAlpha, useMixedCaseSpecialChars);
            
              document.getElementById('inputGeneratePasswordOutput').value = generatedPassword;
            });

                document.getElementById('copiedPasswordCheckbox').addEventListener('change', function() {
                    const btnGeneratePasswordInsert = document.getElementById('btnGeneratePasswordInsert');
                    if (this.checked) {
                    
                            var generatedPassword = $('#inputGeneratePasswordOutput').val();
    var labels = document.getElementsByTagName('label');
            for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent.trim() === 'Password') {
                    var passwordInput = document.querySelector('label[for="' + labels[i].getAttribute('for') + '"]');
                    if (passwordInput) {
                        var PasswordID = passwordInput.getAttribute('for');
                        break;
                    }
                }
            }
    jQuery('#' + PasswordID).val(generatedPassword);
                        btnGeneratePasswordInsert.removeAttribute('disabled');
                    } else {
                        btnGeneratePasswordInsert.setAttribute('disabled', 'disabled');
                    }
                });



            const generatePasswordBtn = document.createElement('a');
            generatePasswordBtn.classList.add('btn', 'outline-btn', 'generate-password');
            generatePasswordBtn.textContent = 'Generate Password';
            generatePasswordBtn.style.display = 'none';
         

            
            var labels = document.getElementsByTagName('label');
            for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent.trim() === 'Password') {
                    var passwordInput = document.querySelector('label[for="' + labels[i].getAttribute('for') + '"]');
                    if (passwordInput) {
                        var PasswordID = passwordInput.getAttribute('for');
                        break;
                    }
                }
            }

            const customField2172 = document.getElementById(PasswordID);
            if (customField2172) {
                customField2172.parentNode.insertBefore(generatePasswordBtn, customField2172.nextSibling);

                $('.generate-password').on('click', function() { 
                  $('#modalGeneratePassword').modal('show');
                });
                 
            }
        });
        jQuery(document).on('click', '.cancelButton', function() {
            jQuery('.removebtn').remove();
            
            var labels = document.getElementsByTagName('label');
            for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent.trim() === 'Select account *') {
                    var selectId = labels[i].getAttribute('for');
                    break;
                }
            }
        
            jQuery('#' + selectId)[0].selectedIndex = 0;
        });
        jQuery(document).on('click', '#paynow', function() {
            paynow(); 
        });
        
        jQuery(document).on('click', '#renew', function() {
            renew(); 
        });
        
        jQuery(document).on('click', '#generateinvoice', function() {
            generateinvoice(); 
        });
        
        
        jQuery(document).on('click', '#upgradeservice', function() {
            upgradeservice();  
        });
        
        
        jQuery(document).on('click', '#onlogin', function() {
            onlogin();  
        });
        
        
        jQuery('#customModal').on('hidden.bs.modal', function () {
          //$(this).css('overflow-y', 'hidden'); 
        })
        
    </script>
    <script>
    jQuery(document).ready(function() {
    jQuery("#customModal").modal({
        show: false,
        backdrop: 'static'
    });
});
    </script>
    <script>
    jQuery('#modalGeneratePassword').on('hide.bs.modal', function () {

    });
    </script>
    <style>#customModal.modal{
        pointer-events: none;
}
}</style>
<style>
.special{
    width: 100%;
    max-width: 600px;
}
</style>
HTML;
    }
});





add_hook('ClientAreaHeadOutput', 1, function($vars) {
    $template = $vars['templatefile'];
    if($template == 'configureproduct'){
            return <<<HTML
<script type="text/javascript">
function makeAjaxRequest() {

    $.ajax({
        url: '',
        type: 'POST',
        data: {
            action: 'getusername'
        },
        success: function(response) {
        
        var dataObject = JSON.parse(response);

        if (dataObject.redirect) {
        
            var labels = document.getElementsByTagName('label');
            for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent.trim() === 'Select account *') {
                    var selectId = labels[i].getAttribute('for');
                    break;
                }
            }
             
            $("#" + selectId).css('display', 'none');
            $('label[for="' + selectId + '"]').css('display', 'none');
            
            
            productitem = jQuery('.product-title').text();
             
            document.cookie = "productitem=" + productitem;
            
            jQuery('#' + selectId)[0].selectedIndex = 0;
            
           modalContent = 
           
           '<div style="display: flex; align-items: center; width: 100%;">' +
           '<p style="font-size: 13px; color: #666; opacity: 0;">Please logergdfgdf:</p>'
           +
           '<p style="font-size: 15px; color: #666;">Please log in to continue:</p>'
           +
           '<p style="font-size: 13px; color: #666; opacity: 0;">Please log in to:</p>'
           + 
           '</div>'+
    '<div class="modal-custom" style="text-align:center;padding: 12px;">' +
    '<a href="/index.php/login" class="btn btn-primary" id="onlogin">Login</a>' +
    '<button class="btn btn-secondary cancelButton">Cancel</button>' +
    '</div>';

            
                    
                    
                    
            createOrUpdateModal(modalContent);
            
            return false; 
            
        }
    
        var dataArray = Object.entries(dataObject);
    
        var nonEmptyValues = dataArray.filter(function(item) {
            return item[0].trim() !== ''; 
        });
        
        var labels = document.getElementsByTagName('label');
        for (var i = 0; i < labels.length; i++) {
            if (labels[i].textContent.trim() === 'Select account *') {
                var selectId = labels[i].getAttribute('for');
                break;
            }
        }
        
        $('#' + selectId).css('display', 'block');
        $('label[for="' + selectId + '"]').css('display', 'block');
        
         $('.form-group:has(label[for="' + selectId + '"])').css('display', 'block');
        
        
    
        var select = $('#' + selectId);
        select.empty();
    
        select.append('<option value="">Select account</option>');
    
        nonEmptyValues.forEach(function(item) {
            var username = item[0]; 
            var userId = item[1]; 
            
            select.append('<option value="' + userId + '">' + username + '</option>');
        });
        
        
    },
    error: function(xhr, status, error) {
        console.error('AJAX request failed: ' + error);
    }

    });
}


function upgradeservice(){
    
    var labels = document.getElementsByTagName('label');
    var selectId = '';
    
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Select account *') {
            selectId = labels[i].getAttribute('for');
            break;
        }
    }
    
    var selectedValue = document.getElementById(selectId).value;

    if(selectedValue){ 
        
        var url = '/upgrade.php?type=package&id=' + selectedValue;
        window.location.href = url; 
        
    }
}

function generateinvoice(){
    
    var labels = document.getElementsByTagName('label');
            var selectId = '';

    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Select account *') {
            selectId = labels[i].getAttribute('for');
            break;
        }
    }
    
    var selectedValue = $('#' + selectId).val();
    
        $.ajax({
        url: '', 
        type: 'POST',
        data: {
            action: 'generateinvoice',
            id: selectedValue
        },
        success: function (response) {
        
            var parsedResponse = JSON.parse(response);
            
            if(parsedResponse.result == 'success'){
                
                var url = '/viewinvoice.php?id=' + parsedResponse.invoiceid;
                
                window.location.href = url;

            }else{

                var url = '/viewinvoice.php?id=' + response;
                
                window.location.href = url;

            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX request failed: ' + error);
        }
    });
}


function renew(){
    
    var labels = document.getElementsByTagName('label');
            var selectId = '';

    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Select account *') {
            selectId = labels[i].getAttribute('for');
            break;
        }
    }
    
    var selectedValue = $('#' + selectId).val();
    
        $.ajax({
        url: '', 
        type: 'POST',
        data: {
            action: 'renew',
            id: selectedValue
        },
        success: function (response) {
        
            // $('#' +  selectId).after(response);
            
            // return false;
        
            var parsedResponse = JSON.parse(response);
            
            if(parsedResponse.result == 'success'){
                
                var url = '/viewinvoice.php?id=' + parsedResponse.invoiceid;
                window.location.href = url;
                
            }else{

                var url = '/viewinvoice.php?id=' + response;
                window.location.href = url;

            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX request failed: ' + error);
        }
    });
    
}
function paynow(){
    
    var labels = document.getElementsByTagName('label');
            var selectId = '';

    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Select account *') {
            selectId = labels[i].getAttribute('for');
            break;
        }
    }
    
    var selectedValue = $('#' + selectId).val();
    
    $.ajax({
        url: '', 
        type: 'POST',
        data: {
            action: 'paynow',
            id: selectedValue
        },
        success: function (response) {
        
        
            var url = '/viewinvoice.php?id=' + response;
            window.location.href = url;
        },
        error: function (xhr, status, error) {
            console.error('AJAX request failed: ' + error);
        }
    });
    
}


function makeupgradeservices(selectedValue) {
    $.ajax({
        url: '', 
        type: 'POST',
        data: {
            action: 'upgradeservices',
            id: selectedValue
        },
        success: function (response) {
        
            var responseObject = JSON.parse(response);
            
            var modalContent = ''; 

            if (responseObject.message === 'Invoice ID Not Found') {
                modalContent = '<p style="font-size: 15px; color: #666;">Please select one of the options to continue:</p>' +
                    '<div class="modal-custom" style="text-align:center;padding: 12px;">' +
                    '<button class="btn btn-primary" id="generateinvoice">Generate New invoice</button>' +
                    '<button class="btn btn-primary" id="upgradeservice">Upgrade/Downgrade</button>' +
                    '<button class="btn btn-secondary cancelButton">Cancel</button>' + '</div>';
            } else if (responseObject.status === 'Paid') {
                modalContent = '<p style="font-size: 16px; color: #de0909;">Currently Invoice already paid. What do you want to do?</p>' + 
                '<p style="font-size: 13px; color: #666;">Please select one of the options to continue:</p>' +
                    '<div class="modal-custom" style="text-align:center;padding: 12px;">' +
                    '<button class="btn btn-primary" style="margin-right: 15px;" id="renew">Renew</button>' +
                    '<button class="btn btn-primary" id="upgradeservice">Upgrade/Downgrade</button>' +
                    '<button class="btn btn-secondary cancelButton">Cancel</button>' + '</div>';
            } else if (responseObject.status === 'Unpaid') {
                modalContent = '<p style="font-size: 15px; color: #666;">Please select one of the options to continue:</p>' +
                
                    '<div class="modal-custom" style="text-align:center;padding: 12px;">' +
                    '<button class="btn btn-primary" id="paynow">Pay invoice</button>' +
                    '<button class="btn btn-primary" id="upgradeservice">Upgrade/Downgrade</button>' +
                    '<button class="btn btn-secondary cancelButton">Cancel</button>' + '</div>';
            }

            createOrUpdateModal(modalContent);
        },
        error: function (xhr, status, error) {
            console.error('AJAX request failed: ' + error);
        }
    });
}

function createOrUpdateModal(content) {
    $('#customModal').remove();

    var modalHtml = '<div class="modal" style="opacity: 1 !important;" id="customModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">' +
        '<div class="modal-dialog" style="pointer-events: all;" role="document">' +
        '<div class="modal-content">' +
        '<div class="modal-body">' + content + '</div>' +
        '</div>' +
        '</div>' +
        '</div>';

    $('body').append(modalHtml);

    $('#customModal').modal('show');

    
    $('#customModal').on('hidden.bs.modal', function (e) {
    var labels = document.getElementsByTagName('label');
    var selectId = '';

    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Select account *') {
            selectId = labels[i].getAttribute('for');
            break;
        }
    }
    //jQuery('#' + selectId)[0].selectedIndex = 0;
});
}

$(document).on('click', '#generateinvoice, #renew, #paynow, #onlogin, #upgradeservice, .cancelButton', function() {
    var buttonId = $(this).attr('id');
    if (buttonId === 'generateinvoice') {
    } else if (buttonId === 'renew') {
    } else if (buttonId === 'paynow') {
        paynow(); 
    } else if (buttonId === 'upgradeservice') {
        upgradeservice(); 
    } else {
    }
    $('#customModal').modal('hide');
    
});





function updateDivContent(selectId, divContent) {
    var existingDiv = jQuery('#' + selectId).next('.removebtn');

    if (existingDiv.length) {
        existingDiv.replaceWith(divContent);
    } else {
        jQuery('#' + selectId).after(divContent);
    }
}

</script>
HTML;
    }
    
});


add_hook('ClientAreaPage', 0, function($vars) {
    
function checkcredential($panel_id)
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


function extendLineMA($params, $returndata, $serviceid, $uid)
{


    $tblhosting = Capsule::table('tblhosting')->where('id', $serviceid)->first();


    $user_data = Capsule::table('tblclients')->where('id', $uid)->first();

    $name = $user_data->firstname;
    $lname = $user_data->lastname;
    
    $fullname = $name.$lname;

    $response = checkcredential($params->configoption1);
    $panel_details = Capsule::table('xui_paneldetails')->where('id', $params->configoption1)->get();
    $panel_url = $panel_details[0]->panel_link;

    if ($response == "yes") {
        $is_trial = $params->configoption5;
        $trial = ($is_trial == "trial") ? "trial=1" : "";
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');

        $replacements = array(
                $serviceid, $uid, $fullname, $user_data->email, $user_data->phonenumber
        );
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $selected_bouquets = isset($params->configoption12) && !empty($params->configoption12) ? trim($params->configoption12) : $params->configoption12;
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
        $service_username = trim($tblhosting->username);
        
        $service_password = trim($tblhosting->password);

        $userid = $tblhosting->dedicatedip;

        $MagAddress = isset($params->configoption12) && !empty($params->configoption12) ? trim($params->configoption12) : $params->configoption12;
        if (isset($userid) && !empty($userid)) {
            $is_trial = $params->configoption5;
            $package_id = ($is_trial == 'official') ? $params->configoption8 : $params->configoption7;
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
                customLog($parameters);
                return 'success';
            } else {
                $parameters = array(
                    'action' => 'Renew line (MagDevice)',
                    'request' => $panel_url . '/post.php?action=mag',
                    'response' => json_encode($result),
                );
                customLog($parameters);
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
            customLog($parameters);
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
        customLog($parameters);
    }
}

function extendLineM3($params, $returndata, $serviceid, $uid)
{
    
    $tblhosting = Capsule::table('tblhosting')->where('id', $serviceid)->first();
    
    $user_data = Capsule::table('tblclients')->where('id', $uid)->first();

    $name = $user_data->firstname;
    $lname = $user_data->lastname;
    
    $fullname = $name.$lname;
    
    $response = checkcredential($params->configoption1);
    $panel_details = Capsule::table('xui_paneldetails')->where('id', $params->configoption1)->get();
    $panel_url = $panel_details[0]->panel_link;
 
 
    if ($response == "yes") {
        $is_trial = $params->configoption5;
        $trial = ($is_trial == "trial") ? "trial=1" : "";
        $patterns = array('{$service_id}', '{$client_id}', '{$client_name}', '{$client_email}', '{$client_phonenumber}');
    
        $replacements = array(
                $serviceid, $uid, $fullname, $user_data->email, $user_data->phonenumber
        );
        $reseller_notes = str_replace($patterns, $replacements, $returndata['common_identifier']);
        $selected_bouquets = isset($params->configoption12) && !empty($params->configoption12) ? trim($params->configoption12) : $params->configoption12; 
        
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
        $service_username = trim($tblhosting->username);
        
        $service_password = trim($tblhosting->password);
        $userid = $tblhosting->dedicatedip;
        
        if (isset($userid) && !empty($userid)) {
            $is_trial = $params->configoption5;
            $package_id = ($is_trial == 'official') ? $params->configoption8 : $params->configoption7;
            
            
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
                customLog($parameters);
                return 'success';
            } else {
                $parameters = array(
                    'action' => 'Renew line (Streamline)',
                    'request' => $panel_url . '/post.php?action=line',
                    'response' => json_encode($result),
                );
                
                customLog($parameters);
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
            customLog($parameters);
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
        customLog($parameters);
    }
}


function customLog($parameters)
{
    Capsule::table('xui_logs')->insert([
        'date' => date("Y-m-d h:i:sa"),
        'action' => $parameters['action'],
        'request' => $parameters['request'],
        'response' => $parameters['response'],
    ]);
}


    if (isset($_POST['action']) && $_POST['action'] === 'getusername') {
        $command = 'GetClientsProducts';
        $postData = array(
            'clientid' => $_SESSION['uid'],
        );
        $adminUsername = '';
        
        if(empty($postData['clientid'])){
            
            $_SESSION['stored_data'] = '/cart.php?a=confproduct&i=3';
            
            $response = array(
                'redirect' => '/index.php/login'
            );
            
            
            
            echo json_encode($response);
            exit();
        }
        

        $results = localAPI($command, $postData, $adminUsername);
        
        
        $usernames = array(); 

        foreach ($results['products']['product'] as $product) {
            $username = $product['username'];
            $userId = $product['id'];
            $usernamesWithIds[$username] = $userId;

        }
    
        echo json_encode($usernamesWithIds);
        die();
    }
    
    
    if (isset($_POST['action']) && $_POST['action'] === 'paynow') {
        
        if(!empty($_POST['id'])){
                    $invoiceID = Capsule::table('tblinvoiceitems')->where('relid', $_POST['id'])->count();
        
        if($invoiceID > 1){
            $invoiceID = Capsule::table('tblinvoiceitems')->where('relid', $_POST['id'])->get();
            
            $invoiceIds = [];
        
        foreach ($invoiceID as $invoice) {
            $invoiceIds[] = $invoice->invoiceid;
        }
        
        $resultsArray = []; 

        foreach ($invoiceIds as $invoiceId) {
            $command = 'GetInvoice';
            $postData = array('invoiceid' => $invoiceId);
            $adminUsername = '';
        
            $result = localAPI($command, $postData, $adminUsername);
        
            $resultsArray[] = $result;
        }
        
        
        $unpaidInvoices = array();

        foreach ($resultsArray as $invoice) {
            if ($invoice['status'] === 'Unpaid') {
                $unpaidInvoices[] = $invoice;
            }
        }
        
        
        if (!empty($unpaidInvoices)) {
            $invoiceID = $unpaidInvoices[0]['invoiceid']; 
            
            $command = 'GetInvoice';
            $postData = array(
                'invoiceid' => $invoiceID,
            );
            $adminUsername = '';
            
            $results = localAPI($command, $postData, $adminUsername);
            
            
            $id = $results['invoiceid'];
        
            echo $id; exit();  
        }
        
        
        }else{
            
            $invoiceID = Capsule::table('tblinvoiceitems')->where('relid', $_POST['id'])->value('invoiceid');
        
            $command = 'GetInvoice'; 
            $postData = array(
                'invoiceid' => $invoiceID,
            );
            $adminUsername = '';
            
            $results = localAPI($command, $postData, $adminUsername);
        
            $id = $results['invoiceid'];
        
            echo $id; exit();     
            
        }
        }
        
    }
    
    
    
    if (isset($_POST['action']) && $_POST['action'] === 'generateinvoice') {
        
       $command = 'GetClientsProducts';
        $postData = array(
            'clientid' => $_SESSION['uid'],
        );
        
        $adminUsername = '';
        

        $results = localAPI($command, $postData, $adminUsername);
        
        if (!empty($results['products']['product'][0]['name'])) {
            $name = $results['products']['product'][0]['name'];
            $paymentmethod = $results['products']['product'][0]['paymentmethod'];
            $billingcycle = $results['products']['product'][0]['billingcycle'];
            $nextduedate = $results['products']['product'][0]['nextduedate'];
            $id = $results['products']['product'][0]['id'];
            $recurringamount = $results['products']['product'][0]['recurringamount'];
            $pid = $results['products']['product'][0]['pid'];
            
        }

    
        
        $command = 'CreateInvoice';

        $postData = array(
            'userid' => $_SESSION['uid'],
            'status' => 'Unpaid',
            'sendinvoice' => '1',
            'paymentmethod' => $paymentmethod,
            'taxrate' => '0.00',
            'duedate' => $nextduedate,
            'itemdescription1' => $name,   
            'itemamount1' => $recurringamount,
            'itemtaxed1' => '0',  
            
        );
        $adminUsername = ''; 
        
        $invoiceID = localAPI($command, $postData, $adminUsername);
        
        if ($invoiceID && is_array($invoiceID) && isset($invoiceID['result']) && $invoiceID['result'] === 'success') {
                
                $invoiceIdValue = $invoiceID['invoiceid']; 
                $statusValue = $invoiceID['status']; 
                
                try {
                    $update_data =  [
                        'type' => 'hosting',
                        'relid' => $_POST['id'],
                    ];
                    Capsule::table('tblinvoiceitems')
                       ->where('invoiceid', '=', $invoiceIdValue)
                       ->update($update_data);
                } catch(\Illuminate\Database\QueryException $ex){
                    echo $ex->getMessage();
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                
                
                
            }
        
        echo json_encode($invoiceID); exit();
        
    }
    
    
    
    if (isset($_POST['action']) && $_POST['action'] === 'renew') {
        
        if(!empty($_POST['id'])){
            
        // $service_id = $_POST['id'];    
        // $userid = Capsule::table('tblhosting')
        // ->where('id', $_POST['id'])
        // ->first();
        
        // $uid = $userid->userid;
        
        // $params = Capsule::table('tblproducts')
        // ->where('id', $userid->packageid)
        // ->first();
        
        // $xtreamConfig = Capsule::table('xui_settings')->get();
    
    
        // $returndata = array();
        // if (isset($xtreamConfig) && !empty($xtreamConfig)) {
        //     foreach ($xtreamConfig as $config) {
        //         $returndata[$config->setting] = $config->value;
        //     }
        // }
        // if ($params->configoption3 == 'streamlineonly') {
        //     $return = extendLineM3($params, $returndata, $service_id, $uid);
            
        //     print_r($return); die;
        //     return $return;
        // } elseif ($params->configoption3 == 'magdevice') {
        //     $return = extendLineMA($params, $returndata, $service_id, $uid);
        //     print_r($return); die;
        //     return $return;
        // }
   
        
        $invoiceID = Capsule::table('tblinvoiceitems')
        ->where('relid', $_POST['id'])
        ->get();
        
        
        $invoiceIds = [];
        
        foreach ($invoiceID as $invoice) {
            $invoiceIds[] = $invoice->invoiceid;
        }
        
        $resultsArray = []; 
        
        foreach ($invoiceIds as $invoiceId) {
            $command = 'GetInvoice';
            $postData = array('invoiceid' => $invoiceId);
            $adminUsername = '';
        
            $result = localAPI($command, $postData, $adminUsername);
        
            $resultsArray[] = $result;
        }
        
        
        $unpaidInvoices = array();

        foreach ($resultsArray as $invoice) {
            if ($invoice['status'] === 'Unpaid') {
                $unpaidInvoices[] = $invoice;
            }
        }
        
        
        if (!empty($unpaidInvoices)) {
            $invoiceID = $unpaidInvoices[0]['invoiceid']; 
            echo json_encode($invoiceID);
            exit();
        }else{
            
            
        $invoiceid = Capsule::table('tblinvoiceitems')->where('relid', $_POST['id'])->value('invoiceid');
        
        
            
        $command = 'GetInvoice';
        $postData = array( 'invoiceid' => $invoiceid,);
        $adminUsername = '';
            
        $results = localAPI($command, $postData, $adminUsername);
        
        if ($results['result'] === 'success'){
            
            $user_id = $results['userid'];
            $tblhosting = Capsule::table('tblhosting')->where('userid', $user_id)->first();
            
            
            
            if($tblhosting->billingcycle == 'Monthly'){ 
                
                $result = $tblhosting->nextduedate;
                
                $duedate = date('Y-m-d', strtotime('+1 month', strtotime($result)));
                
                // try {
                //     $update_data =  [
                //         'nextduedate' => $duedate,
                //     ];
                //     Capsule::table('tblhosting')
                //       ->where('userid', '=', $user_id)
                //       ->update($update_data);
                // } catch(\Illuminate\Database\QueryException $ex){
                //     echo $ex->getMessage();
                // } catch (Exception $e) {
                //     echo $e->getMessage();
                // }
                
            }
            
        }
        
        
        
        $user_id = $results['userid'];
        
        $itemDescription = $results['items']['item'][0]['description'];

        if($results['status'] == 'Paid'){
            
            $command = 'CreateInvoice';

            $postData = array(
                'userid' => $user_id,
                'status' => 'Unpaid',
                'sendinvoice' => '1',
                'paymentmethod' => $results['paymentmethod'],
                'taxrate' => '0.00',
                'duedate' => $duedate,
                'itemdescription1' => $itemDescription,   
                'itemamount1' => $results['subtotal'],
                'itemtaxed1' => '0', 
                
            );
                
            $adminUsername = '';
            
            $invoiceID = localAPI($command, $postData, $adminUsername);
            

            if ($invoiceID && is_array($invoiceID) && isset($invoiceID['result']) && $invoiceID['result'] === 'success') {
                
                $invoiceIdValue = $invoiceID['invoiceid']; 
                $statusValue = $invoiceID['status']; 
                 
                try {
                    $update_data =  [
                        'type' => 'hosting',
                        'relid' => $_POST['id'],
                    ];
                    Capsule::table('tblinvoiceitems')
                       ->where('invoiceid', '=', $invoiceIdValue)
                       ->update($update_data);
                } catch(\Illuminate\Database\QueryException $ex){
                    echo $ex->getMessage();
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                
                
                
            }
            
            echo json_encode($invoiceID); exit();
            
        }else{
             echo $invoiceID; exit();
        }
            
        }
        
        }
        
    }
    
    
    if (isset($_POST['action']) && $_POST['action'] === 'upgradeservices') {
    
        if(!empty($_POST['id'])){
            
        $invoiceID = Capsule::table('tblinvoiceitems')->where('relid', $_POST['id'])->count();
        
        if($invoiceID > 1){
            $invoiceID = Capsule::table('tblinvoiceitems')->where('relid', $_POST['id'])->get();
            
            $invoiceIds = [];
        
        foreach ($invoiceID as $invoice) {
            $invoiceIds[] = $invoice->invoiceid;
        }
        
        
        
        $resultsArray = []; 
  
        foreach ($invoiceIds as $invoiceId) {
            $command = 'GetInvoice';
            $postData = array('invoiceid' => $invoiceId);
            $adminUsername = '';
        
            $result = localAPI($command, $postData, $adminUsername);
        
            $resultsArray[] = $result;
        }
        
        $unpaidInvoices = array();

        foreach ($resultsArray as $invoice) {
            if ($invoice['status'] === 'Unpaid') {
                $unpaidInvoices[] = $invoice;
            }
        }
        
        if(empty($unpaidInvoices)){
            if ($invoice['status'] === 'Paid') {
                $unpaidInvoices[] = $invoice;
            }
        }
        
        if (!empty($unpaidInvoices)) {
            $invoiceID = $unpaidInvoices[0]['invoiceid']; 
            
            $command = 'GetInvoice';
            $postData = array(
                'invoiceid' => $invoiceID,
            );
            $adminUsername = '';
            
            $results = localAPI($command, $postData, $adminUsername);
            
            echo json_encode($results); exit();  
        }
        
        
        }else{
            
            $invoiceID = Capsule::table('tblinvoiceitems')->where('relid', $_POST['id'])->value('invoiceid');
        
            $command = 'GetInvoice'; 
            $postData = array(
                'invoiceid' => $invoiceID,
            );
            $adminUsername = '';
            
            $results = localAPI($command, $postData, $adminUsername);
        
            echo json_encode($results); exit();   
            
        }
            
        }
        
        
        $command = 'GetClientsProducts';
        $postData = array(
            'clientid' => $_SESSION['uid'],
        );
        
        $adminUsername = '';

        if ($results['result'] === 'success' && isset($results['products'])) {
        $matchingProducts = array_filter($results['products']['product'], function($product) use ($requestedId) {
            return $product['id'] == $requestedId;
        });
        
        
        foreach ($matchingProducts as $product) {
            $paymentmethod   = $product['paymentmethod'];
            $billingcycle    = $product['billingcycle'];
            $id              = $product['id'];
            $pid             = $product['pid'];
            $recurringamount = $product['recurringamount'];
            $nextduedate     = $product['nextduedate'];
            $name     = $product['name'];
        }
        
        $command = 'CreateInvoice';

        $postData = array(
            'userid' => $_SESSION['uid'],
            'status' => 'Unpaid',
            'sendinvoice' => '1',
            'paymentmethod' => $paymentmethod,
            'taxrate' => '0.00',
            'duedate' => $nextduedate,
            'itemdescription1' => $name,   
            'itemamount1' => $recurringamount,
            'itemtaxed1' => '0',  
            
        );
        $adminUsername = ''; 
        
        if ($results['result'] == 'success' && isset($results['invoiceid'])) {
            $invoiceID = $results['invoiceid'];
            echo $invoiceID; 
            exit();
        }
          
    }
        
    }
});
?>