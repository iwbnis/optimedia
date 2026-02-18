<?php
class MY_Controller extends CI_Controller {

	protected $header_menu;

	function __construct() {
		parent::__construct();
		$this->db->query("SET SQL_MODE = ''");
		 
		$this->load->model("Product_model");
		$site_setting = $this->Product_model->getSettings('site');

		$method = $this->uri->segment('1');
		$escape_urls = ['store','admin','admincontrol','auth','integration','firstsetting', 'membership'];
		if ($site_setting['maintenance_mode'] && !in_array($method, $escape_urls)) {
			echo $this->load->view('common/maintenance', [], true);
			die;
		}

		if (isset($site_setting['time_zone']) && $site_setting['time_zone'] != '') {
			date_default_timezone_set($site_setting['time_zone']);
		} else{
			date_default_timezone_set('Asia/Kolkata');
		}

		$table = $this->db->table_exists('ci_sessions');
        if($table) { 
			$this->load->dbforge();
			$this->dbforge->drop_table('ci_sessions');
		}
		
		$loginData = [];
	    $loginData[] = $this->session->userdata('user');
	    $loginData[] = $this->session->userdata('client');
	    
	    foreach($loginData as $login) {
    	    if(isset($login['id']) && !empty($login['id'])) {
    	        $isUserExist = $this->db->query('SELECT id FROM users WHERE id='.$login['id'])->row();
    	        if(!isset($isUserExist->id)) {
    	            $this->session->sess_destroy();
    	            header("refresh: 1");
    	            break;
    
    	        }
    	    }
	    }

	    if($this->session->userdata('administrator') && $this->input->is_ajax_request() == false && file_exists(FCPATH."database_update_".$this->config->item('app_version').".sql")) {
			$this->load->model('Version_changes_model');
			$result1 = $this->Version_changes_model->update_changes();
			$result2 = $this->update_user_langauges();
			if(current_url() != base_url('admincontrol/system_update_report'))
				redirect(base_url('admincontrol/system_update_report'));
		}
	}

