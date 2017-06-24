<?php
ob_start();
session_start();
require_once '_core/sql.php';
spl_autoload_register(function($class){
	require_once '_classes/' . $class . '.php';
});
require_once '_functions/sanitize.php';
require_once '_functions/functions.php';
require_once '_core/cookie_session.php';


?>