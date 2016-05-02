<?php 
	
	function renderHead ($title) {
		echo '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<title>' . $title . '</title>
				<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
				<link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAA////AN0A/wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAERERERAAAAAREREREAAAABEREREQAAAAEAAAABAAAAAQEQEQEAAAABESIhEQAAAAEREhERAAAAARAREBEAAAAREBEQERAAAREREREREQARABERERABEBEREREREREQAREQAAAREQAAAAAAAAAAD//wAA//8AAPAHAADwBwAA8AcAAPAHAADwBwAA8AcAAPAHAADwBwAA4AMAAMABAACAAAAAgAAAAMPhAAD//wAA" rel="icon" type="image/x-icon" />
				<link rel="stylesheet" type="text/css" href="css/style.css">
			</head>
			<body>';
	}

	// Render popup
	// map, auth 
	function renderPopup($type) {
		echo '
			<div class="popup popup_'. $type .'">
				
				<div class="popup__container">';
					
		include_once 'templates/auth/auth.php';

		echo '<span class="popup__close">&times;</span>

				</div>

			</div>
		';
	}

?>