<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';

	$data = json_decode(file_get_contents('php://input'), true);

	if (sizeof($data) != 0) {
		if (isset($data['id'])) {$id = $data['id'];}
		$answer = $data['answer'];
		$question = $data['question'];

		if (!$id) {
			$query = $pdoConnection->prepare("INSERT INTO faq (answer, question) VALUES ('$answer', '$question')");
		} else {
			$query = $pdoConnection->prepare("UPDATE faq SET answer = '$answer', question = '$question' WHERE id = '$id'");
		}

		$result = $query->execute();

		if(!$result) {
			die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
		}

		if (!$id) {
			echo json_encode('Добавлено', JSON_UNESCAPED_UNICODE);
		} else {
			echo json_encode('Отредактировано', JSON_UNESCAPED_UNICODE);
		}
	
	} else {
	
		echo json_encode('Произошла ошибка, повторите пожалуйста', JSON_UNESCAPED_UNICODE);
	
	}

?>