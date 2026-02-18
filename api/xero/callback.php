<?php
require __DIR__ . '/vendor/autoload.php';
use XeroAPI\XeroPHP\Api\AccountingApi;
use GuzzleHttp\Client;

$clientID = 'AD4CA50DE4FC47AAB64B1DAECB395859';
$clientSecret = 'gttJ39rbXB4slhjXEeGjJQy74WQwPU3AkxfFEur0l-JLXHbz';
$redirectUri = 'https://localhost/xero-integration/callback.php';
$scope = 'openid profile email accounting.transactions offline_access';
$tokenUrl = 'https://identity.xero.com/connect/token';

$accessToken ='eyJhbGciOiJSUzI1NiIsImtpZCI6IjFDQUY4RTY2NzcyRDZEQzAyOEQ2NzI2RkQwMjYxNTgxNTcwRUZDMTkiLCJ0eXAiOiJKV1QiLCJ4NXQiOiJISy1PWm5jdGJjQW8xbkp2MENZVmdWY09fQmsifQ.eyJuYmYiOjE2OTMwNTEyNDYsImV4cCI6MTY5MzA1MzA0NiwiaXNzIjoiaHR0cHM6Ly9pZGVudGl0eS54ZXJvLmNvbSIsImF1ZCI6Imh0dHBzOi8vaWRlbnRpdHkueGVyby5jb20vcmVzb3VyY2VzIiwiY2xpZW50X2lkIjoiQUQ0Q0E1MERFNEZDNDdBQUI2NEIxREFFQ0IzOTU4NTkiLCJzdWIiOiJkYzRmYmQ3NmViOWI1MzMzYjIyMjhhMjYwODE1ZTc4ZCIsImF1dGhfdGltZSI6MTY5MzA0MTA3NCwieGVyb191c2VyaWQiOiI4OWZiZTFiOC1jZTRkLTRkZWUtYWQxNy1lM2M3MjhlZDBmYjQiLCJnbG9iYWxfc2Vzc2lvbl9pZCI6Ijc5ZTc2MDlkZGEwMzQ4ZDZhOWJlNTU5MmVmNGZiOTkwIiwic2lkIjoiNzllNzYwOWRkYTAzNDhkNmE5YmU1NTkyZWY0ZmI5OTAiLCJqdGkiOiIzNzgyNzQxQTExOTdGQTczQzhCRkFEN0VCQjgwQzRGQiIsImF1dGhlbnRpY2F0aW9uX2V2ZW50X2lkIjoiNzY3Yzk3MjEtYTEzOC00M2ZmLWE3NTktZjJkZDdjYjMxODViIiwic2NvcGUiOlsiZW1haWwiLCJwcm9maWxlIiwib3BlbmlkIiwiYWNjb3VudGluZy50cmFuc2FjdGlvbnMiLCJvZmZsaW5lX2FjY2VzcyJdLCJhbXIiOlsicHdkIl19.TmZdw2_f7M7-jXQK8o2l5hGASbxKU2d5ofnUjyS5TC1sctH9nhUJQenL1FOnh3ZME6Y_1L_tc9S2pPlXxoQuVJFbWHQC1aic8f7-xt5etVTFNKveBG-Fuu8DEhxvuIhLhnFp3if8DAcQuk8eBVYGYfQDcc8j2vl0rXGPf0NuYkJoCK6ZJRkoDLRnP8RFiHVvh6YDoYqy7MdHrVG5RgnS54WX3K4MNEawsnThoE7fgPPMwlK2vkyF0la5iJ9TIZgvJQAD2TIfPxrnxoi06WnB9T40e2vFZGNX-r1FCRkpd45VaK9PSqImyALmuGSNuxv0qA5Hu1_KTOkrGwVfV2VOow';


