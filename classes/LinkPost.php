<?php

class LinkPost extends TumblrPost {
	private $_linkName;
	private $_externalUrl;


	public function get_linkName() {
		return $this->_linkName;
	}

	public function set_linkName($value) {
		$this->_linkName = $value;
	}


	public function get_externalUrl() {
		return $this->_externalUrl;
	}

	public function set_externalUrl($value) {
		$this->_externalUrl = $value;
	}
}

?>