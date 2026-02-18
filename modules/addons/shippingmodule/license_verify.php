<?php
require_once('../../../init.php');

use WHMCS\Database\Capsule;

   $key = $_GET['key'];
   $domain = $_GET['domain'];

   if(empty($key) || empty($domain))
   {
     echo 'Invalid Key';

   }
   else
   {


     $status = Capsule::table('mod_shippingmodule_license')
             ->where("license_key", "=", $key)
             ->where("license_domain", "=", $domain)
             ->value('status');

       if(!empty($status))
       {
         echo $status;
       }
       else {
         echo 'Unknown Error!';
       }

   }

   die();



 ?>
