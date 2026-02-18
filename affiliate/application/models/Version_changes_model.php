<?php	
class Version_changes_model extends MY_Model{

	// function for call onetime to setup new changes after update
	public function update_changes() {
		$data_results = [
			["info"=>"system update is started..."]
		];

		try {
			// update database from sql file from root directory
			$data_results_sub1 = $this->import_database_changes();

			$data_results = array_merge($data_results, $data_results_sub1);

			// create versions.php file with update version number
			$data_results_sub2 = $this->update_version_details();
			$data_results = array_merge($data_results, $data_results_sub2);

			// clear image cache folders
			$data_results_sub3 = $this->clear_image_cache_and_log_folders();
			$data_results = array_merge($data_results, $data_results_sub3);

			// set default as selected theme 
			$data_results_sub4 = $this->set_default_theme();
			$data_results = array_merge($data_results, $data_results_sub4);

			// delete unnecessary files from script
			$data_results_sub5 = $this->unlink_deprecated_files();
			$data_results = array_merge($data_results, $data_results_sub5);

			// remove deprecated directory's folders and files
			$data_results_sub6 = $this->remove_deprecated_directory();
			$data_results = array_merge($data_results, $data_results_sub6);

			$data_results_sub7 = $this->drop_deprecated_table();
			$data_results = array_merge($data_results, $data_results_sub7);

			$data_results_sub8 = $this->update_mail_templates();
			$data_results = array_merge($data_results, $data_results_sub8);
			
			// $this->session->sess_destroy();
			
			$this->output->delete_cache(base_url());

		} catch (Exception $e) {
			$data_results[] = [
				"error" => $e->getMessage()
			];
		}

		file_put_contents(APPPATH."logs/system_update_log.json", json_encode($data_results));
		return $data_results;
	}


	private function import_database_changes(){
		$resultArray = [["info"=>"database update is started..."]];

		try {
			// generate backup of existing database before migrate to new version
			$this->load->dbutil();
			$prefs = array(
				'format'        => 'txt',
				'filename'      => $this->db->database,
				'add_drop'      => true,
				'add_insert'    => true,
				'newline'       => "\n"
			);
			$backup =& $this->dbutil->backup($prefs);
			$db_name = 'dbbkp_before_ver_'.$this->config->item('app_version').'_at_'.time().'.sql';
			$bk_path = 'application/backup/'.$db_name;
			$this->load->helper('file');
			write_file($bk_path, $backup);
			$resultArray[] = [
				"success" => 'generated backup of existing database'
			];
		} catch (Exception $e) {
			$resultArray[] = [
				"error" => $e->getMessage()
			];

			$backup_failed = true;
		}

		if(isset($backup_failed)) {
			return $resultArray;
			die;
		}

		try {
			// migrate database to new version
			$resultArray[] = [
				"info" => 'migrate database to new version started'
			];

			$templine = '';
			$mysql_updates = "database_update_".$this->config->item('app_version').".sql";
			$file = fopen($mysql_updates,"r");
			while(! feof($file))
			{
				$line = fgets($file);
				if (substr($line, 0, 2) == '--' || $line == '')
				continue;
				$templine .= $line;
				if (str_contains($templine, 'SET @preparedStatement') && !str_contains($templine,'DEALLOCATE PREPARE alterIfNotExists'))
				continue;

				if (substr(trim($line), -1, 1) == ';') {
					$templine = str_replace('@databaseName', "\"".$this->db->database."\"", $templine);
					try {
						$this->db->db_debug = true;
						if(str_contains($templine, 'SET @preparedStatement')) {
							$qurisArray = $this->explodeSkipOne($templine);
							$this->db->trans_start();
							foreach ($qurisArray as $qerySQL) {

								if(strlen($qerySQL) > 5) {
									if(!$this->db->query($qerySQL)) {
										log_message('error', json_encode($this->db->error()));
										$resultArray[] = [
											"error" => json_encode($this->db->error())
										];
										$has_db_error  = true;
									} else {
										$resultArray[] = [
											"success" => $qerySQL
										];
									}
								}
							}
							$this->db->trans_complete();
						} else {
							if(!$this->db->query($templine)) {
								log_message('error', json_encode($this->db->error()));
								$resultArray[] = [
									"error" => json_encode($this->db->error())
								];
								$has_db_error  = true;
							}
						}
					} catch (\Throwable $th) {
						log_message('error', $th->getMessage());
						$resultArray[] = [
							"error" => $th->getMessage()
						];
						$has_db_error  = true;
					}
					$templine = '';
				}
			}
			fclose($file);
			
			copy($mysql_updates,"application/backup/".$mysql_updates);
			unlink($mysql_updates);

			if(!isset($has_db_error)) {
				$resultArray[] = [
					"success" => 'Database updated successfully!'
				];
			} else {
				$data['warning'][] = [
					"success" => 'Database may not be updated successfully!'
				];
			}
		} catch (Exception $e) {
			$resultArray[] = [
				"error" => $e->getMessage()
			];
		}

		return $resultArray;
	}

