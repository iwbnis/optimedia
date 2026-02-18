<?php
if (!defined("WHMCS"))
die("No se puede acceder a este archivo directamente");
// definiciones a usar para obtener vars de WHMCS
use WHMCS\ClientArea;
use WHMCS\Database\Capsule;
require_once 'URLWHMCS/init.php';

/* Defining object to get elements*/
$ca = new ClientArea();
/* initPage() let get all data */
$ca->initPage();
$uid_client = $_SESSION["uid"];
$adminid_admin = $_SESSION["adminid"];
/* Hack to get all var definedes*/
//print_r (get_defined_vars());
$vars = get_defined_vars();

if ($uid_client == 1) {
/* Hack 2 , Get property of a object protected */
function get_property(object $object, string $property) {
    $array = (array) $object;
    $propertyLength = strlen($property);
    foreach ($array as $key => $value) {
        if (substr($key, -$propertyLength) === $property) {
            return $value;
        }
    }
}

/*Accessing for each level of a var.
$level_1 > $level_2 > $level_3
Basically, we use get_property to access to each level and get exact property we want.*/

/* Level of access*/
$level_1 = get_property($vars["ca"], 'templateVariables');
$level_2 = $level_1["clientAlerts"];
$level_3 = get_property($level_2, 'items');

/* Response final defined empty for init*/
$response = array();
/* Creating a counter for final interaction and intercept final items / data */ 
$level_3_counter = 0;

foreach ($level_3 as $key => $value) {
    /* Interact == just to get what $var[$key] are exploring */
    $iteract = $level_3[$key];
    /*
    $message intercepting message
    $link intercepting link
    $linkText result : "Pagar Ahora"
    */
    $message = get_property($iteract, 'message');
    $link = get_property($iteract, 'link');
    $linkText = get_property($iteract, 'linkText');
   # array_push($response[$level_3_counter], $intercept);
   $response[$level_3_counter] = array();
   $response[$level_3_counter]["message"] = array();
   $response[$level_3_counter]["message"] = $message;
   $response[$level_3_counter]["link"] = array();
   $response[$level_3_counter]["link"] = $link;
   $response[$level_3_counter]["linkText"] = array();
   $response[$level_3_counter]["linkText"] = $linkText;

   $level_3_counter++;
}
}
/* Generating response ... for View*/
/*
foreach ($response as $key1 => $value1) {
    echo '
    <span>'.$response[$key1]['message'].'</span>
    <a href="'. $response[$key1]['link'] .'"> '. $response[$key1]['linkText'] .'</a> <br>
    
    ';
    }
*/

?>