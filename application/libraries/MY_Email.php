<?php

class MY_Email extends CI_Email {
	private $CI;

	public function __construct($config=array()) {
		parent::__construct($config);
		$this->CI =& get_instance();
	}

	public function message_with_layout($layout, $view, $view_data = array()) {
		$this->mailtype = 'html';

		$this->CI->load->library('Layout', array(
				'layout_name' => $layout
			));
		$body = $this->CI->layout->view($view, $view_data, TRUE);

		return $this->message($body);
	}

	public function message_with_view($view, $view_data = array()) {
		$this->mailtype = 'html';

		$body = $this->CI->load->view($view, $view_data, TRUE);

		return $this->message($body);
	}
}