<?php

class VideoPost extends TumblrPost {
	private $_externalUrl;
	private $_embedCode;
	private $_videoType;
	private $_thumbnailUrl;


	public function get_externalUrl() {
		return $this->_externalUrl;
	}

	public function set_externalUrl($value) {
		$this->_externalUrl = $value;
	}


	public function get_embedCode() {
		return $this->_embedCode;
	}

	public function set_embedCode($value) {
		$this->_embedCode = $value;
	}


	public function get_videoType() {
		return $this->_videoType;
	}

	public function set_videoType($value) {
		$this->_videoType = $value;
	}


	public function get_thumbnailUrl() {
		return $this->_thumbnailUrl;
	}

	public function set_thumbnailUrl($value) {
		$this->_thumbnailUrl = $value;
	}
}

?>