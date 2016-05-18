<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
	
	$data = json_decode(file_get_contents('php://input'), true);

	if (sizeof($data) != 0) {

		$sCodes = $pdoConnection->prepare("SELECT * FROM secret");
		$sCodes->execute();
		$result = $sCodes->fetchAll(PDO::FETCH_ASSOC);

		if(!$result) {
			die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
		}

		echo json_encode($result);
	
	} else {
	
		echo json_encode('Произошла ошибка, повторите пожалуйста отправку', JSON_UNESCAPED_UNICODE);
	
	}

?>