<?php

use WHMCS\ClientArea;
use WHMCS\Database\Capsule;

define('CLIENTAREA', true);

require __DIR__ . '/init.php';

$ca = new ClientArea();

$ca->setPageTitle('IPTV Web Hosting Services');

//$ca->addToBreadCrumb('index.php', Lang::trans('globalsystemname'));
//$ca->addToBreadCrumb('choice-server.php', 'Choice IPTV Server');

$ca->initPage();

//$ca->requireLogin(); // Uncomment this line to require a login to access this page

// To assign variables to the template system use the following syntax.
// These can then be referenced using {$variablename} in the template.

//$ca->assign('variablename', $value);


$ca->setTemplate('iptv-web-hosting');

$ca->output();