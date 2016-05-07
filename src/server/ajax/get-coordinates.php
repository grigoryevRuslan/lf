<?php 
	if (isset($_POST['action'])) {

		include_once '../globals/common.php';
		include_once '../globals/db/db.php';

		$getCoordinatesQuery = "SELECT id, coordinates, item, user_item, type, date_publish, reward FROM items WHERE coordinates IS NOT NULL";
		
		$q = $pdoConnection->prepare($getCoordinatesQuery);
		$q->execute();
		$result = $q->fetchAll();
		
		echo json_encode($result);
	}
?>