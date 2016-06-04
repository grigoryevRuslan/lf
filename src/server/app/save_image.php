<?php
	if (isset($_FILES["fileToUpload"])) {
		if ($_FILES["fileToUpload"]["size"] != 0) {
			$allowedExts = array("jpeg", "jpg", "png");
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
			$newfilename = 'wm-luckfind-'.$newfilename;
			move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "upload/" . $newfilename);
				
			$watermarkPath = 'http://'.$GLOBALS['domain'].'/img/watermark.png';
			$stamp = imagecreatefrompng($watermarkPath);

			if ($extension == "jpeg" || $extension == "jpg") {
				$im = imagecreatefromjpeg("upload/" . $newfilename);
			} else {
				$im = imagecreatefrompng("upload/" . $newfilename);
			}

			$marge_right = 10;
			$marge_bottom = 10;
			$sx = imagesx($stamp);
			$sy = imagesy($stamp);

			imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

			imagepng($im, "upload/" . $newfilename);
			imagedestroy($im);
		}
  	}
?>
