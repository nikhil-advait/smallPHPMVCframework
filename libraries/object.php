<?php
class Object {
	public static $controller_vars = array();

	public function __set($name, $value){
		self::$controller_vars[$name] = $value;
	}

	public function __get($name){
		if(isset(self::$controller_vars[$name])){
			return self::$controller_vars[$name];
		}else {
			return null;
		}
	}
}