<?php
if (!defined("WHMCS"))
die("Can't access the file directly!");

use WHMCS\View\Menu\Item as MenuItem;
use Illuminate\Database\Capsule\Manager as Capsule;

add_hook("ShoppingCartValidateProductUpdate", 1, function($vars){
	$client = Menu::context("client");
	   if (!is_null($client) && $client) {
	 if ($client->email_verified==2)
{
  return [
	'Please check the email and active your account first',
    ];
}
}

});

?>
