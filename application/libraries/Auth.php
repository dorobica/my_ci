<?php

class Auth {
	private $CI;

	private $session_name = 'auth';
	private $session_expire;
	private $session_remember;
	private $session_fields = array(
			'id','email', 'nonexistfield'
		);

	public function __construct() {
		$this->session_expire = 60*60*60;//1h
		$this->session_remember = 60*60*60*24*7;//one week

		$this->CI =& get_instance();
	}

	public function login($email, $password, $remember=FALSE) {
		$user = R::findOne('user', 'email=?', array(
				$email
			));

		if($user !== NULL) {
			if($user->password == self::_hash_password($password)) {
				//login
				$session_data = array();
				foreach($this->session_fields as $field) {
					if(isset($user->$field)) {
						$session_data[$field] = $user->$field;
					}
				}
				$session_data['expire'] = time() + $this->session_expire;
				if($remember) {
					$session_data['expire'] = time() + $this->session_remember;
				}

				$this->CI->session->set_userdata($this->session_name, $session_data);
				return TRUE;
			}
		}
		return FALSE;
	}

	public function logout() {
		return $this->CI->session->unset_userdata($this->session_name);
	}

	public function is_logged() {
		$session = $this->CI->session->userdata($this->session_name);
		if(!$session || $session && $session['expire'] < time()) {
			$this->logout();
			return FALSE;
		}
		return $session;
	}

	public function update_session_data($new_data) {
		$session = $this->CI->session->userdata($this->session_name);
		if($session) {
			foreach($this->session_fields as $field) {
				if(isset($session[$field]) && isset($new_data[$field])) {
					$session[$field] = $new_data[$field];
				}
			}
			$this->CI->session->set_userdata($this->session_name, $session);
			return TRUE;
		}
		return FALSE;
	}

	private static function _hash_password($password) {
		return sha1($password);
	}
}