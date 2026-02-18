<?php

# Bank Transfer Payment Gateway Module

if (!defined("WHMCS")) die("This file cannot be accessed directly");

function cashapp_config() {

    $configarray = array(
     "FriendlyName" => array(
        "Type" => "System",
        "Value" => "CashApp"
        ),
     "instructions" => array(
        "FriendlyName" => "CashApp Instructions",
        "Type" => "textarea",
        "Rows" => "5",
        "Value" => "CashApp Name:\nPayee Name:\nSort Code:\nAccount Number:",
        "Description" => "The instructions you want displaying to customers who choose this payment method - the invoice number will be shown underneath the text entered above",
        ),
    );

    return $configarray;

}

function cashapp_link($params) {
    global $_LANG;

    $code = '<p>'.nl2br($params['instructions']).'<br />'.$_LANG['invoicerefnum'].': '.$params['invoiceid'].'</p>';

    return $code;

}
