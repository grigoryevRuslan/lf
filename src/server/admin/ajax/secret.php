<?php 
	
	include_once '../../globals/common.php';
	include_once '../../functions/functions.php';
	include_once '../../globals/db/db.php';
	
	$data = json_decode(file_get_contents('php://input'), true);

	if (sizeof($data) != 0) {
		$name = $data['name'];
		$description = $data['description'];
		$example = $data['example'];

		$query = $pdoConnection->prepare("INSERT INTO secret (name, description, example) VALUES ('$name', '$description', '$example');");

		$result = $query->execute();

		if(!$result) {
			die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
		}

			echo json_encode('Сохранено', JSON_UNESCAPED_UNICODE);
	
	} else {
	
		echo json_encode('Произошла ошибка, повторите пожалуйста', JSON_UNESCAPED_UNICODE);
	
	}

?>