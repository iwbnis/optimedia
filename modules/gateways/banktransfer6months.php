<?php

# Bank Transfer Payment Gateway Module

if (!defined("WHMCS")) die("This file cannot be accessed directly");

function banktransfer6months_config() {

    $configarray = array(
     "FriendlyName" => array(
        "Type" => "System",
        "Value" => "Bank Transfer 6Months"
        ),
     "instructions" => array(
        "FriendlyName" => "Bank Transfer Instructions",
        "Type" => "textarea",
        "Rows" => "5",
        "Value" => "Bank Name:\nPayee Name:\nSort Code:\nAccount Number:",
        "Description" => "The instructions you want displaying to customers who choose this payment method - the invoice number will be shown underneath the text entered above",
        ),
    );

    return $configarray;

}

function banktransfer6months_link($params) {
    global $_LANG;

    $url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i'; 
    $string = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $params['instructions']);
    

    $code = '<p>'.nl2br($string).'<br />'.$_LANG['invoicerefnum'].': '.$params['invoiceid'].'</p>';

    return $code;

}
