<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/credentials.php';

	try {

	    $pdoConnection = new PDO($pdoConnectionString, $pdoConnectionUsername, $pdoConnectionPassword);
	    
	    $pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	} catch (\pdoexception $e) {
	 
	    echo "database error: " . $e->getmessage();
	  
	    die($e->getmessage());
	
	}

	$pdoConnection->query('set names utf8');

?> 