<?php

use WHMCS\Database\Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}


function sendAnCustomerEmail($vars,$notvalidation=true)
{
	if((!isset($vars['email']) || $vars['email']=="") && $notvalidation){
		header('Content-Type: application/json');
		echo json_encode(['status' => 'failed']);
            exit;
	}
	
	if(isset($_SESSION['email_sent']) && $vars['resend']!=true){
		$olddate = strtotime($_SESSION['email_sent']);
		$currentdate = strtotime(date('Y-m-d H:i:s'));
		$differenct = $currentdate - $olddate;
		if($differenct<600){
			if(!$notvalidation)
				return;
			
			header('Content-Type: application/json');
			echo json_encode(['status' => 'failed']);
            exit;
		}
		
	}
	
	$code = mt_rand(100000, 999999);
		if(Capsule::table("mod_verifiedemail")->where('email',$_POST['email'])->count()>0){
			Capsule::table("mod_verifiedemail")->where('email',$_POST['email'])
                ->update(['verification_code' => $code]);
			
		}else{
			Capsule::table("mod_verifiedemail")
                ->insert(['email' => $_POST['email'], 'verification_code' => $code]);
		}

		$configemail_verification = Capsule::table("mod_configemail_verification")
                        ->pluck('value','setting');
		
        $MailType = Capsule::table("tblconfiguration")
                        ->where('setting', 'MailType')->pluck('value');
        $smtpport = Capsule::table("tblconfiguration")
                        ->where('setting', 'smtpport')->pluck('value');
        $smtphost = Capsule::table("tblconfiguration")
                        ->where('setting', 'smtphost')->pluck('value');
        $smtpusername = Capsule::table("tblconfiguration")
                        ->where('setting', 'smtpusername')->pluck('value');
        $smtppassword = Capsule::table("tblconfiguration")
                        ->where('setting', 'smtppassword')->pluck('value');
        $smtpssl = Capsule::table("tblconfiguration")
                        ->where('setting', 'smtpssl')->pluck('value');


        $systememailsfromname = Capsule::table("tblconfiguration")
                        ->where('setting', 'systememailsfromname')->pluck('value');
        $systememailsfromemail = Capsule::table("tblconfiguration")
                        ->where('setting', 'systememailsfromemail')->pluck('value');
        $signature = Capsule::table("tblconfiguration")
                        ->where('setting', 'signature')->pluck('value');
        $emailcss = Capsule::table("tblconfiguration")
                        ->where('setting', 'emailcss')->pluck('value');
        $emailglobalheader = Capsule::table("tblconfiguration")
                        ->where('setting', 'emailglobalheader')->pluck('value');
        $emailglobalfooter = Capsule::table("tblconfiguration")
                        ->where('setting', 'emailglobalfooter')->pluck('value');


        $command = 'DecryptPassword';
        $postData = array(
            'password2' => $smtppassword[0],
        );

		
        $results = localAPI($command, $postData);
		
        $mail = new PHPMailer;
		if($MailType[0] == 'smtp'){
			$mail->IsSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $smtphost[0];                 // Specify main and backup server
			$mail->Port = $smtpport[0];                                    // Set the SMTP port
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = $smtpusername[0];                // SMTP username
			$mail->Password = $results['password'];                  // SMTP password
			$mail->SMTPSecure = $smtpssl[0];                            // Enable encryption, 'ssl' also accepted
		}
        $mail->From = (($configemail_verification['fromemail']) ? $configemail_verification['fromemail'] : $systememailsfromemail[0]);
        $mail->FromName = (($configemail_verification['fromname']) ? $configemail_verification['fromname'] : $systememailsfromname[0]);
        $mail->AddAddress($_POST['email']);  // Add a recipient
        
		if($configemail_verification['emailcontent']!= ''){
			$body = str_replace('{CODE}',$code,$configemail_verification['emailcontent']);
		}else{
		
			$body = '<table id="m_1900970867241145122templateBody" width="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody><tr>
                                            <td class="m_1900970867241145122bodyContent" valign="top">
<p>Dear Customer,</p>
<p>Thank you for Verifiing the account.</p>
<p>Following is your verification code</p>
<p><table style="border-collapse:collapse" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:10px;background-color:#f2f2f2;border-left:1px solid #ccc;border-right:1px solid #ccc;border-top:1px solid #ccc;border-bottom:1px solid #ccc"><span class="m_-1885800025918930934mb_text" style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823">'.$code.'</span></td></tr></tbody></table></p>
<p>You are receiving this email because you recently tried to verify your email address. If you did not do this, please contact us.</p>
<p>'.$signature[0].'</p></td>                                       </tr>
                                    </tbody></table>';
									
									
        
        }
		
        $message = "Hi Customer,<br><br>Your Verification code is <h1>".$code."</h2>";
        $mail->Subject = (($configemail_verification['emailsubject']) ? $configemail_verification['emailsubject'] : $systememailsfromemail[0].' - Email Verification Code');
        $mail->Body = $body;
		
        $mail->IsHTML(true);                                  // Set email format to HTML
        
        
        

        if (!$mail->Send()) {
			if($notvalidation){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
			}
        }
		$_SESSION['email_sent'] = date('Y-m-d H:i:s');
		if($notvalidation){
		header('Content-Type: application/json');
		echo json_encode(['status' => 'success','time'=>$_SESSION['email_sent']]);
            exit;
		}
}


