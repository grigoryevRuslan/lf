<?php 
	if (isset($_POST['id'])) {
		$id = $_POST['id'];

		$increase_view_query = "UPDATE items SET views = views + 1 WHERE id = '$id'";
		$get_view_query = "SELECT views FROM items WHERE id = '$id'";
		
		try {
		    $connection = new PDO("mysql:host=localhost;dbname=find", 'root', 'Z9pDFXaGvV');
		    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (\pdoexception $e) {
		    echo "database error: " . $e->getmessage();
		    die();
		}
		
		$connection->query('set names utf8');
		$is_success = $connection->exec($increase_view_query);

		if ($is_success == 1) {
			$q = $connection->query($get_view_query);
			$result = $q->fetch();
			echo json_encode($result['views'], JSON_NUMERIC_CHECK);
		}

	}
?>