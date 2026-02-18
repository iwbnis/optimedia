<?php
/**
 * Price Table Hook Function
 *
 * Please refer to the documentation @ https://docs.whmcs.com/Hooks for more information
 * The code in this hook is commented out by default. Uncomment to use.
 *
 * @package    WHMCS
 * @author     WHMCS Limited <development@whmcs.com>
 * @copyright  Copyright (c) WHMCS Limited 2005-2018
 * @license    https://www.whmcs.com/license/ WHMCS Eula
 * @version    $Id$
 * @link       https://www.whmcs.com/
 */

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");


add_hook('InvoicePaid', 1, function($vars) 
{
    $invoiceid = $vars['invoiceid']; 
    $getAinfo  = Capsule::table('tblinvoiceitems')->where('invoiceid','=',$invoiceid)->where('type','=','Hosting')->first();
    $hid = $getAinfo->relid;
    if (!empty($hid)) {
        $getpid = Capsule::table('tblhosting')->where('id','=',$hid)->first();
        $packid = $getpid->packageid;
    }
    if (!empty($packid)) {
        $getservertype = Capsule::table('tblproducts')->where('id','=',$packid)->first();
        $servertype    = $getservertype->servertype;
        $billingcycle  = $getservertype->billingcycle;
        $nextduedate   = $getservertype->nextduedate;
    }


    if (!empty($hid) && !empty($packid) && !empty($servertype)) {
        if ($servertype == 'NXTbyKak' && $billingcycle == 'Monthly') {
            $onemonth =  date('Y-m-d',strtotime('+30 days',strtotime($nextduedate)));
            Capsule::table('tblhosting')->where('id','=',$hid)->update( [
                'nextduedate' => $onemonth,
            ]);

        } elseif ($servertype == 'NXTbyKak' && $billingcycle == 'Quarterly') {
            $onemonth1 =  date('Y-m-d',strtotime('+92 days',strtotime($nextduedate)));
            Capsule::table('tblhosting')->where('id','=',$hid)->update( [
                'nextduedate' => $onemonth1,
            ]);
               
        } elseif ($servertype == 'NXTbyKak' && $billingcycle == 'Semi-Annually') {
            $onemonth2 =  date('Y-m-d',strtotime('+183 days',strtotime($nextduedate)));
            Capsule::table('tblhosting')->where('id','=',$hid)->update( [
                'nextduedate' => $onemonth2,
            ]);              
        } elseif ($servertype == 'NXTbyKak' && $billingcycle == 'Annually') {
            $onemonth3 =  date('Y-m-d',strtotime('+365 days',strtotime($nextduedate)));
            Capsule::table('tblhosting')->where('id','=',$hid)->update( [
                'nextduedate' => $onemonth3,
            ]);         
        } elseif ($servertype == 'NXTbyKak' && $billingcycle == 'Biennially') {
            $onemonth4 =  date('Y-m-d',strtotime('+730 days',strtotime($nextduedate)));
            Capsule::table('tblhosting')->where('id','=',$hid)->update( [
                'nextduedate' => $onemonth4,
            ]);        
        } elseif ($servertype == 'NXTbyKak' && $billingcycle == 'Triennially') {
            $onemonth5 =  date('Y-m-d',strtotime('+1095 days',strtotime($nextduedate)));
            Capsule::table('tblhosting')->where('id','=',$hid)->update( [
                'nextduedate' => $onemonth5,
            ]);        
        }
    }
});


add_hook('AcceptOrder', 1, function($vars) {
    //echo '<pre>'; print_r($vars); die();
    if ($_GET['a']=='complete') {
        if (!empty($vars['orderid'])) {
            header('location:cart.php?a=complete');
        }
    } 

});  


add_hook('ClientAreaPage', 1, function($vars) {
    global $smarty;
    global $CONFIG;
    
    $templatefile = $smarty->tpl_vars['templatefile']->value;
    if($templatefile =='homepage'){
        //echo date('Y-m-d',strtotime('+92 days',strtotime('2022-07-21')))  ; die();  
    }
});




