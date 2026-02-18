<?php
add_hook('AfterShoppingCartCheckout', 1, function($vars) {
	$payload = json_encode( $vars );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://apihubs.cc/stagging');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $payload);
        $result = curl_exec($ch);
});


add_hook('AcceptOrder', 1, function($vars) {
        $payload = json_encode( $vars );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://apihubs.cc/stagging1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $payload);
        $result = curl_exec($ch);
});


add_hook('OrderPaid', 1, function($vars) {
        $payload = json_encode( $vars );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://apihubs.cc/stagging1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $payload);
        $result = curl_exec($ch);
});

add_hook("InvoicePaid", 1, function($vars) {
        $payload = json_encode( $vars );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://apihubs.cc/stagging1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $payload);
        $result = curl_exec($ch);
});
