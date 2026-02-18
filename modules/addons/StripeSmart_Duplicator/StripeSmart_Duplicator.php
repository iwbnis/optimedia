<?php
use WHMCS\Database\Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function StripeSmart_Duplicator_config()
{
    return [
        'name' => 'Stripe Smart Duplicator',
        'description' => 'This module provides an aility to duplicate Stripe Smart Gateway Module',
        'author' => '<a href="https://ibeehost.com">iBeeHost</a>',
        'language' => 'english',
        'version' => '1.0',
        'fields' => [
            'lastNumber' => [
                'FriendlyName' => 'Total Stripe Smart Gateways',
                'Type' => 'text',
                'Size' => '25',
                'Default' => '0',
                'Description' => 'Last Duplicated Number of Stripe Smart Gateway Module <script> $(document).ready(function(){ $(\'input[name="fields[StripeSmart_Duplicator][lastNumber]"]\').prop("disabled" , true); }); </script>',
            ],
        ]
    ];
}

function StripeSmart_Duplicator_activate()
{

}

function StripeSmart_Duplicator_deactivate()
{

}

function StripeSmart_Duplicator_upgrade($vars)
{
    $currentlyInstalledVersion = $vars['version'];

}

function StripeSmart_Duplicator_output($vars)
{
    // Get common module parameters
    $modulelink = $vars['modulelink']; // eg. StripeSmart_Duplicators.php?module=StripeSmart_Duplicator
    $version = $vars['version']; // eg. 1.0
    $_lang = $vars['_lang']; // an array of the currently loaded language variables
    $lastNumber = $vars['lastNumber']; // an array of the currently loaded language variables

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

	if($action == "Abracadabra")
	{
		
		$num = $lastNumber + 1;				
		
		copy(__DIR__ .'/StripeSmart/trojan_main.php', __DIR__ .'/StripeSmart/StripeSmart'.$num.'.php');		
		$str = file_get_contents(__DIR__ .'/StripeSmart/StripeSmart'.$num.'.php');
		$str = str_replace("<number>" , "$num" , $str);
		file_put_contents(__DIR__ .'/StripeSmart/StripeSmart'.$num.'.php', $str);
		rename(__DIR__ ."/StripeSmart/StripeSmart".$num.".php", "/var/www/html/modules/gateways/StripeSmart".$num.".php");

		copy(__DIR__ .'/StripeSmart/trojan_callback.php', __DIR__ .'/StripeSmart/StripeSmart'.$num.'.php');
		$str = file_get_contents(__DIR__ .'/StripeSmart/StripeSmart'.$num.'.php');
		$str = str_replace("<number>" , "$num" , $str);
		file_put_contents(__DIR__ .'/StripeSmart/StripeSmart'.$num.'.php', $str);
		rename(__DIR__ ."/StripeSmart/StripeSmart".$num.".php", "/var/www/html/modules/gateways/callback/StripeSmart".$num.".php");

		
		copy(__DIR__ .'/StripeSmart/trojan_hooks.php', __DIR__ .'/StripeSmart/StripeSmart'.$num.'.php');
		$str = file_get_contents(__DIR__ .'/StripeSmart/StripeSmart'.$num.'.php');
		$str = str_replace("<number>" , "$num" , $str);
		file_put_contents(__DIR__ .'/StripeSmart/StripeSmart'.$num.'.php', $str);
		rename(__DIR__ ."/StripeSmart/StripeSmart".$num.".php","/var/www/html/includes/hooks/StripeSmart".$num.".php");		
		
		try {
          Capsule::table('tbladdonmodules')
              ->where('module', 'StripeSmart_Duplicator')
              ->where('setting', 'lastNumber')
              ->update(
                [
                  'value' => $num,
                ]
              );

            $_SESSION['msg'] =  '<div class="alert alert-success text-center">Duplicate Stripe Smart Gateway has been added to Gateways <br> New Gateway Name: StripeSmart'.$num.' </div>';

            
      } catch (\Exception $e) {
        $_SESSION['msg'] =  '<div class="alert alert-danger text-center">Something went wrong!</div>';
        }		
		
		header("Location: $modulelink");
		exit;
		
	}

	
	if(isset($_SESSION['msg']))
	{
		echo $_SESSION['msg']; 
		$_SESSION['msg'] = '';
	}
?>


<center>
	<a class="btn btn-lg btn-success" onClick="return confirm('Are you sure to Install the Stripe Smart Duplicate Gateway?');" href="<?php echo $modulelink; ?>&action=Abracadabra">Install Stripe Smart Gateway</a>
</center>

<?php
	
}

function StripeSmart_Duplicator_sidebar($vars)
{
    // Get common module parameters
    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $_lang = $vars['_lang'];

	$sidebar = '<p></p>';
    return $sidebar;
}

function StripeSmart_Duplicator_clientarea($vars)
{
    // Get common module parameters
    $modulelink = $vars['modulelink']; // eg. index.php?m=StripeSmart_Duplicator
    $version = $vars['version']; // eg. 1.0
    $_lang = $vars['_lang']; // an array of the currently loaded language variables
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
    return '';
}


function StripeSmart_Duplicator_verify_license($LicenseKey){
        $url = 'https://xpertsol.org/WHMCS_StripeSmartDuplicator/license_verify.php?key='.$LicenseKey.'&domain='.$_SERVER['SERVER_NAME'];
        $LicenseStatus = StripeSmart_Duplicator_curl_get_contents($url);
        if($LicenseStatus === FALSE) { $LicenseStatus = 'Error connecting to Server'; exit; }
        return $LicenseStatus;
}

function StripeSmart_Duplicator_curl_get_contents($url) {
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_HEADER, 0);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 $output = curl_exec($ch);
 curl_close($ch);
 return $output;
}
