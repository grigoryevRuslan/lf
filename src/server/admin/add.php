<?php
ob_start();

	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';

	if (!empty($_POST)) {

			include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
			include_once $_SERVER['DOCUMENT_ROOT'].'/app/save_image.php';

			if (isset ($_POST['mail_delivery']) && $_POST['mail_delivery'] == 'on') {
				$mail_delivery = 1;
			} else {
				$mail_delivery = 0;
			}

			if (isset($_POST['user_item']) && $_POST['user_item'] != '') {
				$user_item = $_POST['user_item'];
				$item = '';
			} else {
				$item = $_POST['item'];
				$user_item = '';
			}

			$description = $_POST['description'];
			$type = $_POST['type'];
			$phone = $_POST['phone'];
			$mail = $_POST['mail'];
			$meta = $_POST['meta'];

			if (isset($_POST['reward'])) {
				$reward = $_POST['reward'];
			} else {
				$reward = 0;
			}

			if (isset($_POST['coordinates'])) {
				$coordinates = $_POST['coordinates'];
			} else {
				$coordinates = '';
			}

			if (isset($_POST['date'])) {
				$item_date = date_format(date_create_from_format('d-m-Y', $_POST['date']), 'Y-m-d H:i:s');
			} else {
				$item_date = date("Y-m-d H:i:s");
			}

			$mysqltime = date("Y-m-d H:i:s");

			if (isset($newfilename)) {
				$fileUrl = $newfilename;
			} else {
				$fileUrl = 'no-image-available.png';
			}

			if (isset($_POST['secret'])) {
				$secret = $_POST['secret'];
			}

			if (isset($_POST['action'])) {
				if ($_POST['action'] == 'edit' && isset($_POST['edit_id'])) {
					$edit_id = $_POST['edit_id'];
					$query = $pdoConnection->prepare("UPDATE items SET item = '$item', user_item = '$user_item', description = '$description', coordinates = '$coordinates', reward = '$reward', type = '$type', phone = '$phone', mail = '$mail', meta = '$meta', image_uri = '$fileUrl', date_publish = '$mysqltime', item_date = '$item_date', mail_delivery = '$mail_delivery', item_secret = '$secret' WHERE id = '$edit_id'");
				}
			}
			
			$result = $query->execute();

			if(!$result) {
				die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
			} else {
				header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin');
			}
	}
	ob_flush();
?>

</body>
</html>