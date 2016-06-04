<?php 

	function renderHead ($title, $image, $url, $description) {
		echo '<!DOCTYPE html>
			<html lang="en" ng-app="luckfind">
			<head>
				<meta charset="UTF-8">
				<title>' . $title . ' | Бюро находок Luckfind | Украина</title>
				<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />'.
				renderMetaTags().
				renderMetaFacebook($title, $image, $url, $description).
				'<link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAA////AN0A/wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAERERERAAAAAREREREAAAABEREREQAAAAEAAAABAAAAAQEQEQEAAAABESIhEQAAAAEREhERAAAAARAREBEAAAAREBEQERAAAREREREREQARABERERABEBEREREREREQAREQAAAREQAAAAAAAAAAD//wAA//8AAPAHAADwBwAA8AcAAPAHAADwBwAA8AcAAPAHAADwBwAA4AMAAMABAACAAAAAgAAAAMPhAAD//wAA" rel="icon" type="image/x-icon" />
				<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,500,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">
				<link rel="stylesheet" type="text/css" href="http://'.$GLOBALS['domain'].'/css/main.css">
			</head>
			<body class='.$GLOBALS['useragent_type'].'>';
	}

	// Render popup
	// map, auth 
	function renderPopup($type) {
		echo '
			<div class="popup popup_'. $type .'">
				
				<div class="popup__container">';
		
		include_once $_SERVER['DOCUMENT_ROOT'].'/templates/popups/'.$type.'/'.$type.'.php';

		if ($type == 'map') {
			echo '<input type="text" class="form-control" placeholder="Найти на карте..." id="searchPlace" />';
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

	function sendMail($mailTo, $subject, $message) {
		mail(
		$mailTo,
		$subject, 
		$message,
		"From: no-reply@luckfind.me");
	}

	function renderMetaTags () {
		echo '
			<meta name="description" content="Бюро бесплатных объявлений о потерях и находках документов, личных вещей, животных и автомобилей. Всеукраинское Онлайн-бюро находок." />
			<meta name="keywords" content="Найти паспорт, бюро находок Киев, бюро находок Львов, найти документы" />
		';
	}

?>