add_hook('AdminAreaFooterOutput', 1, function($vars) {

if (isset($_GET["aid"])) {

   // $getpak = Capsule::table('tblhosting')->where('id', '=',  $_GET["id"])->first();

    //if ($getpak->packageid == 79) {
      
        if (isset($_POST['myid'])) {
            $command = 'SendEmail';
            $postData = array(
                'messagename' => 'VPN',
                'id' => $_POST['myid'],
            );
            $adminUsername = ''; // Optional for WHMCS 7.2 and later
            $results = localAPI($command, $postData, $adminUsername);
            if ($results) {
                echo "1"; die;
            }
        }

        $prodId = $_GET["id"];
        $userId = $_GET["userid"];

    return <<<HTML
<style>
    a#btnResendWelcomeEmail {
        display: none;
    }
</style>
<script type="text/javascript">

$(document).ready(function() {

$(".dropdown-menu-right li:nth-child(3)").append("<a href='' id='myresendtn'><i class='fas fa-star fa-fw'></i>Resend Welcome Email</a>");
    
    $( "#myresendtn" ).click(function() {
        $.ajax({
            type: "POST",
            url: '',
            data: {myid:'$prodId'},
            success: function(response)
            {
                window.location = 'clientsemails.php?userid=$userId&success=1';   
            }
        });    
        return false;
    });    
});

</script>
HTML;

//}

}

});


add_hook('AfterShoppingCartCheckout', 1, function($vars) { 
    
    foreach ($vars['ServiceIDs'] as $ServiceIDvalue) {
        $getUsername = Capsule::table('tblcustomfieldsvalues')->where('relid', '=', $ServiceIDvalue)->where('fieldid', '=', '308')->first();
        $getPassword = Capsule::table('tblcustomfieldsvalues')->where('relid', '=', $ServiceIDvalue)->where('fieldid', '=', '309')->first();

        $command = 'UpdateClientProduct';
        $postData = array(
            'serviceid' => $ServiceIDvalue,
            'serviceusername' => $getUsername->value,
            'servicepassword' => $getPassword->value,
        );
        $adminUsername = ''; // Optional for WHMCS 7.2 and later

        $results = localAPI($command, $postData, $adminUsername);

    }

    if (!empty($vars['AddonIDs'])) {

        foreach ($vars['AddonIDs'] as $key => $AddonIDsvalue) {

            $getUsernameo = Capsule::table('tblcustomfieldsvalues')->where('relid', '=', $vars['ServiceIDs'][$key])->where('fieldid', '=', '308')->first();
            $getPasswordo = Capsule::table('tblcustomfieldsvalues')->where('relid', '=', $vars['ServiceIDs'][$key])->where('fieldid', '=', '309')->first();

            $getadonU = Capsule::table('tblcustomfieldsvalues')->where('relid', '=', $AddonIDsvalue)->where('fieldid', '=', '604')->first();

            $getadonP = Capsule::table('tblcustomfieldsvalues')->where('relid', '=', $AddonIDsvalue)->where('fieldid', '=', '605')->first();


            $insert_data =  array(
                'relid' => $AddonIDsvalue,
                'fieldid' => '604',
                'value' => $getUsernameo->value,

            );
            if (empty($getadonU)) {
                Capsule::table('tblcustomfieldsvalues')->insert($insert_data);
            }else{
                Capsule::table('tblcustomfieldsvalues')->where('relid', '=',$AddonIDsvalue)->where('fieldid', '=','604')->update($insert_data);
            }   
            

            $insert_data2 =  array(
                'relid' => $AddonIDsvalue,
                'fieldid' => '605',
                'value' => $getPasswordo->value,

            );
            if (empty($getadonP)) {
                Capsule::table('tblcustomfieldsvalues')->insert($insert_data2);
            }else{
                Capsule::table('tblcustomfieldsvalues')->where('relid', '=',$AddonIDsvalue)->where('fieldid', '=','605')->update($insert_data2);
            }  


            $command = 'SendEmail';
            $postData = array(
                'messagename' => 'VPN',
                'id' => $vars['ServiceIDs'][$key],
            );
            $adminUsername = ''; // Optional for WHMCS 7.2 and later

            $results = localAPI($command, $postData, $adminUsername);


        }

    }


    

});  