	public function update_version_details(){
		$data['results'] = [["info"=>"system version details are upgrading"]];
		try {
			$oldVersion = SCRIPT_VERSION;
			$newVersion = $this->config->item('app_version');
			if(!defined('SCRIPT_VERSION') || SCRIPT_VERSION != $this->config->item('app_version')) {
	     		$version = "<?php \n";
	     		$version .= "define('CODECANYON_LICENCE', '".CODECANYON_LICENCE."'); \n";
	     		$version .= "define('SCRIPT_VERSION', '".$this->config->item('app_version')."'); \n";
	    		file_put_contents(FCPATH."/install/version.php", $version);
	    		$data['results'][] = [
					"success" => "system version is upgraded from ".$oldVersion." to ".$newVersion
				];
		    } else {
		    	$data['results'][] = [
					"error" => "system version details may be not defined or already a latest version available"
				];
		    }
		} catch (Exception $e) {
			$data['results'][] = [
				"error" => $e->getMessage()
			];
		}

		return $data['results'];
	}

	private function clear_image_cache_and_log_folders() {
		$data['results'] = [["info"=>"system cache clearing"]];
		try {
			$folder_path = [];

			$folder_path[] =  FCPATH."assets/image_cache/cache/assets/images/form/favi/";

			$folder_path[] =  FCPATH."assets/image_cache/cache/assets/images/payments/";

			$folder_path[] =  FCPATH."assets/image_cache/cache/assets/images/product/upload/thumb/";

			$folder_path[] =  FCPATH."assets/image_cache/cache/assets/images/site/";

			$folder_path[] =  FCPATH."assets/image_cache/cache/assets/images/themes/";

			$folder_path[] =  FCPATH."assets/image_cache/cache/assets/images/wallet-icon/";

			$folder_path[] =  FCPATH."assets/image_cache/cache/assets/vertical/assets/images/users/";

			$folder_path[] =  FCPATH."application/logs/";

			foreach ($folder_path as $key => $value) {

				$files = glob($value.'/*');

				foreach($files as $file) { 

					if(is_file($file))  {
						unlink($file);
						$data['results'] = [["success"=>$file." cleared"]];
					};  

				}

			}

			$data['results'] = [["success"=>"system cache clearing completed"]];
		} catch (Exception $e) {
			$data['results'][] = [
				"error" => $e->getMessage()
			];
		}

		return $data['results'];
	}

	private function set_default_theme() {
		try {
			$this->db->query("UPDATE `setting` SET `setting_value`= 0 WHERE `setting_type`='store' AND `setting_key`='theme'");
			$data['results'] = [["success"=>"default theme setting updated"]];
		} catch (Exception $e) {
			$data['results'][] = [
				"error" => $e->getMessage()
			];
		}

		return $data['results'];
	}

	private function unlink_deprecated_files() {
		$data['results'] = [["success"=>"deleting deprecated files"]];
		try {
			$deprecated_files = [
				FCPATH."assets/login/login/js/analytics.js",
				FCPATH."assets/vertical/assets/images/flags/Indian_flag.jpg",
				FCPATH."assets/vertical/assets/images/flags/french_flag.jpg",
				FCPATH."assets/vertical/assets/images/flags/germany_flag.jpg",
				FCPATH."assets/vertical/assets/images/flags/italy_flag.jpg",
				FCPATH."assets/vertical/assets/images/flags/russia_flag.jpg",
				FCPATH."assets/vertical/assets/images/flags/spain_flag.jpg",
				FCPATH."assets/vertical/assets/images/flags/us_flag.jpg",
				FCPATH."application/controllers/User_BK.php",
				FCPATH."application/models/Version_changes_model_completed.php",
				FCPATH."application/views/usercontrol/login/index1.php",
				FCPATH."application/views/usercontrol/login/index2.php",
				FCPATH."application/views/usercontrol/login/index3.php",
				FCPATH."application/views/usercontrol/login/index4.php",
				FCPATH."application/views/usercontrol/login/index5.php",
				FCPATH."application/views/usercontrol/login/index6.php",
				FCPATH."application/views/usercontrol/login/index7.php",
				FCPATH."application/views/usercontrol/login/index8.php",
				FCPATH."application/views/usercontrol/login/index9.php",
				FCPATH."application/views/usercontrol/login/login.php",
				FCPATH."application/core/Razorpay/libs/Requests-1.7.0/.coveralls.yml",
				FCPATH."application/core/Razorpay/libs/Requests-1.7.0/.gitignore",
				FCPATH."application/core/Razorpay/libs/Requests-1.7.0/.travis.yml",
			];

			foreach($deprecated_files as $file) {
				if(is_file($file)) {
					unlink($file);
					$data['results'] = [["success"=> $file." deleted successfully"]];
				};
			}
		} catch (Exception $e) {
			$data['results'][] = [
				"error" => $e->getMessage()
			];
		}

		return $data['results'];
	}

