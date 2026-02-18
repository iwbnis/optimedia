<?php
$domain = "protv.mov";

// Get the IP address associated with the domain
$ip = gethostbyname($domain);

if ($ip == $domain) {
    echo "DNS resolution failed for domain: $domain\n";
} else {
    echo "IP address for $domain is: $ip\n";

    // Test if we can connect to the server
    $url = "https://$domain/xmltv.php?username=saad&password=saad";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "cURL Error: " . curl_error($ch) . "\n";
    } else {
        echo "Connection successful!\n";
        echo "Response: " . substr($response, 0, 200) . "...\n"; // Print the first 200 characters of the response
    }

    curl_close($ch);
}
?>
