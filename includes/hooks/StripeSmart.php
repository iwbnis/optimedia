<?php

use Illuminate\Database\Capsule\Manager as Capsule;



add_hook('ClientAreaProductDetailsOutput', 1, function($service) {



	$gatewayParams = getGatewayVariables('StripeSmart');



	$serviceId = $service['service']->id;

	

	$subs = Capsule::table('gateway_stripeSmart_Subscriptions')

        ->where("productid", "=", $serviceId)

        ->first();

	

	$subscriptionid = $subs->subscriptionid;

	

	

	

	if($_GET['customAction'] == 'cancelSubscription')

	{

		  $SmartURL = $gatewayParams['SmartURL'];

		  $Key = $gatewayParams['Key'];

				

		  $params = array();

		  $params['subid'] = $subscriptionid;

		  $params['path'] = 'cancelsub';

		  $params['Key'] = $Key;

		

		  $url = $SmartURL.'/SmartStripe.php';

		  $content = json_encode($params);

		  $curl = curl_init($url);

		  curl_setopt($curl, CURLOPT_HEADER, false);

		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		  curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));

		  curl_setopt($curl, CURLOPT_POST, true);

		  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

		  curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

		  $json_response = curl_exec($curl);

		  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		  $response = json_decode($json_response, true);



		  logActivity("StripeSmart: Subscription Cancel Status: $status -  Action Respose: $json_response");		

		

		

		  if($response['status'] == 'canceled')

		  {

			  

			       try {

          Capsule::table('gateway_stripeSmart_Subscriptions')

              ->where('subscriptionid', '=', $subscriptionid)

              ->delete();

					   

			logActivity('Successfully Deleted Subscription from Database as well as succesffuly cancelled by Stripe : '.$subscriptionid, 0);





      } catch(\Illuminate\Database\QueryException $ex){

          logActivity('Unable to Delete Subscription from Database when succesffuly cancelled by Stripe : '.$subscriptionid.'Reason: '.$ex->getMessage(), 0);

      } catch (Exception $e) {

          logActivity('Unable to Delete Subscription from Database when succesffuly cancelled by Stripe : '.$subscriptionid.'Reason: '.$e->getMessage(), 0);





      }

			  

		  }

		

		 

		

	}

	

	



	$subs = Capsule::table('gateway_stripeSmart_Subscriptions')

	->where("productid", "=", $serviceId)

	->first();

	



	if($subs)

	{

		ob_clean();

return <<<HTML

<!-- Start insert code here -->

	<div class='card'>

  <div class='card-header'>

    Payment Subscription

  </div>

  <div class='card-body' align='center'>

    <p class='card-text' >There is an Active Subscription for this product for Auto-Recurring Payments </p>

    <a href='clientarea.php?action=productdetails&id={$serviceId}&customAction=cancelSubscription' class='btn btn-danger' onClick='return confirm(\"Are you sure to cancel the Subscription?\");'>Cancel Subscription</a>

  </div>

</div>

<!-- End insert code here -->



HTML;

		

	}

	

	

});


add_hook('ClientAreaPageViewInvoice', 10, function($vars) {
    
	$invoiceid = $vars['invoiceid'];
	$payBtn = $vars['paymentbutton'];
	
	$serviceId = Capsule::table('tblinvoiceitems')
        ->where("invoiceid", "=", $invoiceid)
        ->value('relid');
	
	$sub = Capsule::table('gateway_stripeSmart_Subscriptions')
        ->where("productid", "=", $serviceId)
        ->value('subscriptionid');
	
	
	if($sub){
		
		$subTxt = '<br> <p style="font-size:13px;" class="alert alert-info" role="alert">You already have an active payment subscription for this product and this invoice will be automatically paid on due date</p> <script> $("#btnPayNow").click(function(){
  return confirm("Are you sure to cancel the current subscription and Pay manually or Subscribe with a different Card/Payment Method?");
});  $(document).ready(function(){ var act = $("form[name=\'paymentfrm\']").attr("action"); $("form[name=\'paymentfrm\']").attr("action" , act + "?cancel_existing=yes"); $("#btnPayNow").html("Pay Manually"); $("#btnPayNow").removeClass("btn-success"); $("#btnPayNow").addClass("btn-warning");   });  </script>';
		
		$return['paymentbutton'] = $payBtn.$subTxt ;
		
	}
	
	return $return;
	
});