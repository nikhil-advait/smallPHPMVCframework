<?php
//contains methods for all user defined controllers

class Controller extends Object{

	public static $controller = null;
	public static $action = null;
	public static $format = null;
	public static $nothing = false;
	public static $params= null;

	public static function render($arr){
		self::$controller = isset($arr['controller']) ? $arr['controller'] :  null;
		self::$action = isset($arr['action']) ? $arr['action'] :  null;
		self::$format = isset($arr['format']) ? $arr['format'] :  null;
		self::$nothing = isset($arr['nothing']) ? $arr['nothing'] :  false;
	}

	public static function redirect_to($uri){
		echo "<META HTTP-EQUIV='Refresh' Content='0; URL=$uri'>"; 
		die();
	}
}