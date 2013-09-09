<?php
class PagesController extends ApplicationController {

	public function welcome(){
		$this->first_name = "nikhil";
		$this->last_name = "yeole";
		//Flash::add("success", "This flash message is set as success in WelcomeController");
		//Controller::render(array('action' => "help"));
	}

	public function help(){
		

	}

	public function show(){
		

	}
	public function about(){
		Flash::add("success", "This flash message is set as success in help action");
		//Controller::render(array('action' => 'help'));
		Controller::redirect_to("help");		
	}

	public function trial(){
		echo "Controller::DDparams['welcome']" . Controller::$params['welcome'] . '<br />';
		echo "controller: ". Controller::$params['controller'] . " and action: " . Controller::$params['action'] . '<br />';
	}
}