<?php 
	
	try {

	    $pdoConnection = new PDO("mysql:host=127.0.0.1;port=3320;dbname=find", 'root');
	    
	    $pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	} catch (\pdoexception $e) {
	 
	    echo "database error: " . $e->getmessage();
	  
	    die($e->getmessage());
	
	}
	
	$pdoConnection->query('set names utf8');

?> 