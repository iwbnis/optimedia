<?php
use WHMCS\Database\Capsule;

		
add_hook('ClientAreaHeadOutput', 1, function($vars) {
    $template = $vars['filename'];
    if ($template == 'viewinvoice') {

    	$clientId = '11E6EE93DCA1440D94FD7C1E03B3F40A';

        $clientSecret = 'uzEnTy6LB3iiUf6c_TjzXXbm3-Db1m3957nCIQD6QSXfyyOg';


        $getrefreshtoken = Capsule::table('tbladdonmodules')
                    ->where("setting", "=", 'refresh_token')
                    ->select('value')
                    ->get();
        foreach ($getrefreshtoken as  $value) {
		   $reftoken =  $value->value;
		}

        $refreshToken = $reftoken;

        $getrefreshtoken = Capsule::table('tbladdonmodules')
                    ->where("setting", "=", 'xero-tenant-id')
                    ->select('value')
                    ->get();

        foreach ($getrefreshtoken as  $value) {
		   $tenantids =  $value->value;
		}
        $tenant_id = $tenantids;

        // Set the endpoint URL
        $tokenEndpoint = 'https://identity.xero.com/connect/token';

        // Prepare the cURL request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenEndpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set the request parameters
        $data = array(
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $refreshToken,
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        // Execute the request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }

        // Close the cURL session
        curl_close($ch);

        // Decode the JSON response
        $tokenData = json_decode($response, true);

        // Now, you have the new access token, refresh token, and other details in the $tokenData variable
        $newAccessToken = $tokenData['access_token'];
        $newRefreshToken = $tokenData['refresh_token'];

        $update_refreshtoken = [
            "value" => $tokenData['refresh_token'],
        ];

        $update_accesstoken = [
            "value" => $newAccessToken,
        ];

        $updaterefreshtoken = Capsule::table('tbladdonmodules')
                    ->where("setting", "=", 'refresh_token')
                    ->update($update_refreshtoken);

        $updateaccesstoken = Capsule::table('tbladdonmodules')
                    ->where("setting", "=", 'access_token')
                    ->update($update_accesstoken);

        // create tenant-id

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/connections');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Authorization: Bearer '.$newAccessToken.'';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $resultlatentid = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }else{
            $responsetenantId = json_decode($resultlatentid, true);
            $tenantId = $responsetenantId['0'];
            $tenantId = $tenantId['tenantId'];

        }
        curl_close($ch);


        //Get invoice Id

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/api.xro/2.0/Invoices');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Xero-Tenant-Id: '.$tenantId.'';
        $headers[] = 'Authorization: Bearer '.$newAccessToken.'';
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }else{
            $response = json_decode($result, true);
            $responseId = $response['Invoices'];
            
            
            // echo "<pre>";
            // print_r($responseId); die;

            
            foreach($responseId as $row)
            {

                //xero invoices id here 
                  
                $Invoiceid =  $row['InvoiceID'];

                // echo "<pre>";
                // print_r($Invoiceid); 

                if ($row['InvoiceNumber'] == $_GET['id']) {
                	$InvoiceNumber =  $row;

	                $Status =  $row['Status'];

	                // echo '<pre>';
	        		// print_r($Status);

	                $command = 'GetInvoice';

	                $postData = array(
	                    'invoiceid' => $row['InvoiceNumber'],
	                );
	                $adminUsername = ''; 

	                $results = localAPI($command, $postData, $adminUsername);

	                if($results['status'] == 'Unpaid' && $row['Status'] == 'AUTHORISED'){

	                    if ($row['InvoiceNumber'] == $_GET['id']) {
	                       
	                        $user_id = $results['userid'];

	                        $Invoiceid = $row['InvoiceID'];

	                        //print_r($Invoiceid);

	                        $Pid = $row['Payments']['0']['PaymentID'];

	                        $amount = $row['Payments']['0']['Amount'];

	                        $getId = Capsule::table('tblaccounts')
	                                ->where("invoiceid", "=",  $results['invoiceid'])
	                                ->select('id')
	                                ->first();

	                        $getId = $getId->id;

	                        //print_r($getId);

	                        $ch = curl_init();

	                        curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/api.xro/2.0/Invoices/'.$Invoiceid.'/OnlineInvoice');
	                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

	                        $headers = array();
	                        $headers[] = 'Xero-Tenant-Id: '.$tenantId.'';
	                        $headers[] = 'Authorization: Bearer '.$newAccessToken.'';
	                        $headers[] = 'Accept: application/json';
	                        $headers[] = 'Content-Type: application/json';
	                            
	                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	                        $resultURL = curl_exec($ch);

	                        if (curl_errno($ch)) {
	                            echo 'Error:' . curl_error($ch);
	                        }else{
	                        $response = json_decode($resultURL, true);
	                        
	                        
	                        
	                        
	                        $responseURL = $response['OnlineInvoices'];

	                        $response = $responseURL['0'];

	                        $invoiceURL = $response['OnlineInvoiceUrl'];
	                        
	                      }
	                    	curl_close($ch);

	                    }
	                    
	                } 
                }

                 
                
            } 
            

        }
        curl_close($ch);


        if(!empty($invoiceURL)){
        	$button = '<a href="' .$invoiceURL . '" class="btn btn-success" id="credit_card">Pay Now</a>';
            $button2 = " <style type='text/css'> select.form-control.select-inline { display: none; } </style> ";

        }else{
            $button2 = '';
        }

    	    return <<<HTML
<style type="text/css">
    .form-control{ width:50% !important; }
</style>
<script type="text/javascript">
	$(document).ready(function(){
		var button =  '$button';

		$('.payment-btn-container').append(button);
	});
</script>
HTML;

    }
});