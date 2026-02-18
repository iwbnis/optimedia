<?php 

use WHMCS\Database\Capsule;


add_hook('UserLogin', 0, function($vars) {
    
        $redirect =$_SESSION['stored_data'];
        if(!empty($redirect)){
            header("Location: $redirect");
            exit;
        }

});


add_hook('ClientAreaHeaderOutput', 1, function($vars) {
    
    global $smarty;
    global $CONFIG; 
    
    $moduleName = 'XUIModule'; // The module name you want to check

    $result_status = Capsule::table('tbladdonmodules')
    ->where('module', $moduleName)
    ->first();
    
    $output = $result_status->value;
    
    $smarty->assign('output', $output);

});

add_hook('ClientAreaFooterOutput', 1, function($vars) {
    $template = $vars['template'];
    return <<<HTML
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const generatePasswordBtn = document.createElement('a');
            generatePasswordBtn.classList.add('btn', 'outline-btn', 'generate-password');
            generatePasswordBtn.textContent = 'Generate Password';
            generatePasswordBtn.style.display = 'none';

            const customField2172 = document.getElementById('customfield2172');
            if (customField2172) {
                customField2172.parentNode.insertBefore(generatePasswordBtn, customField2172.nextSibling);

                $('.generate-password').on('click', function() { 
                  $('#modalGeneratePassword').modal('show');
                });
                 
            }
        });
    </script>
HTML;
});





add_hook('ClientAreaHeadOutput', 1, function($vars) {
    $template = $vars['template'];
    return <<<HTML
    
<script type="text/javascript">
function makeAjaxRequest() {

    $.ajax({
        url: '',
        type: 'POST',
        data: {
            action: 'getusername'
        },
        success: function(response) {
        
        
        console.log(response);
        
        
        var dataObject = JSON.parse(response);
        
        // console.log(dataObject);
        
        if (dataObject.redirect) {
            window.location.href = dataObject.redirect;
            return; // Stop further execution
        }
    
        var dataArray = Object.entries(dataObject);
    
        var nonEmptyValues = dataArray.filter(function(item) {
            return item[0].trim() !== ''; // Remove empty strings (if any)
        });
    
        var select = $('#customfield2173');
        select.empty();
    
        select.append('<option value="">Select account</option>');
    
        nonEmptyValues.forEach(function(item) {
            var username = item[0]; 
            var userId = item[1]; 
            select.append('<option value="' + userId + '">' + username + '</option>');
        });
    },
    error: function(xhr, status, error) {
        console.error('AJAX request failed: ' + error);
    }

    });
}


function makeupgradeservices(selectedValue) {

    $.ajax({
        url: '',
        type: 'POST',
        data: {
            action: 'upgradeservices',
            id    : selectedValue 
        },
        success: function(response) {
        
            if (response) {
                window.open('/viewinvoice.php?id=' + response, '_blank');
            }
        },
    error: function(xhr, status, error) {
        console.error('AJAX request failed: ' + error);
    }

    });
}

</script>
HTML;

});


add_hook('ClientAreaPage', 0, function($vars) {
    if (isset($_POST['action']) && $_POST['action'] === 'getusername') {
        $command = 'GetClientsProducts';
        $postData = array(
            'clientid' => $_SESSION['uid'],
        );
        $adminUsername = '';
        
        if(empty($postData['clientid'])){
            
            
            $_SESSION['stored_data'] = 'https://test.choiceiptv.net/cart.php?a=confproduct&i=3';
            
            $response = array(
                'redirect' => 'https://test.choiceiptv.net/index.php/login'
            );
            echo json_encode($response);
            exit();
        }
        

        $results = localAPI($command, $postData, $adminUsername);
        
        
        $usernames = array(); 

        foreach ($results['products']['product'] as $product) {
            $username = $product['username'];
            $userId = $product['id'];
            $usernamesWithIds[$username] = $userId;

        }

        echo json_encode($usernamesWithIds);
        die();
    }
    
    
    if (isset($_POST['action']) && $_POST['action'] === 'upgradeservices') {
        
        $requestedId = $_POST['id'];
        $command = 'GetClientsProducts';
        $postData = array(
            'clientid' => $_SESSION['uid'],
        );
        
        $adminUsername = '';

        $results = localAPI($command, $postData, $adminUsername);
        
        if ($results['result'] === 'success' && isset($results['products'])) {
        $matchingProducts = array_filter($results['products']['product'], function($product) use ($requestedId) {
            return $product['id'] == $requestedId;
        });
        
        
        
        // echo "<pre>";
        // print_r($matchingProducts); die;
        
    
        foreach ($matchingProducts as $product) {
            $paymentmethod   = $product['paymentmethod'];
            $billingcycle    = $product['billingcycle'];
            $id              = $product['id'];
            $pid             = $product['pid'];
            $recurringamount = $product['recurringamount'];
            $nextduedate     = $product['nextduedate'];
            $name     = $product['name'];
        }
        
        $command = 'CreateInvoice';

        $postData = array(
            'userid' => $_SESSION['uid'],
            'status' => 'Unpaid',
            'sendinvoice' => '1',
            'paymentmethod' => $paymentmethod,
            'taxrate' => '0.00',
            'duedate' => $nextduedate,
            'itemdescription1' => $name,
            'itemamount1' => $recurringamount,
            'itemtaxed1' => '0',
            
        );
        $adminUsername = ''; // Optional for WHMCS 7.2 and later
        
        $results = localAPI($command, $postData, $adminUsername);

        if ($results['result'] == 'success' && isset($results['invoiceid'])) {
            $invoiceID = $results['invoiceid'];
            echo $invoiceID;
            exit();
        }
         
    }
        
    }
});
?>