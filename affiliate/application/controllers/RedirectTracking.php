<?php

if (!defined('BASEPATH')) exit ('No direct script access allowed');

ini_set('display_errors', 0);

use App\Slug;
class RedirectTracking extends CI_Controller {
	
	public function external_integration($code) {

		list($user_id,$ads_id) = explode("-",_encrypt_decrypt(parse_affiliate_id($code),'decrypt'));
		$integration_tools_ads = $this->db->query("SELECT * from integration_tools_ads WHERE id = ".$ads_id)->row_array();
		
		if(empty($integration_tools_ads)) {
			show_404();
		}

		$integration_tools = $this->db->query("SELECT * from integration_tools WHERE id = ".$integration_tools_ads['tools_id'])->row_array();

		if(empty($integration_tools)) {
			show_404();
		}

		$this->load->model('IntegrationModel');
		$redirectLocation[] = $this->IntegrationModel->addParams($integration_tools['target_link'],"af_id", $code);

		$this->db->query("UPDATE integration_tools SET trigger_count = trigger_count + 1  WHERE id = ".$integration_tools_ads['tools_id']);

		redirect($redirectLocation[0]);
	}

	public function redirect_tracking_url($slug){
		$Slug = Slug::where('slug', 'like', $slug)->first();
		if(!$Slug){
			show_404();
		}else{
			if($Slug->type == 'register'){
				return redirect(base_url('register/' . base64_encode($Slug->user_id)));
			}else if($Slug->type == 'store'){
				return redirect(base_url('store/' . base64_encode($Slug->user_id)));
			}else if($Slug->type == 'product'){
				$result = $this->db->query("SELECT product_slug FROM product WHERE `product_id` = '".(int)$Slug->related_id."'")->row();
				return redirect(base_url('store/'.base64_encode($Slug->user_id).'/product/'.$result->product_slug));
			}else if($Slug->type == 'form'){
				$result = $this->db->query("SELECT seo FROM form WHERE `form_id` = '".(int)$Slug->related_id."'")->row();
				return redirect(base_url('form/'.$result->seo.'/'.base64_encode($Slug->user_id)) );
			}else{
				$result = $this->db->query("SELECT * FROM integration_tools WHERE `id` = '".(int)$Slug->related_id."' AND `tool_type` = '".$Slug->type."'")->row();

				if($result){
					$adQuery = $this->db->query("SELECT id FROM integration_tools_ads WHERE tools_id = {$result->id}")->row();

					if($adQuery) {
						$af_id = _encrypt_decrypt($Slug->user_id."-".$adQuery->id);
					} else {
						$af_id = _encrypt_decrypt($Slug->user_id."-".$result->id);
					}

				 	$url = $this->addParams($result->target_link,"af_id",$af_id);

				 	$this->db->query("UPDATE integration_tools SET trigger_count = trigger_count + 1  WHERE id = ".$result->id);
				 	
					return redirect($url);
				}
			}
		}
	}

	public function addParams($url, $key, $value) {
		$url = preg_replace('/(.*)(?|&)'. $key .'=[^&]+?(&)(.*)/i', '$1$2$4', $url .'&');
		$url = substr($url, 0, -1);
		
		if (strpos($url, '?') === false) {
			return ($url .'?'. $key .'='. $value);
		} else {
			return ($url .'&'. $key .'='. $value);
		}
	}
}