#### Need to improve documentation on following points

• Routing e.g. Map::get(‘/:nikhil/welcome’, ‘pages#welcome’)  
• Before filter to be run before running controller#action   
• Render redirect   
• Flash  

All controllers extend application_controller , which in turn extends controller which in turn extends Object class  

    PagesController extends ApplicationController { 
    	public function welcome(){ 
        	$this->first_name = "nikhil"; 
            $this->last_name = "yeole"; 
            Flash::add("success", "This flash message is set as success in WelcomeController"); 
            Flash::failure("This flash message is set as failure in WelcomeController");
            Controller::render(array('action' => "help")); Controller::redirect_to("help"); 
        } 
    } 

Above, first_name and last_name variable will be available to welcome view only.   
Flash messages can be added that way. Render can have options as:  

	Controller::render(array(‘controller’ => ‘user, ‘action’=>’show’, ‘format’=>’html’)) 

Here if controller and format is not given then current controller and html format will be considered as default. If render is not called then by default corresponding view of the action will be seeked.   
If not view needs to be rendered then:

	Controller::render(array(‘nothing’=>’true’))

needs to be given. 

	Controller::redirect_to(“help”), 

will redirect to http:example.com/help

All the query parameters or route identifiers e.g. 

	Map::get(‘/:nikhil/welcome’, ‘pages#welcome’ ) ... rest other code
 
so here :nikhil and form variables will be available to controllers and views via Controller::$params associative array.  

In views flash variable can be accessed as:
	
    if(!empty(FLASH::$messages)){ 
    	foreach (FLASH::$messages as $key => $value) { 
    		echo "$value";
		} 
    	FLASH::$messages = array();
	 }else if(isset($_SESSION['flash_messages'])){ 
    	 foreach ($_SESSION['flash_messages'] as $key => $value) { 
       	 	echo "$value";
       	 }
    
	 	 $_SESSION['flash_messages'] = array(); 
     }
