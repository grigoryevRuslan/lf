<?php 
	
	include_once '../../globals/common.php';
	include_once '../../functions/functions.php';
	include_once '../../globals/db/db.php';
	
	$data = json_decode(file_get_contents('php://input'), true);

	if (sizeof($data) != 0) {
		$id = $data['id'];
		$isPublished = $data['isPublished'];

		$query = $pdoConnection->prepare("UPDATE items SET is_published = '$isPublished' WHERE id = '$id'");

		$result = $query->execute();

		if(!$result) {
			die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
		}

		if ($isPublished == 1) {
			echo json_encode('Опубликовано', JSON_UNESCAPED_UNICODE);
		} else {
			echo json_encode('Распубликовано', JSON_UNESCAPED_UNICODE);
		}
	
	} else {
	
		echo json_encode('Произошла ошибка, повторите пожалуйста', JSON_UNESCAPED_UNICODE);
	
	}

?>