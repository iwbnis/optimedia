<?php

# Bank Transfer Payment Gateway Module

if (!defined("WHMCS")) die("This file cannot be accessed directly");

function xeropay_config() {

    $configarray = array(
     "FriendlyName" => array(
        "Type" => "System",
        "Value" => "Xero Payments"
        ),
     "instructions" => array(
        "FriendlyName" => "Xero Payment Instructions",
        "Type" => "textarea",
        "Rows" => "5",
        "Value" => "Bank Name:\nPayee Name:\nSort Code:\nAccount Number:",
        "Description" => "The instructions you want displaying to customers who choose this payment method - the invoice number will be shown underneath the text entered above",
        ),
    );

    return $configarray;

}

function xeropay_link($params) {
    $code = '<p>'
        . nl2br($params['instructions'])
        . '<br />'
        . Lang::trans('invoicerefnum')
        . ': '
        . $params['invoicenum']
        . '</p>';

    return $code;

}
