<!doctype html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="<?php echo APP_DIR;?>/app/assets/stylesheets/application.css" />
</head>
<body>
<?php
	
	if(!empty(FLASH::$messages)){
		foreach (FLASH::$messages as $key => $value) {
			echo "<div class='{$key}'> $value </div>";	
		}
		FLASH::$messages = array();		
	}else if(isset($_SESSION['flash_messages'])){
		foreach ($_SESSION['flash_messages'] as $key => $value) {
			echo "<div class='{$key}'> $value </div>";	
		}	
		$_SESSION['flash_messages'] = array();
	}

?>