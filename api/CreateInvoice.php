<?php
$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';
$userId = $_POST['userid'];
$status = $_POST['status'];
$sendinvoice = $_POST['sendinvoice'];
$paymentmethod = $_POST['paymentmethod'];
$date = $_POST['date'];
$duedate = $_POST['duedate'];
$itemdescription1 = $_POST['itemdescription1'];
$itemamount1 = $_POST['itemamount1'];
$itemtaxed1 = $_POST['itemtaxed1'];
$itemdescription2 = $_POST['itemdescription2'];
$itemamount2 = $_POST['itemamount2'];
$itemtaxed2 = $_POST['itemtaxed2'];
$autoapplycredit = $_POST['autoapplycredit'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,

     http_build_query(
        array(
            'action' => 'CreateInvoice',
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'userid' => $userId,
            'status' => $status,
            'sendinvoice' => $sendinvoice,
            'paymentmethod' => $paymentmethod,
            'date' => $date,
            'duedate' => $duedate,
            'itemdescription1' => $itemdescription1,
            'itemamount1' => $itemamount1,
            'itemtaxed1' => $itemtaxed1,
            'itemdescription2' => $itemdescription2,
            'itemamount2' => $itemamount2,
            'itemtaxed2' => $itemtaxed2,
            'autoapplycredit' => $itemtaxed2,
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
$jsonData = json_decode($response, true);
$jsonResponse = json_encode($jsonData);

echo $jsonResponse;
?>
