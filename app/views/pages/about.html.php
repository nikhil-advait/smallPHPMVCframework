<?php include APP_PATH . "/views/header.php" ;?>

i am in pages#about view <br />	
<?php echo '$_SESSION[\'flash_messages\']'; ?>
<?php var_dump($_SESSION['flash_messages']);?>
<?php echo 'Flash::$messages'; ?>
<?php var_dump(Flash::$messages);?>