<?php
	include_once("../config/sphinx/config.php");
	include_once("../app/functions.php");
	$arr = array();
	$q = trim($_GET['term']);

	//Setup Database Connection
	$db = mysql_connect($CONF['mysql_host'],$CONF['mysql_username'],$CONF['mysql_password']) or die("ERROR: unable to connect to database");
	mysql_select_db($CONF['mysql_database'], $db) or die("ERROR: unable to select database");
	
	//Run the Mysql Query
	$sql = "SELECT item, user_item FROM items WHERE item LIKE '%$q%' OR user_item LIKE '%$q%';";
	$result = mysql_query($sql) or die("ERROR: mysql query failed: ".mysql_error());

	if (mysql_num_rows($result) > 0) {
	    $rows = array();
	    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	        $rows[] = $row;
	    }
	}

	$arr = array_unique($rows, SORT_REGULAR);
	echo json_encode($arr);
exit();
