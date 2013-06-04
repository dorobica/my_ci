<?php

class Email extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('email');	

		$this->email->from('me@example.com', 'Sender name');
		$this->email->to('me@example.com', 'Reciever name');
		$this->email->subject('my_cy layout test email');			
	}

	public function __destruct() {
		$this->email->send();
		echo $this->email->print_debugger();
	}

	public function index() {
		
	}

	public function layout_email() {
		$this->email->message_with_layout('examples/email/layout', 'examples/email/view', array(
				'name' => 'Ionut Dorobantu'
			));
	}

	public function view_email() {
		$this->email->message_with_view('examples/email/view', array(
				'name' => 'Ionut Dorobantu'
			));		
	}
}