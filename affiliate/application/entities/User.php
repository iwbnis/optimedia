<?php
namespace App;
class User extends \Illuminate\Database\Eloquent\Model
{
	public $timestamps = false;

	public static function auth($type = 'user'){
		$CI =& get_instance();
		$user = false;

		$userdetails = $CI->session->userdata($type);
		if (isset($userdetails['id'])) {
			$user = self::find((int)$userdetails['id']);
		}

		return $user;
	}

	public function plan(){
		return MembershipUser::find($this->plan_id);
	}
}