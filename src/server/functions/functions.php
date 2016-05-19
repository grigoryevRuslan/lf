<?php 

	function renderHead ($title, $image, $url, $description) {
		echo '<!DOCTYPE html>
			<html lang="en" ng-app="luckfind">
			<head>
				<meta charset="UTF-8">
				<title>' . $title . '</title>
				<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />'.

				renderMetaFacebook($title, $image, $url, $description).
				
				'<link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAA////AN0A/wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAERERERAAAAAREREREAAAABEREREQAAAAEAAAABAAAAAQEQEQEAAAABESIhEQAAAAEREhERAAAAARAREBEAAAAREBEQERAAAREREREREQARABERERABEBEREREREREQAREQAAAREQAAAAAAAAAAD//wAA//8AAPAHAADwBwAA8AcAAPAHAADwBwAA8AcAAPAHAADwBwAA4AMAAMABAACAAAAAgAAAAMPhAAD//wAA" rel="icon" type="image/x-icon" />
				<link rel="stylesheet" type="text/css" href="http://'.$GLOBALS['domain'].'/css/style.css">
			</head>
			<body>';
	}

	// Render popup
	// map, auth 
	function renderPopup($type) {
		echo '
			<div class="popup popup_'. $type .'">
				
				<div class="popup__container">';
		
		if ( $type != 'feedback' ) {
			include_once $_SERVER['DOCUMENT_ROOT'].'/templates/auth/auth.php';
		} else {
			include_once $_SERVER['DOCUMENT_ROOT'].'/templates/feedback/feedback.php';
		}			

		echo '<span class="popup__close">&times;</span>

				</div>

			</div>
		';
	}

	function renderMetaFacebook($title, $image, $url, $description) {
		echo '
			<meta property="og:url" content="'.$url.'" />
			<meta property="og:type" content="image/jpeg" />
			<meta property="og:title" content="'.$title.'" />
			<meta property="og:image" content="http://'.$image.'" />
			<meta property="og:description" content="'.$description.'" />
		';
	}

?>