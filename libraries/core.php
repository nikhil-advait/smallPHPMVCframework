<?php
include 'object.php';
include 'flash.php';
include 'controller.php';
include 'model.php';
include 'sammy.php';
include 'router.php';
include BASE_PATH . '/config/routes.php';

$sammy->run();