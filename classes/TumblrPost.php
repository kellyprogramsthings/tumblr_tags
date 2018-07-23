<?php

class TumblrPost {
	private $_postId;
	private $_tags = array();
	private $_content;
	private $_date;
	private $_type;


	public function __construct() {
	}

	public static function createWithUrl($postId) {
		//$object = new TumblrPost();
		$className = get_called_class();
		$object = new $className();
		$object->postId = $postId;
		return $object;
	}

	public static function createWithData($postId, $date, $type){
		//$object = new TumblrPost();
		$className = get_called_class();
		$object = new $className();
		$object->postId = $postId;
		$object->date = $date;
		$object->type = $type;
		return $object;
	}


	public function __get($property) {
		$method = "get_" . $property;
		if (method_exists($this, $method)) {
			return $this->$method(); 
		}
		else {
			user_error("TumblrPost error: Undefined property: $method");
		}
	}

	public function __set($property, $value) {
		$method = "set_" . $property;
		if (method_exists($this, $method)) {
			$this->$method($value);
		}
		else {
			user_error("TumblrPost error: Undefined property: $method");
		}
	}


	public function getAttributes() {
		$method_names = preg_grep('/^get_/', get_class_methods($this));

		// this probably should have been an array_map with substr, but... here we are
		$methods = str_replace('get_', '', $method_names);
		return $methods;
	}


	public function getAttributesWithoutArray() {
		$method_names = preg_grep('/^get_/', get_class_methods($this));
		$method_names = array_diff($method_names, ["get_tags", "get_photos"]);

		// this probably should have been an array_map with substr, but... here we are
		$methods = str_replace('get_', '', $method_names);
		return $methods;
	}


	public function get_postId() {
		return $this->_postId;
	}

	public function set_postId($value) {
		$this->_postId = $value;
	}


	public function get_tags() {
		return $this->_tags;
	}

	public function set_tags($value) {
		$this->_tags = $value;
	}


	public function get_content() {
		return $this->_content;
	}

	public function set_content($value) {
		$this->_content = $value;
	}


	public function get_date() {
		return $this->_date;
	}

	public function set_date($value) {
		$this->_date = $value;
	}


	public function get_type() {
		return $this->_type;
	}

	public function set_type($value) {
		$this->_type = $value;
	}
}

?>