<?php
class Flash {
	public static $messages = array();

	public static function add($type, $message){
		if(!session_id()) session_start();
		$_SESSION['flash_messages'][$type] = $message;
	}

	public static function __callStatic($name, $args){
		call_user_func_array(array('Flash', 'add'), array($name,$args[0]));
	}

	public static function run(){
		if(!session_id()) session_start();
		if(isset($_SESSION['flash_messages'])) self::$messages = $_SESSION['flash_messages'];

		$_SESSION['flash_messages'] = array();
	}
}

Flash::run();