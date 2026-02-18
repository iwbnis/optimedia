<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Pagebuilder extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('user_model', 'user');
		$this->load->model('Product_model');
		$this->load->model('Report_model');
		$this->load->model('PagebuilderModel');
		$this->load->model('Common');
		___construct(1);
	}
	public function userdetails(){ return $this->session->userdata('administrator'); }
	public function userlogins(){ return $this->session->userdata('user'); }
	private function get_theme_list(){
		return $this->PagebuilderModel->getAlltheme();
	}

	public function register(){
		$json = array();

		$post = $this->input->post(null,true);
		$mail_array = $this->input->post(null,true);
		$mail_array['user_type'] = $post['user_type'] = 'user';

 		$login_data = $this->session->userdata("login_data");
 		if($login_data && isset($login_data['refid'])){
 			$post['refid'] = $login_data['refid'];
 		}

		$refid = isset($post['refid']) ? $post['refid'] : '';
		$post['affiliate_id'] = !empty($refid) ? base64_decode($refid) : 0;

		$isUser = false;
		if($this->userlogins()){
			$userdata = $this->userlogins();
			$isUser = $this->user->get_user_by_id($userdata['id']);
		}
		if($isUser){
			$json['redirect'] = base_url('usercontrol/dashboard');
		} else {
			$post = $this->input->post(null,true);
			$this->load->library('form_validation');
			$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
			$this->form_validation->set_rules('username', 'Username', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
			$this->form_validation->set_rules('terms', 'Terms and Condition', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required|trim', array('required' => '%s is required'));
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim', array('required' => '%s is required'));
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]', array('required' => '%s is required'));

			$json['errors'] = array();

			$register_form = $this->PagebuilderModel->getSettings('registration_builder');
						if($register_form){
				$customField = json_decode($register_form['registration_builder'],1);
			
				$filesAttached = [];

				$this->load->helper('string');

				foreach ($customField as $_key => $_value) {

					if(isset($_value['hide_on_registration']) && $_value['hide_on_registration']) continue;

					$field_name = 'custom_'. $_value['name'];

					$config['upload_path'] = "assets/user_upload/";
					$config['allowed_types'] = 'png|gif|jpeg|jpg|PNG|GIF|JPEG|JPG|ICO|ico|pdf|docx|doc|ppt|xls|txt';
					$config['max_size']      = 2048;

					if($_value['type'] == 'file') {
						if(isset($post['existing_'.$field_name])){
							if(is_array($post['existing_'.$field_name])) {
								$attahced_multi_azkja = $post['existing_'.$field_name];
							} else {
								$attahced_multi_azkja = [$post['existing_'.$field_name]];
							}
						} else {
							$attahced_multi_azkja = [];
						}
						if(is_array($_FILES[$field_name]['name'])) {
							if(isset($_FILES[$field_name]['name'][0]) && !empty($_FILES[$field_name]['name'][0])) {
								
								foreach ($_FILES[$field_name]['name'] as $key => $image) {
								    $_FILES['attahced_multi_azkja']['name']= $_FILES[$field_name]['name'][$key];
								    $_FILES['attahced_multi_azkja']['type']= $_FILES[$field_name]['type'][$key];
								   $_FILES['attahced_multi_azkja']['tmp_name']= $_FILES[$field_name]['tmp_name'][$key];
								    $_FILES['attahced_multi_azkja']['error']= $_FILES[$field_name]['error'][$key];
								    $_FILES['attahced_multi_azkja']['size']= $_FILES[$field_name]['size'][$key];

								    $config['file_name']  = random_string('alnum', 32);
									
									$this->load->library('upload', $config);
									
									$this->upload->initialize($config);

									if (!$this->upload->do_upload('attahced_multi_azkja')) {
										$error = $this->upload->display_errors();
										if(!str_contains($error, 'select a file')){
											$json['errors'][$field_name] = $error;
											break;
										} else {
											if((!isset($filesAttached[$field_name]) || empty($filesAttached[$field_name])) && isset($_value['required']) && $_value['required']) {
												$json['errors'][$field_name] = $error;
												break;
											}
										}
									} else {
										$ext = explode('.', $_FILES[$field_name]['name'][$key]);
										$attahced_multi_azkja[] = $config['file_name'].".".$ext[sizeof($ext)-1];
									}
								}

								$filesAttached[$field_name] = $attahced_multi_azkja;
							} else {
								if(isset($_value['required']) && $_value['required'] && (!isset($filesAttached[$field_name]) || empty($filesAttached[$field_name]))) {
									$json['errors'][$field_name] = "Please select file for upload!";
									break;
								}
							}
						} else {
							if(isset($_FILES[$field_name]['name']) && !empty($_FILES[$field_name]['name'])) {
								
								$config['file_name']  = random_string('alnum', 32);
								
								$this->load->library('upload', $config);
								
								$this->upload->initialize($config);

								if (!$this->upload->do_upload($field_name)) {
									$error = $this->upload->display_errors();
									if(!str_contains($error, 'select a file')){
										$json['errors'][$field_name] = $error;
										break;
									} else {
										if((!isset($filesAttached[$field_name]) || empty($filesAttached[$field_name])) && isset($_value['required']) && $_value['required']) {
											$json['errors'][$field_name] = $error;
											break;
										}
									}
								} else {
									$ext = explode('.', $_FILES[$field_name]['name']);
									$attahced_multi_azkja = [$config['file_name'].".".$ext[sizeof($ext)-1]];
								}

								$filesAttached[$field_name] = $attahced_multi_azkja;
							} else {
								if(isset($_value['required']) && $_value['required'] && (!isset($filesAttached[$field_name]) || empty($filesAttached[$field_name]))) {
									$json['errors'][$field_name] = "Please select file for upload!";
									break;
								}
							}
						}
					} else {
						if($_value['required'] == 'true'){
							if(!isset($post[$field_name]) || $post[$field_name] == ''){
								$json['errors'][$field_name] = $_value['label'] ." is required.!";
							}
						}

						if(!isset($json['errors'][$field_name]) && (int)$_value['maxlength'] > 0){
							if(strlen( $post[$field_name] ) > (int)$_value['maxlength']){
								$json['errors'][$field_name] = $_value['label'] ." Maximum length is ". (int)$_value['maxlength'];
							}
						}

						if(!isset($json['errors'][$field_name]) && (int)$_value['minlength'] > 0){
							if(strlen( $post[$field_name] ) > (int)$_value['minlength']){
								$json['errors'][$field_name] = $_value['label'] ." Minimum length is ". (int)$_value['minlength'];
							}
						}
					}

				}

			}

			if ($this->form_validation->run() == FALSE) {
				$json['errors'] = array_merge($this->form_validation->error_array(), $json['errors']);
			}

			$googlerecaptcha = $this->PagebuilderModel->getSettings('googlerecaptcha');
			if (isset($googlerecaptcha['affiliate_register']) && $googlerecaptcha['affiliate_register']) {
				if($post['g-recaptcha-response'] == ''){
					$json['errors']['captch_response'] = 'Invalid Recaptcha';
				}
			}

			if( count($json['errors']) == 0 ){
				if (isset($googlerecaptcha['affiliate_register']) && $googlerecaptcha['affiliate_register']) {
					$post = http_build_query(
					 	array (
					 		'response' => $this->input->post('g-recaptcha-response',true),
					 		'secret' => $googlerecaptcha['secretkey'],
					 		'remoteip' => $_SERVER['REMOTE_ADDR']
					 	)
					);
					$opts = array('http' => 
						array (
							'method' => 'POST',
							'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                                      ."Content-Length: " . strlen($post) . "\r\n",
							'content' => $post
						)
					);
					$context = stream_context_create($opts);
					$serverResponse = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
					if (!$serverResponse) {
						$json['errors']['captch_response'] = 'Failed to validate Recaptcha';
					}
					$result = json_decode($serverResponse);

					if (!$result->success) {
						$json['errors']['captch_response'] = 'Invalid Recaptcha';
					}
				}
			}

			if( count($json['errors']) == 0){
				$checkEmail = $this->db->query("SELECT id FROM users WHERE email like ". $this->db->escape($this->input->post('email',true)) ." ")->num_rows();
				
				if($checkEmail > 0){ $json['errors']['email'] = "Email Already Exist"; }
				
				$checkUsername = $this->db->query("SELECT id FROM users WHERE username like ". $this->db->escape($this->input->post('username',true)) ." ")->num_rows();
				if($checkUsername > 0){ $json['errors']['username'] = "Username Already Exist"; }

				$store_name = $this->input->post('store_name',true);

				if(!empty($store_name)) {
					$store_slug = slugifyThis($store_name);
					$checkStorename = $this->db->query("SELECT id FROM users WHERE store_slug like '".$store_slug."' ")->num_rows();
					if($checkStorename > 0){ 
						$json['errors']['store_name'] = "Store Name Already Exist"; 
					}
				} else {
					$store_name = null;
					$store_slug = null;
				}
				

				if(count($json['errors']) == 0){	
					$user_type = 'user';
					$geo = $this->ip_info();
					

					$refid = !empty($refid) ? base64_decode($refid) : 0;
					$commition_setting = $this->Product_model->getSettings('referlevel');

					// echo json_encode($commition_setting);exit;

					$disabled_for = json_decode( (isset($commition_setting['disabled_for']) ? $commition_setting['disabled_for'] : '[]'),1); 
					
					if((int)$commition_setting['status'] == 0){ $refid  = 0; }
					else if((int)$commition_setting['status'] == 2 && in_array($refid, $disabled_for)){ $refid = 0; }

					$custom_fields = array();
                    foreach ($this->input->post(null,true) as $key => $value) {
                    	if(!in_array($key, array('affiliate_id','terms','cpassword','firstname','lastname','email','username','password'))){
                    		$custom_fields[$key] = $value;
                    	}
                    }

                    $membership = $this->Product_model->getSettings('membership');

					$allMembershipPlans = App\MembershipPlan::all();

					$is_vendor = $this->input->post('is_vendor',true);

                    $plan_id = -1;
                    
                    if($is_vendor == 1 && ($membership['status'] == 0 || $membership['status'] == 3)) {
                	    $plan_id = -1;
                	} else if($membership['status']){
                    	$plan_id = 0;
                    }

                    $is_approval_needed = $this->Product_model->getSettings('store', 'registration_approval');

                    $registration_approval = (isset($is_approval_needed['registration_approval']) && $is_approval_needed['registration_approval'] == 0) ? 1 : 0;

                    $defaultUserGroup = $this->user->getDefaultGroup();

                	$userGroups = (!empty($defaultUserGroup)) ? $defaultUserGroup->id : null;

					$data = $this->user->insert(array(
						'firstname'                 => $this->input->post('firstname',true),
						'lastname'                  => $this->input->post('lastname',true),
						'email'                     => $this->input->post('email',true),
						'username'                  => $this->input->post('username',true),
						'password'                  => sha1($this->input->post('password',true)),
						'refid'                     => $refid,
						'plan_id'                   => (int)$plan_id,
						'type'                      => $user_type,
						'Country'                   => $geo['id'],
						'City'                      => (string)$geo['city'],
						'phone'                     => $geo['city'],
						'twaddress'                 => '',
						'address1'                  => '',
						'address2'                  => '',
						'ucity'                     => $geo['city'],
						'ucountry'                  => $geo['id'],
						'state'                     => $geo['state'],
						'uzip'                      => '',
						'avatar'                    => '',
						'online'                    => '0',
						'unique_url'                => '',
						'bitly_unique_url'          => '',
						'created_at'                => date("Y-m-d H:i:s"),
						'updated_at'                => date("Y-m-d H:i:s"),
						'google_id'                 => '',
						'facebook_id'               => '',
						'twitter_id'                => '',
						'umode'                     => '',
						'PhoneNumber'               => '',
						'Addressone'                => '',
						'Addresstwo'                => '',
						'StateProvince'             => '',
						'Zip'                       => '',
						'f_link'                    => '',
						't_link'                    => '',
						'l_link'                    => '',
						'product_commission'        => '0',
						'affiliate_commission'      => '0',
						'product_commission_paid'   => '0',
						'affiliate_commission_paid' => '0',
						'product_total_click'       => '0',
						'product_total_sale'        => '0',
						'affiliate_total_click'     => '0',
						'sale_commission'           => '0',
						'sale_commission_paid'      => '0',
						'status'                    => '1',
						'is_vendor'					=> $is_vendor,
						'store_name'				=> $store_name,
						'store_slug'				=> $store_slug,
						'reg_approved'				=> $registration_approval,
						'value'                     => json_encode(array_merge($custom_fields, $filesAttached)),
						'groups'					=> $userGroups
					));

					$last_user_id = $this->db->insert_id();

					if($membership['status'] && $registration_approval == 1){
                    	if($membership['default_plan_id'] > 0){
                    		$plan = App\MembershipPlan::find($membership['default_plan_id']);
                    		if($plan){
								$user = App\User::find($data);
	                    		$plan->buy($user,1, 'Default plan started','Default');

	                    		// process fixed and custom % comission
	                    		$processReferComission = true;
                    		}
                    	}
                    }

                    if(empty($allMembershipPlans) || !isset($membership['status']) || empty($membership['status']) || !$membership['status']) {
                    	// process fixed and custom % comission
                    	$processReferComission = true;		
                    }

                    $json['processReferComission'] = $processReferComission;

					$post['refid'] = $refid;

					$json['refid'] = $refid;

					if(!empty($data) && $user_type == 'user'){
						
						if(isset($processReferComission) && (int)$refid > 0) {
							$this->load->model('Wallet_model');
							$comission_group_id = time().rand(10,100);
							$referlevelSettings = $this->Product_model->getSettings('referlevel');
							$max_level = isset($referlevelSettings['levels']) ? (int)$referlevelSettings['levels'] : 3;
							
							$json['max_level'] = $max_level;

							$disabled_for = json_decode( (isset($referlevelSettings['disabled_for']) ? $referlevelSettings['disabled_for'] : '[]'),1);
							$refer_status = true;
					        if((int)$referlevelSettings['status'] == 0){ $refer_status = false; }
						        else if((int)$referlevelSettings['status'] == 2 && in_array($refid, $disabled_for)){ $refer_status = false; }

					        $json['refer_status'] = $refer_status;
						    
						    if($refer_status) {
								$json['level'] = $level = $this->Product_model->getMyLevel($refid);	
								$json['max_level_user'] = [];

								$getSettingsFor = [];
            
					            for ($l=1; $l <= $max_level ; $l++) {
					                $getSettingsFor[] = 'referlevel_'. $l;
					            }

					            $referlevelSettingsss = $this->Product_model->getSettingsWhereIn($getSettingsFor);

								$transactionsBatch = [];

								for ($l=1; $l <= $max_level ; $l++) { 
									
									if($l == 1) {
										$json['max_level_user'][] = $levelUser = (int)$refid;	
									} else {
										$json['max_level_user'][] = $levelUser = (int)$level['level'.($l-1)];
									}

									$s = $referlevelSettingsss['referlevel_'. $l];

									if($s && $levelUser > 0){
										$_giveAmount = 0;
										
										if($referlevelSettings['reg_comission_type'] == 'custom_percentage'){
											if((int) $referlevelSettings['reg_comission_custom_amt'] > 0) {
												$_giveAmount = (($referlevelSettings['reg_comission_custom_amt'] * (float)$s['reg_commission']) / 100);
											}
										} else if($referlevelSettings['reg_comission_type'] == 'fixed'){
											$_giveAmount = (float)$s['reg_commission'];
										}

										$json['max_level_user']['_giveAmount'] = $_giveAmount;

										if($_giveAmount > 0){
											$transactionsBatch[] = array(
												'status'       => (int)$registration_approval,
												'user_id'      => $levelUser,
												'amount'       => $_giveAmount,
												'dis_type'     => '',
												'comment'      => "Level {$l} : ".'Commission for new affiliate registrion Id ='. $last_user_id .' | Name : '. $this->input->post('firstname',true) ." " .$this->input->post('lastname',true),
												'type'         => 'refer_registration_commission',
												'reference_id' => $last_user_id,
												'group_id' => $comission_group_id,
											);
										}
									}
								}

								if(!empty($transactionsBatch)) {
									$this->Wallet_model->addTransactionBatch($transactionsBatch);
								}
							}
						}

						$notificationData = array(
							'notification_url'          => '/userslist/'.$data,
							'notification_type'         =>  'user',
							'notification_title'        =>  __('user.new_user_registration'),
							'notification_viewfor'      =>  'admin',
							'notification_actionID'     =>  $data,
							'notification_description'  =>  $this->input->post('firstname',true).' '.$this->input->post('lastname',true).' register as a  on affiliate Program on '.date('Y-m-d H:i:s'),
							'notification_is_read'      =>  '0',
							'notification_created_date' =>  date('Y-m-d H:i:s'),
							'notification_ipaddress'    =>  $_SERVER['REMOTE_ADDR']
						);
						
						$this->insertnotification($notificationData);
						
						if ($post['affiliate_id'] > 0) {
							$notificationData = array(
								'notification_url'          => '/managereferenceusers',
								'notification_type'         =>  'user',
								'notification_title'        =>  __('user.new_user_registration_under_your'),
								'notification_viewfor'      =>  'user',
								'notification_view_user_id' =>  $post['affiliate_id'],
								'notification_actionID'     =>  $data,
								'notification_description'  =>  $this->input->post('firstname',true).' '.$this->input->post('lastname',true).' has been register under you on '.date('Y-m-d H:i:s'),
								'notification_is_read'      =>  '0',
								'notification_created_date' =>  date('Y-m-d H:i:s'),
								'notification_ipaddress'    =>  $_SERVER['REMOTE_ADDR']
							);
							$this->insertnotification($notificationData);
						}

						$json['success']  =  "You've Successfully registered";
	                    $user_details_array=$this->user->login($this->input->post('username',true));

	                    $post['user_type'] = 'user';
	                    $this->user->update_user_login($user_details_array['id']);
	                    
	                    $this->load->model('Mail_model');

						// 1 == enable (Approval For Registration)

						$where = array('id'=>$last_user_id);
						$new_post = $this->Common->select_where_result('users', $where);
						$new_post['user_type'] = $new_post['type'];
						if($registration_approval == 0) {
							$this->Mail_model->send_registration_request_mail($mail_array);
						} else {
							$this->Mail_model->send_register_mail($mail_array,__('user.welcome_to_new_user_registration'));
						}

						
		                    if ($user_type == 'user') {
		                    	$this->session->set_userdata(array('user'=>$user_details_array));
		                    	$json['redirect'] = base_url('usercontrol/dashboard');
		                    } else {
		                    	$this->session->set_userdata(array('client'=>$user_details_array));
		                    	$json['redirect'] = base_url('clientcontrol/dashboard');
		                    }							
						


					}
				}
			}
		}


			echo json_encode($json);
	}

	public function insertnotification($postData = null){
		if(!empty($postData)){
			$data['custom'] = $this->Product_model->create_data('notification', $postData);
		}
	}
	public function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
	    $output = NULL;
	    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
	        $ip = $_SERVER["REMOTE_ADDR"];
	        if ($deep_detect) {
	            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
	                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
	                $ip = $_SERVER['HTTP_CLIENT_IP'];
	        }
	    }
	    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
	    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
	    $continents = array(
	        "AF" => "Africa",
	        "AN" => "Antarctica",
	        "AS" => "Asia",
	        "EU" => "Europe",
	        "OC" => "Australia (Oceania)",
	        "NA" => "North America",
	        "SA" => "South America"
	    );
	    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
	        
	        $curl = curl_init("http://www.geoplugin.net/json.gp?ip=" . $ip);
	        $request = '';
	        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($curl, CURLOPT_HEADER, false);
	        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        
	        $ipdat = json_decode(curl_exec($curl));
	        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
	            switch ($purpose) {
	                case "location":
		                $id = 0;
	                    $code = @$ipdat->geoplugin_countryCode;
	                    $data = $this->db->query("SELECT id FROM countries WHERE sortname LIKE '{$code}' ")->row();
	                    if($data){
	                    	$id = $data->id;
	                    }
	                    $output = array(
							"city"           => @$ipdat->geoplugin_city,
							"state"          => @$ipdat->geoplugin_regionName,
							"country"        => @$ipdat->geoplugin_countryName,
							"country_code"   => @$ipdat->geoplugin_countryCode,
							"continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
							"continent_code" => @$ipdat->geoplugin_continentCode,
							"id"             => $id
	                    );
	                    break;
	                case "address":
	                    $address = array($ipdat->geoplugin_countryName);
	                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
	                        $address[] = $ipdat->geoplugin_regionName;
	                    if (@strlen($ipdat->geoplugin_city) >= 1)
	                        $address[] = $ipdat->geoplugin_city;
	                    $output = implode(", ", array_reverse($address));
	                    break;
	                case "city":
	                    $output = @$ipdat->geoplugin_city;
	                    break;
	                case "state":
	                    $output = @$ipdat->geoplugin_regionName;
	                    break;
	                case "region":
	                    $output = @$ipdat->geoplugin_regionName;
	                    break;
	                case "country":
	                    //$output = @$ipdat->geoplugin_countryName;
	                    $output = 0;
	                    $code = @$ipdat->geoplugin_countryCode;
	                    $data = $this->db->query("SELECT id FROM countries WHERE sortname LIKE '{$code}' ")->row();
	                    if($data){
	                    	$output = $data->id;
	                    }
	                    break;
	                case "countrycode":
	                    $output = @$ipdat->geoplugin_countryCode;
	                    break;
	            }
	        }
	    }
	   
	    return $output;
	}
}