//Create new invoices
if (isset($_POST['createinvoice']) && $_POST['createinvoice'] == 'createinvoice') {

        //Tenant Id
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/connections');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Authorization: Bearer '.$accessToken.'';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $resultlatentid = curl_exec($ch);        

        curl_close($ch);

        $responseid = json_decode($resultlatentid, true);
        $tenantId = $responseid['0'];
        $xero_tenant_id = $tenantId['tenantId'];



        //Contact-Id
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/api.xro/2.0/Contacts/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Authorization: Bearer '.$accessToken.'';
        $headers[] = 'Xero-Tenant-Id: '.$xero_tenant_id.'';
        $headers[] = 'Accept: application/json';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $contactid = curl_exec($ch);        

        curl_close($ch);

        $tokenData = json_decode($contactid, true);

        $contactID = $tokenData['Contacts'][0]['ContactID'];
        $Name = $tokenData['Contacts'][0]['Name'];
        $FirstName = $tokenData['Contacts'][0]['FirstName'];
        $LastName = $tokenData['Contacts'][0]['LastName'];

        $invoiceData = [
                'Type' => $_POST['Type'], // Accounts receivable invoice
                'Contact' => [
                    'ContactID'=> $contactID,
                    'Name'=>  $Name,
                ],
                'LineItems' => [
                    [
                        'Description' => $_POST['Description'], // Description of the item
                        'Quantity' => $_POST['Quantity'], // Quantity
                        'UnitAmount' => $_POST['UnitAmount'], // Unit amount
                        'AccountCode' => $_POST['AccountCode'], // Account code for sales
                        'TaxType' => $_POST['TaxType'],
                        'LineAmount' => $_POST['LineAmount'],
                    ],
                ],

                    'Date'=> $_POST['Date'],
                    'DueDate'=> $_POST['DueDate'],
                    // 'DateString'=> $_POST['DateString'],
                    // 'DueDateString'=> $_POST['DueDateString'],
                    'Reference'=> $_POST['Reference'],
                    'Status'=> $_POST['Status']
            ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/api.xro/2.0/Invoices/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($invoiceData));

        $headers = array();
        $headers[] = 'Authorization: Bearer '.$accessToken.'';
        $headers[] = 'Xero-Tenant-Id: '.$xero_tenant_id.'';
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        $result = json_decode($result, true);

        if($result){
            echo json_encode(['success' => $result], 200); die;
        }else{
            echo json_encode(['error' => 'Unauthorized'], 400); die; 
        }
        
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
}

//Get All Invoices       
if (isset($_GET['getinvoice']) && $_GET['getinvoice'] == 'getinvoice') {


        //Tenant Id
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/connections');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Authorization: Bearer '.$accessToken.'';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $resultlatentid = curl_exec($ch);        

        curl_close($ch);

        $responseid = json_decode($resultlatentid, true);
        $tenantId = $responseid['0'];
        $xero_tenant_id = $tenantId['tenantId'];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/api.xro/2.0/Invoices');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Xero-Tenant-Id: '.$xero_tenant_id.'';
        $headers[] = 'Authorization: Bearer '.$accessToken.'';
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }else{
            $response = json_decode($result, true);
            $responseId = $response['Invoices'];

            if($responseId){
                echo json_encode(['success' => $responseId], 200); die;
            }else{
                echo json_encode(['error' => 'Unauthorized'], 400); die; 
            }
        }
}

//Retrieve Specific InvoiceID
if (isset($_POST['invoicedetail']) && $_POST['invoicedetail'] == 'invoicedetail') {

    $Invoiceid = $_POST['Invoiceid'];

    //Tenant Id
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/connections');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


    $headers = array();
    $headers[] = 'Authorization: Bearer '.$accessToken.'';

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $resultlatentid = curl_exec($ch);        

    curl_close($ch);

    $responseid = json_decode($resultlatentid, true);


    $tenantId = $responseid['0'];
    $xero_tenant_id = $tenantId['tenantId'];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/api.xro/2.0/Invoices/'.$Invoiceid.'/OnlineInvoice');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers = array();
    $headers[] = 'Xero-Tenant-Id: '.$xero_tenant_id.'';
    $headers[] = 'Authorization: Bearer '.$accessToken.'';
    $headers[] = 'Accept: application/json';
    $headers[] = 'Content-Type: application/json';
        
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $resultURL = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }else{
    $response = json_decode($resultURL, true);
    
    // $responseURL = $response['OnlineInvoices'];

    // $response = $responseURL['0'];

    // $invoiceURL = $response['OnlineInvoiceUrl'];


    if($response){
        echo json_encode(['success' => $response], 200); die;
    }else{
        echo json_encode(['error' => 'Unauthorized'], 400); die; 
    }
    
  }
}


