<?php

class RedBean extends CI_Controller {
	
	public function index() {
		
		$this->load->library('rb');
		$this->load->model('model_album');

		$album = R::dispense('album');
		$album->title = 'test2';
		try {
			R::store($album);	
		} catch (Exception $e) {
			//var_dump($e);
		}
		
	}
}