	public function remove_deprecated_directory(){
		$data['results'][] = ["success"=>"removing deprecated folders"];
		try {
			$deprecated_directories = [
				FCPATH."application/core/paytm",
				FCPATH."application/core/Razorpay",
				FCPATH."application/core/stripe",
				FCPATH."application/core/xendit",
				FCPATH."application/core/yandex",
				FCPATH."application/libraries/paypal",
				FCPATH."application/deposit_payments",
				FCPATH."application/membership_payment",
				FCPATH."application/payments",
				FCPATH."assets/images/payments",
			];

			foreach($deprecated_directories as $deprecated_directory){
				$result = self::remove_deprecated_directory_folder_and_files($deprecated_directory);
				if(is_dir($deprecated_directory))
					$data['results'][] = ["success"=> $deprecated_directory." removed successfully"];
			}
		} catch (Exception $e) {
			$data['results'][] = [
				"error" => $e->getMessage()
			];
		}

		return $data['results'];
	}

	private function remove_deprecated_directory_folder_and_files($deprecated_directory){
	    if(substr($deprecated_directory, strlen($deprecated_directory) - 1, 1) != '/')
	        $deprecated_directory .= '/';

	    $files = glob($deprecated_directory.'*',GLOB_MARK);
	    foreach($files as $file){
	        if(is_dir($file))
	            self::remove_deprecated_directory_folder_and_files($file);
	        else
	            unlink($file);
	    }
	    rmdir($deprecated_directory);

	    return;
	}

	public function drop_deprecated_table() {
		$this->db->db_debug = true;
		$data['results'] = [["success"=>"deleting deprecated tables"]];
		try {
			// deprecate usage of bt_custom_field_status and bt_custom_field  from version 4.0.0.6
			if($this->db->table_exists('bt_custom_field')) {
				$this->db->query("DROP TABLE `bt_custom_field`");
			}

			if($this->db->table_exists('bt_custom_field_status')) {
				$existingData = $this->db->query('SELECT * FROM bt_custom_field_status')->row();

				$count = $this->db->query('SELECT * FROM setting WHERE `setting_type`="withdrawalpayment_bank_transfer" AND `setting_key`="bt_custom_field"')->num_rows();

				$fieldsData = array(
					'setting_type' => 'withdrawalpayment_bank_transfer',
					'setting_key' => 'bt_custom_field',
					'setting_value' => $existingData->response,
					'setting_status' => 1,
					'setting_ipaddress' => '::1',
					'setting_is_default' => 0
				);

				if($count > 0) {
					$this->db->where(array(
						'setting_type' => 'withdrawalpayment_bank_transfer',
						'setting_key' => 'bt_custom_field',
					));
					$this->db->update('setting', $fieldsData);
				} else {
					$this->db->insert('setting', $fieldsData);
				}

				$count = $this->db->query('SELECT * FROM setting WHERE `setting_type`="withdrawalpayment_bank_transfer" AND `setting_key`="response_validate"')->num_rows();

				$fieldsData = array(
					'setting_type' => 'withdrawalpayment_bank_transfer',
					'setting_key' => 'response_validate',
					'setting_value' => $existingData->response_validate,
					'setting_status' => 1,
					'setting_ipaddress' => '::1',
					'setting_is_default' => 0
				);

				if($count > 0) {
					$this->db->where(array(
						'setting_type' => 'withdrawalpayment_bank_transfer',
						'setting_key' => 'response_validate',
					));
					$this->db->update('setting', $fieldsData);
				} else {
					$this->db->insert('setting', $fieldsData);
				}

				$this->db->query("DROP TABLE `bt_custom_field_status`");
			}
			$data['results'][] = [
				"success" => 'deprecated table dropped successfully'
			];
		} catch (Exception $e) {
			$data['results'][] = [
				"error" => $e->getMessage()
			];
		}

		return $data['results'];
	}

