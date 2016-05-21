<?php 
		
	if (!session_start()) die('Sessions does not work');
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
	
	$data = json_decode(file_get_contents('php://input'), true);

	if (sizeof($data) != 0) {

		if (isset($data['advertId'])) { $advert_id = $data['advertId'];}
		if (isset($data['advertType'])) { $advert_type = $data['advertType'];}
		if (isset($data['request'])) { $request = $data['request'];}
		if (isset($_SESSION['user_id'])) { $user_id = $_SESSION['user_id'];}

		$query = $pdoConnection->prepare("INSERT INTO request (advert_id, user_id, advert_type, request, status) VALUES ('$advert_id', '$user_id', '$advert_type', '$request', 0)");

		$result = $query->execute();

		if(!$result) {
			die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
		}

		echo json_encode('Заявка отправлена автору объявления.', JSON_UNESCAPED_UNICODE);

	} else {
	
		echo json_encode('Произошла ошибка, повторите пожалуйста отправку', JSON_UNESCAPED_UNICODE);
	
	}

?>