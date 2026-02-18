<?php	
class Setting_model extends MY_Model{
	public function clear($setting_type){
		$this->db->query('DELETE FROM setting WHERE setting_type= "'. $setting_type .'" ');
	}

	public function save($setting_type, $data){
		foreach ($data as $key => $value) {
			$this->db->where('setting_type',$setting_type);
			$this->db->where('setting_key',$key);
			$q = $this->db->get('setting');
			if (is_array($value)) {
				$value = json_encode($value);
			}
	
			if ( $q->num_rows() > 0 ){
				$this->db->where('setting_id',$q->row()->setting_id );
				$this->db->update('setting', array(
					'setting_value' => $value,
					'setting_ipaddress' => $_SERVER['REMOTE_ADDR'],
				));
			} else {
				$this->db->insert('setting',array(
					'setting_value' => $value,
					'setting_key' => $key,
					'setting_status' => 1,
					'setting_is_default' => 0,
					'setting_type' => $setting_type,
					'setting_ipaddress' => $_SERVER['REMOTE_ADDR'],
				));
			}
		}
	}

	public function vendorSave($user_id, $setting_type, $data){
		foreach ($data as $key => $value) {
			$this->db->where('user_id',$user_id);
			$this->db->where('setting_type',$setting_type);
			$this->db->where('setting_key',$key);
			$q = $this->db->get('vendor_config');
			if (is_array($value)) {
				$value = json_encode($value);
			}
	
			if ( $q->num_rows() > 0 ){
				$this->db->where('setting_id',$q->row()->setting_id );
				$this->db->update('vendor_config', array(
					'setting_value' => $value,
					'setting_ipaddress' => $_SERVER['REMOTE_ADDR'],
				));
			} else {
				$this->db->insert('vendor_config',array(
					'user_id' => $user_id,
					'setting_value' => $value,
					'setting_key' => $key,
					'setting_status' => 1,
					'setting_is_default' => 0,
					'setting_type' => $setting_type,
					'setting_ipaddress' => $_SERVER['REMOTE_ADDR'],
				));
			}
		}
	}

	public function save_meta($data, $where = null) {
		if($where != null) {
			$this->db->where($where);
			$this->db->update('meta_data', $data);
			return $where['meta_id'];
		} else {
			$this->db->insert('meta_data', $data);
			return $this->db->insert_id();
		}
	}

	public function get_meta_content($where) {
		$this->db->where($where);
		return $this->db->get('meta_data')->row();
	}
}