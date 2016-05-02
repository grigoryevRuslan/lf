<?php 
	if (isset($_POST['action'])) {
		$get_coordinates_query = "SELECT id, coordinates, item, user_item, type, date_publish, reward FROM items WHERE coordinates IS NOT NULL";
		
		try {
		    $connection = new PDO("mysql:host=localhost;dbname=find", 'root', 'Z9pDFXaGvV');
		    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (\pdoexception $e) {
		    echo "database error: " . $e->getmessage();
		    die();
		}
		
		$connection->query('set names utf8');
		$q = $connection->query($get_coordinates_query);

		$result = $q->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	}
?>