<?php
	include_once("../config/sphinx/config.php");
	include_once("../app/functions.php");

	if ($_GET['city'] && $_GET['street'] && $_GET['coordinates']) {
		$_SESSION['city'] = $_GET['city'];
		$_SESSION['street'] = $_GET['street'];
		$_SESSION['coordinates'] = $_GET['coordinates'];
		echo json_encode('success');
	} else {
		echo json_encode('no save');
	}

	
exit();
