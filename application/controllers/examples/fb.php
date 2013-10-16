<?php

class Fb extends CI_Controller {

	public function index(){
		$this->load->library('facebook_lib');

		$facebook = new Facebook(array(
			'appId' => FB_APP_ID,
			'secret' => FB_APP_SECRET
		));

		$user = $facebook->getUser();

		echo $user;
	}
}
