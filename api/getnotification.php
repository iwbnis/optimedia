<?php
use WHMCS\Database\Capsule;
define("CLIENTAREA", true);
require __DIR__ . '/init.php';

global $smarty;
global $clientsdetails;

if (isset($_POST['clientid'])) {

    $clientId = $_POST['clientid'];
    $client = WHMCS\User\Client::find($clientId);    
    if (!empty($client)) {
        $alerts = new WHMCS\User\Client\AlertFactory($client);
        $clientAlerts = $alerts->build();
        if (!empty($clientAlerts)) {
            print_r("dtails".$clientAlerts);die;
        }else{
            echo "Notification not found!";    
        }
        
    }else{
        echo "Client not found!";
    }
}else{
    echo "Post All fields!";
}   

?>



