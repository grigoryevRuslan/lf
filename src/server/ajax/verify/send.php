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

		$checkLimitQuery = $pdoConnection->prepare("
			SELECT 
				counter 
			FROM 
				request_limit
			WHERE
				user_id = '$user_id'
			AND
				advert_id = '$advert_id'
		");
		
		$checkLimitQuery->execute();
		$counter = $checkLimitQuery->fetch(PDO::FETCH_NUM);
		$response['limitCounter'] = intval($counter['0']);

		if ($response['limitCounter'] < 5) {
			$query = $pdoConnection->prepare("INSERT INTO request (advert_id, user_id, advert_type, request, status) VALUES ('$advert_id', '$user_id', '$advert_type', '$request', 0)");

			$result = $query->execute();

			if (!$counter) {
				$actionLimitQuery = $pdoConnection->prepare("
					INSERT INTO 
							request_limit
						(user_id, counter, advert_id)
					VALUES
						('$user_id', 1, '$advert_id')
				");
			} else {
				$actionLimitQuery = $pdoConnection->prepare("
					UPDATE
						request_limit
					SET
						counter = counter + 1
					WHERE
						user_id = '$user_id'
					AND
						advert_id = '$advert_id'
				");
			}

			$resAction = $actionLimitQuery->execute();

			$response['text'] = "Заявка отправлена автору объявления.";
			
			if(!$result) {
				die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
			}

		} else {

			$response['text'] = "Вы превысили лимит на сегодня. Попробуйте завтра.";

		}
		
		echo json_encode($response, JSON_UNESCAPED_UNICODE);

	} else {
	
		echo json_encode('Произошла ошибка, повторите пожалуйста отправку', JSON_UNESCAPED_UNICODE);
	
	}

?>