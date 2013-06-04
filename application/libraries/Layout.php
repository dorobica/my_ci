<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{

    private $CI;
    private $layout;

    function __construct($data = array())
    {
        $this->CI =& get_instance();

        if(is_array($data) && isset($data['layout_name'])) {
            $this->setLayout($data['layout_name']);
        }
    }

    function setLayout($layout)
    {
        if(!$layout) {
            throw new LayoutException('No layout name provided');
        }

        $this->layout = $layout;
    }

    function view($view, $data=NULL, $return=FALSE)
    {
        $loadedData = array();
        $loadedData['content_for_layout'] = $this->CI->load->view($view, $data,TRUE);

        if($return) {
            $output = $this->CI->load->view($this->layout, $loadedData, TRUE);
            return $output;
        } else {
            $this->CI->load->view($this->layout, $loadedData, FALSE);
        }
    }
}

class LayoutException extends Exception {}