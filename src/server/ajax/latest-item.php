<?php 
	
	include_once '../globals/common.php';
	include_once '../functions/functions.php';
	include_once '../globals/db/db.php';
	
	$data = json_decode(file_get_contents('php://input'), true);

	if (sizeof($data) != 0) {

		$latestItem = $pdoConnection->prepare("SELECT * FROM items WHERE date_publish IN (SELECT MAX(date_publish) FROM items WHERE is_published = 1)");
		$latestItem->execute();
		$result = $latestItem->fetchAll();

		if(!$result) {
			die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
		}

		echo json_encode($result);
	
	} else {
	
		echo json_encode('Произошла ошибка, повторите пожалуйста отправку', JSON_UNESCAPED_UNICODE);
	
	}

?>