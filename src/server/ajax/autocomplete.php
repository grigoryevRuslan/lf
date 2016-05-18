<?php

    include_once '../globals/common.php';
    include_once '../globals/db/db.php';

	$arr = array();
	$q = trim($_GET['term']);

	$autocompleteQuery = "SELECT item, user_item FROM items WHERE is_published = 1 AND (item LIKE '%$q%' OR user_item LIKE '%$q%');";
	$autocompleteResult = $pdoConnection->prepare($autocompleteQuery);
	$autocompleteResult->execute();
	$result = $autocompleteResult->fetchAll(PDO::FETCH_ASSOC);

	if (sizeof($result) != 0) {
		foreach($result as &$val) {
			$val['item'] = mb_strtolower($val['item'], "UTF-8");
			$val['user_item'] = mb_strtolower($val['user_item'], "UTF-8");

			if ($val['item'] == null || $val['item'] == '') {
				$val['item'] = mb_strtolower($val['user_item'], "UTF-8");
			}

			if ($val['user_item'] == null || $val['user_item'] == '') {
				$val['user_item'] = mb_strtolower($val['item'], "UTF-8");
			}
		}
		$arr = array_unique($result, SORT_REGULAR);
		echo json_encode($arr);
	} else {
		echo "Search does not work";
	}

	
exit();
