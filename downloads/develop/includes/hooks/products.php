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

function homepage_products_hook($vars) {
   $currencyId   = (isset($_GET['currency']) ? intval($_GET['currency']) : $_SESSION['currency']);
   $currencyList = Capsule::table('tblcurrencies')->get();
    if(empty($currencyid) && !empty($currencyList)) {
        foreach($currencyList as &$currency) {
            if(empty($currencyId) && $currency->default) {
                $currencyId = $currency->id;
            }
        }
    }
    
    $products   = Capsule::table('tblproducts')
                            ->join('tblpricing', 'tblproducts.id', '=', 'tblpricing.relid')
                            ->join('tblcurrencies', 'tblpricing.currency', '=', 'tblcurrencies.id')
                            ->select('tblproducts.*','tblpricing.*', 'tblcurrencies.*')
                            ->where('tblproducts.gid','2')
                            ->where('tblproducts.hidden','0')
                            ->where('tblpricing.currency', $currencyId)
                            ->where('tblpricing.type', 'product')
                            ->orderBy("tblproducts.order", "ASC")
                            ->get();
    
    $encodedata = json_encode($products);
    $decodedata = json_decode($encodedata, true);

   return array("myproducts" => $decodedata);
}

add_hook("ClientAreaPage", 1, "homepage_products_hook");
