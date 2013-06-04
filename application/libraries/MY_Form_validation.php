<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	public function __construct($rules = array())
	{
		parent::__construct($rules);
	}

    public function valid_url($str)
    {
        $this->prep_url($str);
        $this->set_message('valid_url', 'The %s field must be a valid URL');
        if(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $str)) {
            return (bool) @fopen($str,"r");
        }
        return FALSE;
    }

    /* custom array fields validations */
    public function array_exact_length($array_obj, $params)
    {
        $params = explode(',',$params);

        $this->set_message('array_min_length', 'The %s must have exactly '.$params[0].' enteries');

        //check length
        if(isset($_POST[$params[1]]) && is_array($_POST[$params[1]]) && sizeof($_POST[$params[1]]) == $params[0]) {
            return FALSE;
        }
        return TRUE;
    }

    public function array_min_length($array_obj, $params)
    {
    	$params = explode(',',$params);

    	$this->set_message('array_min_length', 'The %s must have a minimum of '.$params[0].' enteries');
        //clear empty array fields
        foreach($_POST[trim($params[1])] as $k => $v) {
            if(is_string($v) && !strlen($v) || is_array($v) && !sizeof($v)) {
                unset($_POST[trim($params[1])][$k]);
            }
        }

    	//check length
    	if(sizeof($_POST[trim($params[1])]) < $params[0]) {
    		return FALSE;
    	}
    	return TRUE;
    }

    public function array_max_length($array_obj, $params)
    {
    	$params = explode(',',$params);

    	$this->set_message('array_max_length', 'The %s must have a maximum of '.$params[0].' enteries');

    	//check length
    	if(sizeof($_POST[$params[1]]) > $params[0]) {
    		return FALSE;
    	}
    	return TRUE;
    }

}