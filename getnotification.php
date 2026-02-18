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
            $data = array();
            foreach ($clientAlerts as $alert) {
                $data[] = array(
                    'message' => $alert->getMessage(),
                    'severity' => $alert->getSeverity(),
                    'link' => $alert->getLink(),
                    'linkText' => $alert->getLinkText()
                );
            }
        }

        if (!empty($data)) {
            $response = array(
                'status' => 'success',
                'message' => 'Notifications found!',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 'success',
                'message' => 'No notifications found!',
                'data' => array()
            );
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Client not found!'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Post All fields!'
    );
}

header('Content-Type: application/json');
echo json_encode($response);
?>
