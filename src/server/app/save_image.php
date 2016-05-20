<?php

	if (isset($_FILES["fileToUpload"])) {
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["fileToUpload"]["name"]);
		$extension = strtolower(end($temp));

		if (!in_array($extension, $allowedExts)) {
			var_dump("Not allowed file");
			die();
		}

		if ($_FILES["fileToUpload"]["error"] > 0) {
			var_dump($_FILES["fileToUpload"]);
			die();
		} 

		if ($_FILES["fileToUpload"]["size"] > 10000000) {
			var_dump("Exceeded limit of image size");
			die();
		}
			
		$newfilename = round(microtime(true)) . '.' . end($temp);
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "upload/" . $newfilename);

  	}
?>
