<?php
use WHMCS\Authentication\CurrentUser;
use WHMCS\ClientArea;
use WHMCS\Database\Capsule;

define('CLIENTAREA', true);

require __DIR__ . '/init.php';

$ca = new ClientArea();

$ca->setPageTitle('Cart');

$ca->addToBreadCrumb('index.php', Lang::trans('Cart'));
$ca->addToBreadCrumb('customcart.php', 'Cart');

$ca->initPage();

if(isset($_GET['a']) && $_GET['a']=='add' && !empty($_GET['pid']))
{
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart']['products'])) {
        $_SESSION['cart']['products'] = [];
    }

    // Define multiple products
    $products = [];
    if(!empty($_GET['vpn'])){
        $products[] = [
            'pid' => $_GET['vpn'],
            'billingcycle' => 'monthly',
        ];
    }

    if(!empty($_GET['android'])){
        $androidQty = max(1, min(5, intval($_GET['androidqty'] ?? 1)));
        for ($aq = 0; $aq < $androidQty; $aq++) {
            $products[] = [
                'pid' => $_GET['android'],
                'billingcycle' => 'monthly',
            ];
        }
    }

    // Add each product into WHMCS cart session
    foreach ($products as $product) {
        $_SESSION['cart']['products'][] = [
            'pid' => $product['pid'],
            'billingcycle' => $product['billingcycle'],
            'configoptions' => [],
            'addons' => [],
            'domain' => '',
            'domainoptions' => [],
            'customfields' => [],
            'server' => '',
        ];
    }

    $getData = $_GET;
    $queryString = http_build_query($getData);
    header("Location: cart.php?$queryString");
    exit;    
}

if(isset($_GET['a']) && $_GET['a']=='getdata')
{
    header('Content-Type: application/json');

    $xuiData = Capsule::table('xui_paneldetails')->get();
    $xui_catss = Capsule::table('xui_cats')->get();
    $allProducts = Capsule::table('tblproducts')
        ->whereIn('gid', [2, 43, 44, 21, 39, 42, 40, 45, 41, 46, 32, 48, 35, 14])
        ->get();
    $androidProducts = Capsule::table('tblproducts')
        ->whereIn('gid', [49])
        ->get();
    $vpnProducts = Capsule::table('tblproducts')
        ->whereIn('gid', [30])
        ->get();
    $resellerProducts = Capsule::table('tblproducts')
        ->whereIn('gid', [7])
        ->get();

    $userServices = [];
    if(isset($_SESSION['uid']) && !empty($_SESSION['uid'])){
        $userServices = Capsule::table('tblhosting')
            ->where('userid', $_SESSION['uid'])
            ->where('domainstatus', 'Active')
            ->select('id', 'username')
            ->get();
    }

    echo json_encode([
        'xuiData' => $xuiData,
        'xui_catss' => $xui_catss,
        'allProducts' => $allProducts,
        'androidProducts' => $androidProducts,
        'vpnProducts' => $vpnProducts,
        'resellerProducts' => $resellerProducts,
        'userServices' => $userServices,
        'loggedIn' => isset($_SESSION['uid']) && !empty($_SESSION['uid']),
    ]);
    exit;
}

if(isset($_POST['action']) && $_POST['action']=='getChannelByCat')
{
    $catId = $_POST['catId'];
    $catChannels = file_get_contents('https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_streams&type=streams&category_id='.$catId, true);

    echo $catChannels;die();
    //echo $catChannels = json_decode($catChannels,true);die();
    //echo '<pre>'; print_r($catChannels);die();
}




if(isset($_SESSION['uid']) && !empty($_SESSION['uid'])){

    $ca->assign('loginCheck', 'yes');
    $userServices = Capsule::table('tblhosting')->where('userid',$_SESSION['uid'])->where('domainstatus','Active')->select('id','username')->get();
    $ca->assign('userServices', $userServices);

}


$xuiData = Capsule::table('xui_paneldetails')->get();
$xui_catss = Capsule::table('xui_cats')->get();
// $allProducts = Capsule::table('tblproducts')->get();
$allProducts = Capsule::table('tblproducts')
    ->whereIn('gid', [2, 43, 44, 21, 39, 42, 40, 45, 41, 46, 32, 48, 35, 14])
    ->get();

    $androidProducts = Capsule::table('tblproducts')
    ->whereIn('gid', [49])
    ->get();
    $vpnProducts = Capsule::table('tblproducts')
    ->whereIn('gid', [30])
    ->get();

$ca->assign('xuiData', $xuiData);
$ca->assign('allProducts', $allProducts);
$ca->assign('androidProducts', $androidProducts);
$ca->assign('vpnProducts', $vpnProducts);
$ca->assign('xui_catss', $xui_catss);

$ca->setTemplate('customcart');
$ca->output();