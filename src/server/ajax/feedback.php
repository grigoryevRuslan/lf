<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
	
	$data = json_decode(file_get_contents('php://input'), true);

	if (sizeof($data) != 0) {
		$name = $data['name'];
		$mail = $data['mail'];
		$text = $data['text'];

		$query = $pdoConnection->prepare("INSERT INTO feedback (name, mail, description) VALUES ('$name', '$mail', '$text')");

		$result = $query->execute();

		if(!$result) {
			die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
		}

		mail(
			"rus.grigoryev@gmail.com",
		 	$name, 
		 	$text,
		 	"From: no-reply@luckfind.me");

		echo json_encode('Спасибо, '.$name.'!Ваше обращение будет рассмотрено в ближайшее время.', JSON_UNESCAPED_UNICODE);
	
	} else {
	
		echo json_encode('Произошла ошибка, повторите пожалуйста отправку', JSON_UNESCAPED_UNICODE);
	
	}

?>