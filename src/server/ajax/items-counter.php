<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
	
	$data = json_decode(file_get_contents('php://input'), true);

	if (sizeof($data) != 0) {

		$lostAmount = $pdoConnection->prepare("SELECT COUNT(*) FROM items WHERE items.type = 'lost' AND is_published = 1");
		$lostAmount->execute();
		$result['lost'] = $lostAmount->fetch(PDO::FETCH_NUM);

		$foundAmount = $pdoConnection->prepare("SELECT COUNT(*) FROM items WHERE items.type = 'found' AND is_published = 1");
		$foundAmount->execute();
		$result['found'] = $foundAmount->fetch(PDO::FETCH_NUM);

		if(!$result) {
			die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
		}

		echo json_encode($result);
	
	} else {
	
		echo json_encode('Произошла ошибка, повторите пожалуйста отправку', JSON_UNESCAPED_UNICODE);
	
	}

?>