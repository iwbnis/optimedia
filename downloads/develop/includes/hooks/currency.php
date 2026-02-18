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
use WHMCS\Session;

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

function multiple_currency_hook($vars) {
    $currencyId   = (isset($_GET['currency']) ? intval($_GET['currency']) : $_SESSION['currency']);
    
    $currencyList = Capsule::table('tblcurrencies')->get();
    if(!empty($currencyList)) {
        $template = !empty($vars['template']) ? $vars['template'] : '';
        $flags    = getFlags();
        foreach($currencyList as &$currency) {
            $currency->flag = 'templates/' . $template . '/' . $flags[$currency->code];
            if(empty($currencyId) && $currency->default) {
                $currencyId = $currency->id;
            }
        }
    }
    
    $encodedata = json_encode($currencyList);
    $decodedata = json_decode($currencyList, true);
    
    $urlForCurrentcy = getUrlForCurrency($currencyId);
    $isQueryExist    = strpos($urlForCurrentcy, "?") !== false ? true : false;
    
    return array("multiCurrency" => $decodedata, 'selectedCurrency' => $currencyId, 'urlForCurrentcy' => $urlForCurrentcy, 'isQueryExist' => $isQueryExist);
}

add_hook("ClientAreaPage", 1, "multiple_currency_hook");

// get URL for currency withour currency query string
function getUrlForCurrency($currencyId) {
    $whmcsQueryStr   = [];
    $actualLink      = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $whmcsCurrentUrl = parse_url($actualLink);
    if(!empty($whmcsCurrentUrl['query'])) {
        parse_str($whmcsCurrentUrl['query'], $whmcsQueryStr);
    }

    if(!empty($whmcsQueryStr)) {
        foreach($whmcsQueryStr as $queryKey => $whmcsQuery) {
            if(strpos($queryKey, "currency") !== false) {
                unset($whmcsQueryStr[$queryKey]);    
            }
        }
    }
    
    $whmcsCurrentUrl['query']  = urldecode(http_build_query($whmcsQueryStr, '', '&amp;'));

    $fullUrl = unparseUrl($whmcsCurrentUrl);
    
    return $fullUrl;
}

// prepare full URL
function unparseUrl( $parsed_url , $ommit = array( ) ) {
    $url           = '';
    $p             = array();
    $p['scheme']   = isset( $parsed_url['scheme'] ) ? $parsed_url['scheme'] . '://' : '';
    $p['host']     = isset( $parsed_url['host'] ) ? $parsed_url['host'] : '';
    $p['port']     = isset( $parsed_url['port'] ) ? ':' . $parsed_url['port'] : '';
    $p['user']     = isset( $parsed_url['user'] ) ? $parsed_url['user'] : '';
    $p['pass']     = isset( $parsed_url['pass'] ) ? ':' . $parsed_url['pass']  : '';
    $p['pass']     = ( $p['user'] || $p['pass'] ) ? $p['pass']."@" : '';
    $p['path']     = isset( $parsed_url['path'] ) ? $parsed_url['path'] : '';
    $p['query']    = !empty( $parsed_url['query'] ) ? '?' . $parsed_url['query'] : '';
    $p['fragment'] = isset( $parsed_url['fragment'] ) ? '#' . $parsed_url['fragment'] : '';
    if ( $ommit ) {
        foreach ( $ommit as $key ) {
            if ( isset( $p[ $key ] ) ) {
                $p[ $key ] = '';	
            }
        }
    }
      
    return $p['scheme'].$p['user'].$p['pass'].$p['host'].$p['port'].$p['path'].$p['query'].$p['fragment']; 
}

// ************************************************************************************************************************
// Description: All flag list with currency code (We used flag from https://lipis.github.io/flag-icon-css/flags/4x3/us.svg.)
// key: currency code from WHMCS setting (Configuration > System Settings > Currencies). https://docs.whmcs.com/Currencies
// value: flag image path. Location: templates/{your-template}/img/flags/
//
// Instruction: the key needs to be same as the currency code. 
// Example: 'USD'. We have set the currency code USD from Configuration > System Settings > Currencies
// ************************************************************************************************************************
function getFlags() {
    return [
        'AED' => 'img/flags/AED.svg',
        'AUD' => 'img/flags/AUD.svg',
        'BDT' => 'img/flags/BDT.svg',
        'BRL' => 'img/flags/BRL.svg',
        'COP' => 'img/flags/COP.svg',
        'CRC' => 'img/flags/CRC.svg',
        'DEM' => 'img/flags/DEM.svg',
        'EGP' => 'img/flags/EGP.svg',
        'ESP' => 'img/flags/ESP.svg',
        'FRF' => 'img/flags/FRF.svg',
        'GBP' => 'img/flags/GBP.svg',
        'IDR' => 'img/flags/IDR.svg',
        'ILS' => 'img/flags/ILS.svg',
        'INR' => 'img/flags/INR.svg',
        'ITL' => 'img/flags/ITL.svg',
        'MXN' => 'img/flags/MXN.svg',
        'NGN' => 'img/flags/NGN.svg',
        'NLG' => 'img/flags/NLG.svg',
        'PKR' => 'img/flags/PKR.svg',
        'PLN' => 'img/flags/PLN.svg',
        'SAR' => 'img/flags/SAR.svg',
        'TRY' => 'img/flags/TRY.svg',
        'USD' => 'img/flags/USD.svg',
        'CAD' => 'img/flags/CAD.svg',
        'NZD' => 'img/flags/NZD.svg',
        'EUR' => 'img/flags/EUR.svg',

		
    ];
}