if (isset($_POST)) {
    if ($_GET['sendemail'] == true) {

        sendAnCustomerEmail($_POST);
       
    }
	
    if ($_GET['emailverification'] == 'true') {
        header('Content-Type: application/json');
		
        if (Capsule::table("mod_verifiedemail")
                        ->where('email', $_POST['email'])
                        ->where('verification_code', $_POST['verification_code'])->count() > 0) {
							
            Capsule::table("mod_verifiedemail")
                    ->where('email', $_POST['email'])
                    ->where('verification_code', $_POST['verification_code'])
                    ->update(array('is_verified'=> 1));
			 Capsule::table("tblclients")
                    ->where('email', $_POST['email'])                    
                    ->update(array('email_verified'=> 1));	
					
            echo json_encode(['status' => 'success']);
            exit;
        } else {
            echo json_encode(['status' => 'false']);
            exit;
        }
		exit;
    }
}

add_hook("ShoppingCartValidateCheckout", 1, function($vars){
	$configemail_verification = Capsule::table("mod_configemail_verification")
                        ->where('setting','modulestatus')->pluck('value','setting');
		if(count($configemail_verification) != 0 && $configemail_verification['modulestatus'] == 'N'){
			return "";
		}
		$velidation_message = Capsule::table("mod_configemail_verification")
                        ->pluck('value','setting');
        $client = Menu::context("client");
		 if (is_null($client)){
			 $count = Capsule::table("mod_verifiedemail")
                    ->where('email', $vars['email'])
                    ->where('is_verified', 1)
                    ->count();
			 if($count==0){				 
				 sendAnCustomerEmail($vars,false);
				 $message = (($velidation_message['validation_message']) ? $velidation_message['validation_message'] : "You may verify your email address first before you can complete this order!, Please verify using below button.");
				 return array($message);
			 }		
		 }
    
});

add_hook('PreDeleteClient', 1, function($vars) {
	# Delete Group Record
	$data = Capsule::table('tblclients')
		->where("id", $vars['userid'])
		->first();
	
	Capsule::table("mod_verifiedemail")
		->where('email', $data->email)
		->delete();	
});

