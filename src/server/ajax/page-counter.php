<?php 
	if (isset($_POST['id'])) {

		include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
		include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';

		$id = $_POST['id'];

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