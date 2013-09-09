<?php
class Map extends Controller {

	public static $path = null;

	public static function get($route, $path) {
		self::$path = $path;
		Sammy::process($route, 'GET');
	}

	public static function post($route, $path) {
		self::$path = $path;
		Sammy::process($route, 'POST');
	}

	public static function put($route, $path) {
		self::$path = $path;
		Sammy::process($route, 'PUT');
	}

	public static function delete($route, $path) {
		self::$path = $path;
		Sammy::process($route, 'DELETE');
	}

	public static function ajax($route, $path) {
		self::$path = $path;
		Sammy::process($route, 'XMLHttpRequest');
	}

	public static function dispatch($format){
		//runs when find a matching route
		//find the controller
		//include matching route controller
		//find the action
		//include app_controller
		//run matching action
		//include the view file

		$controller_and_action = explode('#', self::$path);	
		$controller = $controller_and_action[0];
		$action =$controller_and_action[1];
		$class_name = ucfirst($controller) . 'Controller';
		
		//add controller and actio to params
		Controller::$params['controller'] = $controller;
		Controller::$params['action'] = $action;

		//load all models
		self::load_models();

		//load controllers
		self::load_controller('application');
		self::load_controller($controller);
		// run before filter
			//to do
		//load controller classes
		if(class_exists($class_name)){
			$tmp_instance = new $class_name();
			if(is_callable(array($class_name, $action))){
				$tmp_instance->$action();
			}else {
				die($action . ' action not found in ' . $class_name . ' class!');
			}
		} else {
			die($class_name . ' class does not exist!');
		}

		// load view
		if(Controller::$nothing){

		}else if(!empty(Controller::$controller) || !empty(Controller::$action) || !empty(Controller::$format)){
			$controller = Controller::$controller ? : $controller;
			$action = Controller::$action ? : $action;
			$format = Controller::$format ? : $format;
			self::load_view($controller, $action, $format);	
		}	
		else
			self::load_view($controller, $action, $format);
	}

	public static function load_controller($name){
		$controller_path = APP_PATH . '/controllers/' . $name . '_controller.php';;
		if(file_exists($controller_path)){
			include_once $controller_path;
		}else {
			die($name . '_controller.php could not be found!');
		}
	}

	public static function load_models(){
		$model_path = APP_PATH . '/models/';
		foreach (glob($model_path . "*.php") as $filename){
		    include $filename;
		}
	}

	public static function load_view($controller, $action, $format){
		$view_path = APP_PATH . '/views/' . $controller . '/' . $action . '.' . $format. '.php';
		unset($controller, $action, $format);
		foreach(self::$controller_vars as $index => $val){
			$$index = $val;
		}
		if(file_exists($view_path)){
			include_once $view_path;
		}
		else {
			die($view_path . ' could not be found!');
		}
	}

}