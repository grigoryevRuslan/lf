<?php 
	
	if (!session_start()) die('Sessions does not work');
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
	
	$data = json_decode(file_get_contents('php://input'), true);

	if (sizeof($data) != 0) {

		if (isset($_SESSION['user_id'])) { $user_id = $_SESSION['user_id'];}
		if (isset($data['requestId'])) { $req_id = $data['requestId'];}
		if (isset($data['action'])) { $status = ($data['action'] == true) ? 1 : 2;}

		$query = "
			UPDATE
				request
			SET
				status = '$status'
			WHERE
				id = '$req_id'
		";

		$pmAmount = $pdoConnection->prepare($query);
		$pmAmount->execute();
		$result = $pmAmount->fetch(PDO::FETCH_NUM);

		if(!$result) {
			die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
		}

		echo json_encode($result);
	
	} else {
	
		echo json_encode('Произошла ошибка, повторите пожалуйста отправку', JSON_UNESCAPED_UNICODE);
	
	}

?>