<?php 
	if (isset($_POST['action'])) {

		include_once '../globals/common.php';
		include_once '../globals/db/db.php';

		if ($_POST['action'] == 'all') {
			$getCoordinatesQuery = "SELECT id, coordinates, item, user_item, type, date_publish, reward FROM items WHERE coordinates IS NOT NULL AND is_published = 1";
		} else {
			if (isset($_POST['id'])) {
				$id = $_POST['id'];
				$getCoordinatesQuery = "SELECT coordinates FROM items WHERE id = '$id' AND coordinates IS NOT NULL AND is_published = 1";
			}
		}
		
		$q = $pdoConnection->prepare($getCoordinatesQuery);
		$q->execute();
		$result = $q->fetchAll();
		
		echo json_encode($result);
	}
?>