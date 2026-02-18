<?php
use WHMCS\Database\Capsule;

        require_once __DIR__ . '/../../../init.php';
		 
        //refresh token
        
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
                    ->where("setting", "=", 'access_token')
                    ->select('value')
                    ->get();
        foreach ($getrefreshtoken as  $value) {
		   $aceestoken =  $value->value;
		}
		
		$acees_token = $aceestoken;
		
		
		$update_oldrefreshtoken = [
            "value" => $refreshToken,
        ];

        $update_oldaccesstoken = [
            "value" => $acees_token,
        ];


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
            "value" => $newRefreshToken,
        ];

        $update_accesstoken = [
            "value" => $newAccessToken,
        ];
        
        
        if(!empty($update_refreshtoken['value'])){
            $updaterefreshtoken = Capsule::table('tbladdonmodules')
                    ->where("setting", "=", 'refresh_token')
                    ->update($update_refreshtoken);
        }else{
            $updaterefreshtoken = Capsule::table('tbladdonmodules')
                    ->where("setting", "=", 'refresh_token')
                    ->update($update_oldrefreshtoken);
        }
        
        if(!empty($update_accesstoken['value'])){
            $updateaccesstoken = Capsule::table('tbladdonmodules')
                    ->where("setting", "=", 'access_token')
                    ->update($update_accesstoken);
        }else{
            $updateaccesstoken = Capsule::table('tbladdonmodules')
                    ->where("setting", "=", 'access_token')
                    ->update($update_oldaccesstoken);
        }


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

            //print_r($tenantId); die();
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
            // print_r($responseId); die();


            foreach($responseId as $row)
            {
                //xero invoices id here 
                  
                $Invoiceid =  $row['InvoiceID'];

                $InvoiceNumber =  $row;

                $Status =  $row['Status'];

                $payment = $row['Payments']['0']['PaymentID'];


                $command = 'GetInvoice';
                $postData = array(
                    'invoiceid' => $row['InvoiceNumber'],
                );

                $adminUsername = ''; 

                $results = localAPI($command, $postData, $adminUsername);

                if($results['status'] == 'Unpaid' && $row['Status'] == 'PAID'){


                    if ($row['InvoiceNumber'] == $results['invoiceid']) {
                       
                        $user_id = $results['userid'];

                        $Invoiceid = $row['InvoiceID'];

                        $paymentdate = $row['DateString'];

                        $Pid = $row['Payments']['0']['PaymentID'];

                        $amount = $row['Payments']['0']['Amount'];

                        $getId = Capsule::table('tblaccounts')
                                ->where("invoiceid", "=",  $results['invoiceid'])
                                ->select('id')
                                ->first();

                        $getId = $getId->id;

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
                    if(empty($getId)){
                            $getIds = Capsule::table('tblaccounts')
                                ->select('id')
                                ->orderBy('id', 'DESC')
                                ->first();

                            $getId = $getIds->id+1;

                            $date = date('d/m/Y');

                            $dateupdate = date('Y/m/d');
                            $datepaid = date('Y/m/d h:i');
                            $datepayment = date('Y/m/d H:m:s');

                            // $command = 'UpdateInvoice';
                            // $postData = array(
                            //   'invoiceid' =>  $results['invoiceid'],
                            //   'status' => 'Paid',
                            //   'datepaid' => $datepaid,
                            //   'date' => $dateupdate,
                            // );

                            // $adminUsername = '';
                            // $results = localAPI($command, $postData, $adminUsername);

                            // $command = 'AddTransaction';
                            // $postData = array(
                            //     'invoiceid' => $results['invoiceid'],
                            //     'paymentmethod' => 'credit card',
                            //     'userid' => $user_id,
                            //     'transid' => $Pid,
                            //     'date' => $date,
                            //     'amountin' => $amount,
                            //     'fees' => '0.00',
                            //     'rate' => '0.00',
                            // );

                            // $adminUsername = ''; // Optional for WHMCS 7.2 and later
                            // $resultss = localAPI($command, $postData, $adminUsername);

                            $command = 'AddInvoicePayment';
                            $postData = array(
                                'invoiceid' => $results['invoiceid'],
                                'transid' => $Pid,
                                'gateway' => 'xero',
                                'date' => strtotime($paymentdate),
                            );
                            $adminUsername = ''; // Optional for WHMCS 7.2 and later

                            $results = localAPI($command, $postData, $adminUsername);
                            //print_r($results);

                        }

                    }
                    
                }  
                
               
            } //die();

        }
        curl_close($ch);
?>


