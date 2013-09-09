<?php
/**
 * Sammy - A bare-bones PHP version of the Ruby Sinatra framework.
 *
 * @version		1.0
 * @author		Dan Horrigan
 * @license		MIT License
 * @copyright	2010 Dan Horrigan
 */

class Sammy {

	public static $route_found = false;
	public static $requested_method_type = '';
	public static $requested_route = '';

	public $uri = '';

	public $segments = '';

	public $method = '';

	public $format = '';

	public static function instance() {
		static $instance = null;

		if( $instance === null ) {
			$instance = new Sammy;
		}

		return $instance;
	}

	public static function run() {
		if( !static::$route_found ) {
			echo $_SERVER['REQUEST_URI'] . ' URI of type: ' .  $_SERVER['REQUEST_METHOD'] .' not found!';
		}

		ob_end_flush();
	}

	public static function process($route, $type) {
		$sammy = static::instance();

    	// Check for ajax
		if( $type == 'XMLHttpRequest' )
		  $sammy->method = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : 'GET';

		//in progress
		$route_and_route_symbols = self::get_route_symbols($route);
		$route = $route_and_route_symbols['route'];

		if( static::$route_found || (!preg_match('@^'.$route.'(?:\.(\w+))?$@uD', $sammy->uri, $matches) || $sammy->method != $type) ) {
			return false;
		}
    	
    	
	    // Get the extension
	    $extension = $matches[count($matches)-1];
	    $extension_test = substr($sammy->uri, -(strlen($extension)+1), (strlen($extension)+1));
	    
	    if( $extension_test == '.' . $extension )
	      $sammy->format = $extension;
	  	else
	  	$sammy->format = "html";

    	$params = array();
    	$params = self::get_params($route_and_route_symbols['route_symbols'], $sammy->format);
    	Controller::$params = $params;
		static::$route_found = true;
		Map::dispatch($sammy->format);
	}

	public function __construct() {
		ob_start();
		$this->uri = self::get_uri();
		$this->segments = explode('/', trim($this->uri, '/'));
		$this->method = $this->get_method();
	}

	protected static function get_params($route_symbols, $format){
		$params = array();
		foreach($route_symbols as $position => $params_var){
    		$params[$params_var] = self::segment($position, $format);
    	}

    	if(isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])){
    		parse_str($_SERVER['QUERY_STRING'], $query_params);
    		$params = array_merge($params, $query_params);
    	}


		$body = file_get_contents("php://input"); //remmber php://input can only be read once...after that it will become blank This is atleast true for PUT request ..for post it can be accessed multiple times ..maybe ..need to confirm once

    	if($body){
    		$content_type = false;
    		if(isset($_SERVER['CONTENT_TYPE'])){
    			$content_type = $_SERVER['CONTENT_TYPE'];
    		}
    		switch($content_type){
    			case "application/json":
    				$body_vars = json_decode($body);
    				if($body_vars){
    					foreach($body_vars as $param => $value){
    						$body_params[$param] =  $value;
    					}
    					$params = array_merge($params, $body_params);
    				}
    				break;
    			case "application/x-www-form-urlencoded" || "application/x-www-form-urlencoded; charset=UTF-8":
    				parse_str($body, $postVars);
    				if($postVars){
	    				foreach ($postVars as $param_name => $param_value) {
	    					$body_params[$param_name] = $param_value;
	    				}
    					$params = array_merge($params, $body_params);
    				}	
    				break;
    			default:
    				break;
    		}
    	}

    	return $params;

	}

	public static function get_route_symbols($route){
		$segments = explode('/', trim($route, '/'));
		$r_segments = array();	
		$route_and_route_symbols = array();
		$route_symbols = array();
		for($i=0; $i < sizeof($segments); $i++){
			$seg = $segments[$i];
			if(!empty($seg)){
				if($seg[0] == ':'){
					$route_symbols[$i+1] = str_replace(':', '', $seg);
				$r_seg = '(.*?)';
				}else {
					$r_seg = $seg;
				}	
				array_push($r_segments, $r_seg);	
			}
		}
		$route =  '/' . implode('/', $r_segments);
		$route_and_route_symbols['route'] = $route;
		$route_and_route_symbols['route_symbols'] = $route_symbols;
		return $route_and_route_symbols;
	}

	protected static function segment($num, $format) {
	  $num--;
	  $segments = explode('/', trim(self::get_uri(), '/'));
	 
    // Remove the extension
    $segments[$num] = isset($segments[$num]) ? preg_replace("/.$format/", '', $segments[$num]) : null;

		return isset($segments[$num]) ? $segments[$num] : null;
	}

	protected static function get_method() {
		if(isset($_SERVER['REQUEST_METHOD'])){
			if($_SERVER['REQUEST_METHOD'] === 'POST'){
				if(isset($_POST['_method'])){
					$method = strtoupper($_POST['_method']);
					if(in_array($method, array('PUT', 'DELETE'))){
						return $method;
					}
				}else{
					return 'POST';
				}
			}else{
				return $_SERVER['REQUEST_METHOD'];
			}
		}else{
			return 'GET';
		}
	}

	protected static function get_uri($prefix_slash = true) {
	    if( isset($_SERVER['PATH_INFO']) ) {
	        $uri = $_SERVER['PATH_INFO'];
	    }elseif( isset($_SERVER['REQUEST_URI']) ) {
	        $uri = $_SERVER['REQUEST_URI'];

	        if( strpos($uri, $_SERVER['SCRIPT_NAME']) === 0 ) {
	            $uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
	        }elseif( strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0 ) {
	            $uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
	        }

	        // This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
	        // URI is found, and also fixes the QUERY_STRING server var and $_GET array.
	        if( strncmp($uri, '?/', 2) === 0 ) {
	            $uri = substr($uri, 2);
	        }

	        $parts = preg_split('#\?#i', $uri, 2);
	        $uri = $parts[0];

	        if( isset($parts[1]) ) {
	            $_SERVER['QUERY_STRING'] = $parts[1];
	            parse_str($_SERVER['QUERY_STRING'], $_GET);
	        }else {
	            $_SERVER['QUERY_STRING'] = '';
	            $_GET = array();
	        }
	        $uri = parse_url($uri, PHP_URL_PATH);
	    }else {
	        // Couldn't determine the URI, so just return false
	        return false;
	    }

	    // Do some final cleaning of the URI and return it
	    return ($prefix_slash ? '/' : '').str_replace(array('//', '../'), '/', trim($uri, '/'));
	}

	public function format($name, $callback) {
	  $sammy = static::instance();
	  if( !empty($sammy->format) && $name == $sammy->format )
	    echo $callback($sammy);
	  else
	    return false;
	}
}

$sammy = Sammy::instance();