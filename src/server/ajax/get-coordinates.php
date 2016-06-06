<?php 

	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';

	$data = json_decode(file_get_contents('php://input'), true);

	if (isset($_POST['action']) || sizeof($data) != 0) {

		if ($data['action'] == 'all') {
			$getCoordinatesQuery = "SELECT id, coordinates, image_uri, item, user_item, type, date_publish, reward FROM items WHERE coordinates IS NOT NULL AND is_published = 1 AND coordinates != ''";
		} else {
			if (isset($_POST['id'])) {
				$id = $_POST['id'];
				$getCoordinatesQuery = "SELECT coordinates FROM items WHERE id = '$id' AND coordinates IS NOT NULL AND is_published = 1 AND coordinates != ''";
			}
		}
		
		$q = $pdoConnection->prepare($getCoordinatesQuery);
		$q->execute();
		$result = $q->fetchAll(PDO::FETCH_ASSOC);
		
		echo json_encode($result);
	}
?>