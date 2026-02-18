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

function homepage_pricetable_hook($vars) {
    $currencyId   = (isset($_GET['currency']) ? intval($_GET['currency']) : $_SESSION['currency']);
    $currencyList = Capsule::table('tblcurrencies')->get();
    if(empty($currencyid) && !empty($currencyList)) {
        foreach($currencyList as &$currency) {
            if(empty($currencyId) && $currency->default) {
                $currencyId = $currency->id;
            }
        }
    }
    
    $domainPrices = Capsule::table('tbldomainpricing')
                   ->join('tblpricing', 'tbldomainpricing.id', '=', 'tblpricing.relid')
                   ->join('tblcurrencies', 'tblpricing.currency', '=', 'tblcurrencies.id')
                   ->select('tbldomainpricing.extension','tblpricing.*', 'tblcurrencies.*')
                   ->where('tblpricing.type', 'domainregister')
                   ->where('tblpricing.currency', $currencyId)
                   ->get();
                   
    $encodedata = json_encode($domainPrices);
    $decodedata = json_decode($encodedata, true);
    
    return array("pricetable" => $decodedata);
}

add_hook("ClientAreaPage", 1, "homepage_pricetable_hook");
