<?php

class PhotoPost extends TumblrPost {
	//NOT IMPLEMENTED: captions on photos
	private $_photos = array();
	private $_photoLayout;


	public function get_photos() {
		return $this->_photos;
	}

	public function set_photos($value) {
		$this->_photos = $value;
	}


	public function get_photoLayout() {
		return $this->_photoLayout;
	}

	public function set_photoLayout($value) {
		$this->_photoLayout = $value;
	}
}

?>