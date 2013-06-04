<?php

class Pagination {
	private $base_url;

	private $per_page;
	private $total_rows;

	private $query_string;
	private $query_string_page_identifier = '__page';
	private $current_page;

	private $main_wrapper_open = '<div class="pagination pagination-mini pagination-right">';
	private $main_wrapper_close = '</div>';
	private $items_wrapper_open = '<ul>';
	private $items_wrapper_close = '</ul>';
	private $item_wrapper_open = '<li>';
	private $item_wrapper_close = '</li>';

	private $CI;

	public function __construct($data = array())
	{
		if(is_array($data) && sizeof($data) > 0) {
			foreach($data as $param_name => $param_value) {
				if(property_exists($this, $param_name)) {
					$this->$param_name = $param_value;
				}
			}
		}

		$this->CI =& get_instance();
		parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $this->query_string);
		$__page = $this->CI->input->get($this->query_string_page_identifier);
		$this->current_page = (int)($__page && is_numeric($__page) ? $__page : 1);
	}

	public function generate()
	{
		if($this->total_rows > $this->per_page) {

			$items = array();

			$total_pages = ceil($this->total_rows / $this->per_page);

			if (($total_pages > 7) && ($this->current_page > 4)) {
				$items[] = $this->item_wrapper_open . '<span>...</span>' . $this->item_wrapper_close;
			}
			if ($total_pages > 7) {
				$min = min($this->current_page - min(3, $this->current_page - 1), $total_pages - 6);
				$max = min($min + 6, $total_pages);
			}
			else {
				$min = 1;
				$max = $total_pages;
			}
			for ($i = $min; $i <= $max; $i++) {
				if ($this->current_page == $i) {
					$items[] = $this->item_wrapper_open . '<span>'. $i .'</span>' . $this->item_wrapper_close;
				}
				else {
					$this->query_string['__page'] = $i;
					$items[] = $this->item_wrapper_open . anchor(uri_string() .'?'. http_build_query($this->query_string), $i) .$this->item_wrapper_close;
				}
			}
			if (($total_pages > 7) && (($current + 3) < $total_pages)) {
				$items[] = '<li class="ellipsis"><span>...</span></li>';
			}
			return $this->main_wrapper_open . $this->items_wrapper_open . implode('', $items) . $this->items_wrapper_close . $this->main_wrapper_close;
		}

		return '';
	}
}