	private function update_mail_templates() {
		try {
			
	    	$newMailTemplates = [['subscription_status_change', 'Subscription Status Changed', 'Subscription Status Changed', '<p>Dear [[firstname]],</p>\r\n                <p>Your subscription status has been changed to [[status_text]]</p>\r\n                <p>Comment: [[comment]] </p>\r\n                [[website_name]]<br />\r\n                Support Team</p>', '', NULL, NULL, '', 'comment,planname,price,expire_at,started_at,status_text,firstname,lastname,email,username,website_url,website_name,website_logo,name'], ['subscription_buy', 'Subscription Buy', 'Subscription Buy', '<h2>Thanks for your order</h2>\r\n\r\n<p>Welcome to Prime. As a Prime member, enjoy these great benefits. If you have any questions, call us any time at or simply reply to this email.</p>\r\n', 'New Subscription Buy From [[firstname]] [[lastname]]', NULL, NULL, '<h2>Thanks for your order</h2>\r\n\r\n<p>Welcome to Prime. As a Prime member, enjoy these great benefits. If you have any questions, call us any time at or simply reply to this email.</p>\r\n', 'planname,price,expire_at,started_at,firstname,lastname,email,username,website_url,website_name,website_logo,name'], ['subscription_expire_notification', 'Subscription Expire Notification', 'Your Subscription Will Be Expired Soon.', '<p>customText</p>\r\n', NULL, NULL, NULL, NULL, 'planname,price,expire_at,started_at,firstname,lastname,email,username,website_url,website_name,website_logo,name'], ['wallet_noti_on_hold_wallet', 'Wallet Status Change To On Hold', '[[amount]] is put on hold in your wallet', '<p>Dear [[name]],</p>\n        <p>Transactions #[[id]] status changed to [[new_status]]. amount is [[amount]]</p>\n        <p><br />\n        [[website_name]]<br />\n        Support Team</p>\n', '', NULL, NULL, NULL, 'amount,id,name,new_status,user_email,website_name,website_logo,name'], ['new_user_request', 'New User Request', 'User Registration Successfull', '<p>Dear [[firstname]] [[lastname]],</p>\r\n\r\n<p>User account has been registered successfully on [[website_name]], please wait while system admin apporve&nbsp;your request.<br />\r\nWe will inform you once account has been approved, Thank You.</p>\r\n\r\n<p>Support Team<br />\r\n[[website_name]]</p>\r\n', 'New User Registration - Approval Pending', NULL, NULL, '<p>Dear Admin,</p>\r\n\r\n<p>New user has been registered on [[website_name]], apporval is pending yet!</p>\r\n\r\n<p>User Details</p>\r\n\r\n<p>Name : [[firstname]][[lastname]]<br />\r\nEmail :&nbsp;[[email]]<br />\r\nUsername : [[username]]<br />\r\nSupport Team<br />\r\n[[website_name]]</p>', 'firstname,lastname,email,username,website_name,website_logo'], ['new_user_approved', 'New User Request Approved', 'User Account Approved', '<p>Dear [[firstname]] [[lastname]],</p>\r\n\r\n<p>Your new user account registration request is accepted by admin, you can login and use services.</p>\r\n\r\n<p>[[website_name]]<br />\r\nSupport Team</p>\r\n', 'User Account Approved', NULL, NULL, '<p>Dear Admin,</p>\r\n\r\n<p>You have approced registration request of user having</p>\r\n\r\n<p>Name : [[firstname]]&nbsp;[[lastname]]</p>\r\n\r\n<p>Email : [[email]]</p>\r\n\r\n<p>Username : [[username]]</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Support Team</p>\r\n\r\n<p>[[website_name]]</p>\r\n', 'firstname,lastname,email,username,website_name,website_logo'], ['new_user_declined', 'New User Request Declined', 'User Account Declined', '<p>Dear [[firstname]] [[lastname]],</p>\r\n\r\n<p>Your new user account registration request is declined by admin, for more information please contact supprt team</p>\r\n\r\n<p>[[website_name]]<br />\r\nSupport Team</p>\r\n', 'User Account Declined', NULL, NULL, '<p>Dear Admin,</p>\r\n\r\n<p>You have declined registration request of user having</p>\r\n\r\n<p>Name : [[firstname]]&nbsp;[[lastname]]</p>\r\n\r\n<p>Email : [[email]]</p>\r\n\r\n<p>Username : [[username]]</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Support Team</p>\r\n\r\n<p>[[website_name]]</p>\r\n', 'firstname,lastname,email,username,website_name,website_logo'], ['new_vendor_deposit_request', 'New Vendor Deposit Request', 'New Deposit Request Added', '<p>Dear [[firstname]] [[lastname]],</p>\r\n\r\n<p>Your deposit request of amount [[amount]] is added, if your balance not updated please contact support team</p>\r\n\r\n<p>[[website_name]]<br /> \r\n Support Team</p>', 'New Deposit Request Added', NULL, NULL, '<p>Dear Admin,</p>\r\n\r\n<p>You have new deposit request of amount [[amount]] from vendor having</p>\r\n\r\n<p>Name : [[firstname]]&nbsp;[[lastname]]</p>\r\n\r\n<p>Email : [[email]]</p>\r\n\r\n<p>Username : [[username]]</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Support Team</p>\r\n\r\n<p>[[website_name]]</p>', 'status,amount,firstname,lastname,email,username,website_name,website_logo'], ['vendor_deposit_request_updated', 'Deposit Request Updated', 'Deposit Request Updated', '<p>Dear [[firstname]] [[lastname]],</p>\r\n\r\n<p>Your deposit request of amount [[amount]] is updated to [[status]], if have any queries please contact support team</p>\r\n\r\n<p>[[website_name]]<br /> \r\n Support Team</p>', 'Deposit Request Updated', NULL, NULL, '<p>Dear Admin,</p>\r\n\r\n<p>You have changed status of deposit request to [[status]] from vendor having</p>\r\n\r\n<p>Name : [[firstname]]&nbsp;[[lastname]]</p>\r\n\r\n<p>Email : [[email]]</p>\r\n\r\n<p>Username : [[username]]</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Support Team</p>\r\n\r\n<p>[[website_name]]</p>', 'status,amount,firstname,lastname,email,username,website_name,website_logo'],['user_level_changed', 'Change user level', 'Your user level changed', '<p>Dear,</p><p>Your level changed from [[from_level]] to [[to_level]]</p>                     <p><br>                 [[website_name]]<br>                 Support Team</p>             ', NULL, NULL, NULL, NULL, 'from_level,to_level,website_name']];

	    	for ($i=0; $i < sizeof($newMailTemplates); $i++) { 
	    		$this->db->query("INSERT INTO `mail_templates` (`unique_id`, `name`, `subject`, `text`, `admin_subject`, `client_subject`, `client_text`, `admin_text`, `shortcode`) SELECT * FROM (SELECT '".$newMailTemplates[$i][0]."' AS `unique_id`, '".$newMailTemplates[$i][1]."' AS `name`, '".$newMailTemplates[$i][2]."' AS `subject`, '".$newMailTemplates[$i][3]."' AS `text`, '".$newMailTemplates[$i][4]."' AS `admin_subject`, '".$newMailTemplates[$i][5]."' AS `client_subject`, '".$newMailTemplates[$i][6]."' AS `client_text`, '".$newMailTemplates[$i][7]."' AS `admin_text`,'".$newMailTemplates[$i][8]."' AS `shortcode`) AS tmp WHERE NOT EXISTS ( SELECT `unique_id` FROM `mail_templates` WHERE `unique_id` = '".$newMailTemplates[$i][0]."' ) LIMIT 1;");
	    	}

	    	$data['results'][] = ["info"=>"mail templates updated..."];
    	} catch (Exception $e) {
			$data['results'][] = [
				"error" => $e->getMessage()
			];
		}

		return $data['results'];
    }

	function explodeSkipOne(string $weapon) {
        if (!$weapon)
	        return;
	    $spiltthum = explode(';', $weapon);
	    $ThuImg = [];
	    for ($i = 0; $i < sizeof($spiltthum); $i++){
	    	if($i == 1) {
	    		$ThuImg[0] .= $spiltthum[$i];
	    	} else {
	    		$ThuImg[] = $spiltthum[$i];
    		}
	    }
	    return $ThuImg;
	}
}