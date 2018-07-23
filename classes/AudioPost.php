<?php

class AudioPost extends TumblrPost {
	private $_externalUrl;
	private $_embedCode;
	private $_artist;
	private $_album;
	private $_trackName;
	private $_albumArtUrl;


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


	public function get_artist() {
		return $this->_artist;
	}

	public function set_artist($value) {
		$this->_artist = $value;
	}


	public function get_album() {
		return $this->_album;
	}

	public function set_album($value) {
		$this->_album = $value;
	}


	public function get_trackName() {
		return $this->_trackName;
	}

	public function set_trackName($value) {
		$this->_trackName = $value;
	}


	public function get_albumArtUrl() {
		return $this->_albumArtUrl;
	}

	public function set_albumArtUrl($value) {
		$this->_albumArtUrl = $value;
	}
}

?>