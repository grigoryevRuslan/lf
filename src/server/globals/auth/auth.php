<?php 
	
	$GLOBALS['isAuthorised'] = (!empty($_SESSION['user_id'])) ? true : false;

?>