<?php

    include_once '../globals/common.php';
    include_once '../globals/db/db.php';

	$arr = array();
	$q = trim($_GET['term']);

	$autocompleteQuery = "SELECT item, user_item FROM items WHERE item LIKE '%$q%' OR user_item LIKE '%$q%';";
	$autocompleteResult = $pdoConnection->prepare($autocompleteQuery);
	$autocompleteResult->execute();
	$result = $autocompleteResult->fetchAll();

	if (sizeof($result) != 0) {
	    $arr = array_unique($result, SORT_REGULAR);
	    echo json_encode($arr);
	} else {
		echo "Search does not work";
	}

	
exit();
