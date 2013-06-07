<?php

class Thumb extends CI_Controller {
	
	public function index() {
		$this->load->library('phpthumbnail');

		try {
			$thumb = PhpThumbFactory::create('./static/examples/thumbtobe.jpg');	
			//$thumb->show();
			$thumb->resize(50, 50);
			$thumb->show();

		} catch (Exception $e) {
			ddump($e);
		}
		
	}
}