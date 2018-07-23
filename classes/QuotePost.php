<?php

class QuotePost extends TumblrPost {
	private $_quoteSource;


	public function get_quoteSource() {
		return $this->_quoteSource;
	}

	public function set_quoteSource($value) {
		$this->_quoteSource = $value;
	}
}

?>