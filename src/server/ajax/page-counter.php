<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
	
	$data = json_decode(file_get_contents('php://input'), true);

	if (sizeof($data) != 0) {

		$id = $data['id'];	
		$increaseViewQuery = "UPDATE items SET views = views + 1 WHERE id = '$id'";
		$getViewQuery = "SELECT views FROM items WHERE id = '$id'";
		
		$q = $pdoConnection->prepare($increaseViewQuery);
		$is_success = $q->execute();

		if ($is_success) {
			$q_get = $pdoConnection->prepare($getViewQuery);
			$q_get->execute();
			$result = $q_get->fetch();
			echo json_encode($result['views'], JSON_NUMERIC_CHECK);
		}

	}
?>