add_hook('ClientAdd', 1, function($vars) {
    $configemail_verification = Capsule::table("mod_configemail_verification")
                        ->where('setting','modulestatus')->pluck('value','setting');
	if(count($configemail_verification) != 0 && $configemail_verification['modulestatus'] == 'N'){
		return "";
	}
	
	
   $count = Capsule::table("mod_verifiedemail")
                    ->where('email', $vars['email'])
                    ->where('is_verified', 1)
                    ->count();
    if($count>0){
		Capsule::table("tblclients")
                    ->where('email', $vars['email'])                    
                    ->update(array('email_verified'=> 1));
	}	
});
add_hook('ClientAreaFooterOutput', 1, function($vars) {
    $configemail_verification = Capsule::table("mod_configemail_verification")
                        ->where('setting','modulestatus')->pluck('value','setting');
						
	if(count($configemail_verification) != 0 && $configemail_verification['modulestatus'] == 'N'){
		return "";
	}
    $urlparse = explode("/", $_SERVER['PHP_SELF']);
    if ($urlparse[count($urlparse) - 1] == "cart.php" && $_GET['a'] == "checkout") {

        $_SESSION['randomcode'] = round(rand(0, 100000) * 100000);
        $finalurl = $vars['systemurl'];
        return <<<HTML
<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Email Verification</h5>
		  </div>
		  <div class="modal-body">
				<div class="row" id="vrmessage">
					<div class="col-md-12">
						<span class="alert alert-info col-md-12">Verification code has been sent to your email address. &nbsp;&nbsp;<button id="resendverifyEmailButton" type="button" class="btn btn-primary btn-sm">Resend</button></span>
					</div>
				</div>
                        <form id="verificationform" method="post" action="{$finalurl}cart.php?emailverification=true" class="login-form" role="form">
				<div class="form-group">
					<label for="verification_code">Verification Code</label>
					<input type="text" name="verification_code" class="form-control" id="verification_code" placeholder="Enter verification code" autofocus="">
                                        <input type="hidden" value="{$_SESSION['randomcode']}" id="emailtoken" >
				</div>
			</form>
		  </div>
		  <div class="modal-footer">
			<button id="verifyEmailButton" type="button" class="btn btn-primary">Verify Email</button>
		  </div>
		</div>
	  </div>
	</div>';            
   <script type="text/javascript">
       var finalurl = "{$finalurl}";
	jQuery(document).ready(function(){
		jQuery('#inputEmail').parent().parent().removeClass('col-sm-6').addClass('col-sm-4');
    var addverification = '<div class="col-sm-2" id="verificationbuttonarea"><div class="form-group prepend-icon"><button type="button" class="btn btn-info" id="verificationbutton" >Verify Email</button></div></div>';        
    jQuery(addverification).insertAfter(jQuery('#inputEmail').parent().parent())        
    jQuery("#verificationbutton").click(function(){
            if(jQuery("#inputEmail").val()==""){
                alert("Please enter Email address");
                return;
            }
            if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(jQuery("#inputEmail").val())))
            {
              alert("You have entered an invalid email address!");  
              return;
            }
			
            jQuery.ajax({
                method: "POST",
                url: finalurl+"cart.php?sendemail=true",
                data: { verification_code: jQuery("#verification_code").val(), emailtoken: jQuery("#emailtoken").val(),email:jQuery("#inputEmail").val() }
            })
            .done(function( msg ) {
              $('#exampleModal').modal('show');
            });    
           
   });
   jQuery("#resendverifyEmailButton").click(function(){
	   jQuery("#vrmessage").hide();
	   jQuery.ajax({
                method: "POST",
                url: finalurl+"cart.php?sendemail=true",
                data: { resend:"true",verification_code: jQuery("#verification_code").val(), emailtoken: jQuery("#emailtoken").val(),email:jQuery("#inputEmail").val() }
            })
            .done(function( msg ) {
				jQuery("#vrmessage").show();
            }); 
   });
    jQuery("#verifyEmailButton").click(function(){
           if(jQuery("#verification_code").val()==""){
             alert("Please enter verification code");
             return;
            }
            $.ajax({
                method: "POST",
                url: jQuery("#verificationform").attr("action"),
                data: { verification_code: jQuery("#verification_code").val(), emailtoken: jQuery("#emailtoken").val(),email:jQuery("#inputEmail").val() }
            })
            .done(function( msg ) {
				console.log(msg);
				if(msg.status=="success"){
					jQuery("#verificationbuttonarea").remove();
					var addverification = '<div class="col-sm-2" id="verificationbuttonareanew"><div class="form-group prepend-icon" style="color:green;"><i class="fas fa-check " style="color:green;line-height:35px;"></i> Verified</div></div>';
					jQuery(addverification).insertAfter(jQuery('#inputEmail').parent().parent());        
					$('#exampleModal').modal('hide');					
				}else{
					alert("Wrong Code");
				}
              
            });                            
        });
	}) 
	
    
    </script>
            
HTML;
    }
});