	public function build_paginate($query,$base,$page = 1, $limit=15){
		$this->load->library('pagination');
		$this->pagination->cur_page = $page;

		$total = $query->total();
		$found = count($query);

		$config['base_url'] = base_url($base);
		$config['per_page'] = $limit;
		$config['total_rows'] = $total;
		$config['use_page_numbers'] = TRUE;
		$config['enable_query_strings'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		$_GET['page'] = $page;
		$config['page_query_string'] = 'page';
		$this->pagination->initialize($config);

		if($total == 0) {
			$result = "";
		} else {
			$result = '<div><div style="color:#333">'.__('admin.showing').'<span style="color:#3E7CB3"> '. max((($page-1)*$limit),0) .'-'. ((($page-1)*$limit)+$found) .' </span>'.__('admin.of').' <span style="color:#3E7CB3">'.$total.'</span> '.__('admin.results').'</div></div>';
		}
		
		return  [$this->pagination->create_links(),$result];
	}

	public function checkLogin($type = 'admin'){
		if($type == 'admin'){
			$type = 'administrator';
		}

		$userdetails = $this->session->userdata($type);
		if(!$userdetails){
			if($type == 'administrator'){
				redirect('/admin');
			}
			else {
				redirect('/');
			}
		}

		return $userdetails;
	}

	public function post_data(){
		return $this->input->post(NULL,true);
	}

	public function session_message($message, $type = 'success'){
		$this->session->set_flashdata($type, $message);
	}

	public function json($json = array()){
		header('Content-Type: application/json');
		echo json_encode($json);
	}

	public function get_restricted_vendors(int $user_id = null) {
		$this->load->model('Product_model');
		$vendoerMinDeposit = $this->Product_model->getSettings('site', 'vendor_min_deposit');

		$vendoerMinDeposit = isset($vendoerMinDeposit['vendor_min_deposit']) ? $vendoerMinDeposit['vendor_min_deposit'] : 0;

		$vendors = $this->db->query('SELECT id from users where is_vendor = 1')->result_array();

		$this->load->model('Total_model');

		$restrcted_vendors = [];

		$vendorDepositStatus = $this->Product_model->getSettings('vendor', 'depositstatus');
		if($vendorDepositStatus['depositstatus'] == 1){
			if($user_id == null) {
				foreach($vendors as $v) {
					
					$balence = $this->Total_model->getUserBalance($v['id']);
					if($balence < $vendoerMinDeposit) {
						$restrcted_vendors[] = $v['id'];
					}
				}
			} else {
				$balence = $this->Total_model->getUserBalance($user_id);
				if($balence < $vendoerMinDeposit) {
					$restrcted_vendors[] = $user_id;
				}
			}
		}

		return $restrcted_vendors;
	}

	// public function prepareDepositeWarningData($data)
	// {
	// 	$loginUser = $this->session->userdata('user');
	// 	if(isset($loginUser['is_vendor']) && $loginUser['is_vendor'] == 1) {
	// 		$restrcition = $this->get_restricted_vendors($loginUser['id']);
	// 		$data['show_deposit_warning'] = empty($restrcition) ? 0 : 1;

	// 		$vendoerMinDeposit = $this->Product_model->getSettings('site', 'vendor_min_deposit');
	// 		$data['vendor_min_deposit'] = isset($vendoerMinDeposit['vendor_min_deposit']) ? $vendoerMinDeposit['vendor_min_deposit'] : 0;
			
	// 		$data['vendor_min_deposit_warning'] = __('admin.minimum_deposit_warning');
	// 	}

	// 	return $data;
	// }

	public function view($data, $file, $control = 'admincontrol'){
		// $data = $this->prepareDepositeWarningData($data);
		$this->load->view($control.'/includes/header', $data);
		$this->load->view($control.'/includes/sidebar', $data);
		$this->load->view($control.'/includes/topnav', $data);
		$this->load->view($control.'/'. $file, $data);
		$this->load->view($control.'/includes/footer', $data);
	}

	public function view_new($data, $file, $control = 'admincontrol'){
		$this->load->view($control.'/includes/header_new', $data);
		$this->load->view($control.'/includes/sidebar_new', $data);
		$this->load->view($control.'/includes/topnav_new', $data);
		// $this->load->view($control.'/'. $file, $data);
		$this->load->view($control.'/includes/footer_new', $data);
	}

	public function update_user_langauges($is_admin_request = null) {
		$data['results'] = [["info"=>"Language files update is started..."]];
		try {
			$all_languages_json = file_get_contents(FCPATH.'assets/data/languages.json');
			$all_languages = json_decode($all_languages_json, true);

			$userLanguagesQuery = $this->db->get('language');
			$userLanguages = $userLanguagesQuery->result();
			
			if($is_admin_request != null) {
				$files_updated = 0;
			}

			foreach($userLanguages as $language) {
				if($language->name == "English") {
					$userLanguagesDataPath = FCPATH."application/language/default";
					$defaultLanguagesDataPath = FCPATH."application/language/default/default";
				} else {
					$userLanguagesDataPath = FCPATH."application/language/".$language->id;
					$languages_code = array_search($language->name, $all_languages);
					$defaultLanguagesDataPath = FCPATH."application/language/default/".$languages_code;
				}

				if(is_dir($userLanguagesDataPath) && is_dir($defaultLanguagesDataPath)) {
					$defaultLangData = [];
					$selected_folders = scandir($defaultLanguagesDataPath);
					for ($i = 2; $i < sizeof($selected_folders); $i++){
						if(is_file($defaultLanguagesDataPath."/".$selected_folders[$i]) && strpos($selected_folders[$i], '.php') !== false) {
							$defaultLangData[$selected_folders[$i]] = file($defaultLanguagesDataPath."/".$selected_folders[$i], FILE_SKIP_EMPTY_LINES);
						}
					}

					$userLangData = [];
					$selected_folders = scandir($userLanguagesDataPath);
					for ($i = 2; $i < sizeof($selected_folders); $i++){
						if(is_file($userLanguagesDataPath."/".$selected_folders[$i]) && strpos($selected_folders[$i], '.php') !== false) {
							$lines = file($userLanguagesDataPath."/".$selected_folders[$i], FILE_SKIP_EMPTY_LINES);   
							$lines = array_filter($lines, function($line) {
								return strpos($line, "'';") == false && (strpos($line, "\$lang") !== false || strpos($line, "?php") !== false);
							});
							file_put_contents($userLanguagesDataPath."/".$selected_folders[$i], implode("\n", $lines));
							$userLangData[$selected_folders[$i]] = file_get_contents($userLanguagesDataPath."/".$selected_folders[$i]);
						}
					}
			
					$newLineAdded = false;
					foreach($defaultLangData as $key => $default) {
						for ($i=0; $i < sizeof($default); $i++) {
							$lang_key = trim(explode("=",$default[$i])[0]); 
							$lang_key = str_replace("\$lang['", "", $lang_key);
							$lang_key = str_replace("']", "", $lang_key);
							if (!str_contains($userLangData[$key], $lang_key)) { 
								if(!$newLineAdded) {
									file_put_contents($userLanguagesDataPath.'/'.$key, "\n", FILE_APPEND);
									$newLineAdded = true;
								}
								file_put_contents($userLanguagesDataPath.'/'.$key, $default[$i], FILE_APPEND);
								if($is_admin_request != null) {
									$files_updated++;
								}
							}
						}
					}

					if($newLineAdded == true) {
						$data['results'][] = [
							"success" => $language->name.' Language file updated successfully!'
						];
					}
				}
			}

			if($is_admin_request != null) {
				if($files_updated > 0) {
					$this->session->set_flashdata('success', 'Language files updated successfully!');
				} else {
					$this->session->set_flashdata('success', 'Language files are already up to date!');
				}
				redirect('/admincontrol/language');
			}

			$data['results'][] = [
				"success" => 'Language files update completed!'
			];
		} catch (Exception $e) {
			$data['results'][] = [
				"error" => $e->getMessage()
			];
		}

		return $data['results'];
	}
}
