<?php
/** 
 *	Breadcrumbs class
 */
class Breadcrumb {
	private $base_url;
	private $bread;
	private $crumbs = array();

	private $minimum_crumbs_to_create_bread = 2; // 1 = always create 

	private $separator = '<span class="divider">/</span>';

	public function __construct($init_data = array()) 
	{
		if(is_array($init_data) && sizeof($init_data) > 0) {
			foreach($init_data as $init_property => $init_value) {
				if(property_exists('Breadcrumb', $init_property)) {
					$this->$init_property = $init_value;
				}
			}
		}
	}

	public function addCrumb($crumb = array()) 
	{
		if(is_array($crumb) && sizeof($crumb) > 0) {
			foreach($crumb as $url => $url_name) {
				$this->crumbs[$url] = $url_name;
			}
		}
	}

	public function removeCrumb($crumb_name)
	{
		if(isset($this->crumbs[$crumb_name])) {
			unset($this->crumbs[$crumb_name]);
		}
	}

	public function generate()
	{
		$result = '';
		if(is_array($this->crumbs) && sizeof($this->crumbs) > 0 && sizeof($this->crumbs) >= $this->minimum_crumbs_to_create_bread) {
			$result = '<ul class="breadcrumb">';
			foreach($this->crumbs as $crumb_url => $crumb_name) {
				if(strlen($crumb_url)) {
					//add slash if needed
					if(substr($crumb_url, 0, 1) !== '/') {
						$crumb_url = '/'.$crumb_url;
					}

					$result .= '<li><a href="'.$this->base_url.$crumb_url.'">'.$crumb_name.'</a> '.$this->separator.'</li>';
				} else {
					$result .= '<li class="active">'.$crumb_name.'</li>';
				}
			}
			$result .= '</ul>';
		}

		return $result;
	}
}