//Invoice URL with InvoiceID
if (isset($_POST['invoiceurl']) && $_POST['invoiceurl'] == 'invoiceurl') {

    $Invoiceid = $_POST['Invoiceid'];

    //Tenant Id
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/connections');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


    $headers = array();
    $headers[] = 'Authorization: Bearer '.$accessToken.'';

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $resultlatentid = curl_exec($ch);        

    curl_close($ch);

    $responseid = json_decode($resultlatentid, true);


    $tenantId = $responseid['0'];
    $xero_tenant_id = $tenantId['tenantId'];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/api.xro/2.0/Invoices/'.$Invoiceid.'/OnlineInvoice');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers = array();
    $headers[] = 'Xero-Tenant-Id: '.$xero_tenant_id.'';
    $headers[] = 'Authorization: Bearer '.$accessToken.'';
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


    if($invoiceURL){
        echo json_encode(['success' => $invoiceURL], 200); die;
    }else{
        echo json_encode(['error' => 'Unauthorized'], 400); die; 
    }
    
  }
}


if (isset($_GET['code'])) {
    $authorizationCode = $_GET['code'];

    // Step 4: Exchange the authorization code for an access token
    // Now that you have the authorization code, you can proceed to exchange it for an access token.
    $tokenUrl = 'https://identity.xero.com/connect/token';

    // Create an array with the necessary data for the token exchange.
    $data = [
        'grant_type' => 'authorization_code',
        'client_id' => $clientID,
        'client_secret' => $clientSecret,
        'code' => $authorizationCode,
        'redirect_uri' => $redirectUri,
    ];

    // Initialize a cURL session to make the POST request.
    $ch = curl_init($tokenUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Execute the cURL session and get the response.
    $response = curl_exec($ch);

    // Close the cURL session.
    curl_close($ch);

    // Decode the JSON response to an associative array.
    $responseData = json_decode($response, true);

    // Extract the access token from the response data.
    $accessToken = $responseData['access_token'];
    $refresh_token = $responseData['refresh_token'];

        //Tenant Id
    	$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/connections');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Authorization: Bearer '.$accessToken.'';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $resultlatentid = curl_exec($ch);        

        curl_close($ch);

        $responseid = json_decode($resultlatentid, true);
        $tenantId = $responseid['0'];
        $xero_tenant_id = $tenantId['tenantId'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/api.xro/2.0/Contacts/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Authorization: Bearer '.$accessToken.'';
        $headers[] = 'Xero-Tenant-Id: '.$xero_tenant_id.'';
        $headers[] = 'Accept: application/json';


        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $contactid = curl_exec($ch);        

        curl_close($ch);

        $tokenData = json_decode($contactid, true);

       	$contactID = $tokenData['Contacts'][0]['ContactID'];
        $Name = $tokenData['Contacts'][0]['Name'];
        $FirstName = $tokenData['Contacts'][0]['FirstName'];
        $LastName = $tokenData['Contacts'][0]['LastName'];

        // print_r($name); die();


        $invoiceData = [
		    'Type' => 'ACCREC', // Accounts receivable invoice
		    'Contact' => [
		        'ContactID'=> $contactID,
                'Name'=>  $Name .$FirstName .$LastName,
		    ],
		    'LineItems' => [
		        [
		            'Description' => 'Product 1', // Description of the item
		            'Quantity' => 2, // Quantity
		            'UnitAmount' => 20, // Unit amount
		            'AccountCode' => '200', // Account code for sales
		            'TaxType' => 'NONE',
		            'LineAmount' => '40',
		        ],
		    ],

                'Date'=> '2023-03-11',
                'DueDate'=> '2023-03-11',
                'DateString'=> '2009-05-27',
                'DueDateString'=> '2009-05-27',
                'Reference'=> 'Website Design',
                'Status'=> 'AUTHORISED'
		];



        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/api.xro/2.0/Invoices/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($invoiceData));

        $headers = array();
        $headers[] = 'Authorization: Bearer '.$accessToken.'';
        $headers[] = 'Xero-Tenant-Id: '.$xero_tenant_id.'';
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        print_r($result); die;
        
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

	    
    // Step 5: Use the access token to make API requests
    // Now that you have the access token, you can use it to make requests to Xero's API on behalf of the user.
    // You can use libraries like Guzzle HTTP or any other HTTP client library to make API requests with the access token.
    
    // Example: Make a request to Xero's API using the access token.
    // ...
} else {
    // Step 1: Redirect the user to the Xero authorization URL
    $authorizationUrl = 'https://login.xero.com/identity/connect/authorize' .
        '?response_type=code' .
        '&client_id=' . urlencode($clientID) .
        '&redirect_uri=' . urlencode($redirectUri) .
        '&scope=' . urlencode($scope);

    // Redirect the user to the authorization URL.
    header('Location: ' . $authorizationUrl);
    exit;
}


