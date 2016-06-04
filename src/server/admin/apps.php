<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';


	if (isset($_POST['req_id']) && isset($_POST['publish'])) {
		$id = $_POST['req_id'];
		$publish = $_POST['publish'];

		$queryInsert = $pdoConnection->prepare("
			UPDATE 
				request
			SET
				is_published = '$publish'
			WHERE 
				id = '$id'
		");

		$queryInsert->execute();
	}

	$query = $pdoConnection->prepare("
		SELECT r.id as req_id, i.id as advert_id, i.item_secret, r.request, i.item, i.user_item
		FROM request r
		INNER JOIN items i
		WHERE r.advert_id = i.id
	");
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_ASSOC);

	if(!$result) {
		die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
	}

?>

<!DOCTYPE html>
<html lang="en" ng-app="admin">
<head>
	<meta charset="UTF-8">
	<title>Admin part</title>
	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>

	<?php include_once $_SERVER['DOCUMENT_ROOT'].'/admin/templates/menu.php'; ?>

	<div class="container">
		<div class="row">
			
			<h3 class="text-center">Список заявок от пользователей, которые нужно рассматривать.</h3>

			<?php if (!empty($result)) { ?>
				
				<div class="container">

					<div class="row">

						<div class="col-md-12 feedbacks">

							<table class="table table-striped table-bordered">
								<thead>
									<th>Объявление</th>
									<th>Секретный код</th>
									<th>Запрос на объявление</th>
									<th colspan="2">Действия</th>
								</thead>
								<tbody>
									<?php foreach ($result as $r) { ?>
										<tr>
											<td>
												<a href="/advert.php?id=<?php echo $r['advert_id']; ?>">
													<?php if (isset($r['item']) && $r['item'] != '') {echo $r['item'];} else {echo $r['user_item'];} ?>
												</a>
											</td>
											<td>
												<?php 
													if (isset($r['item_secret'])) {
														echo $r['item_secret'];
													} else {
														echo 'Не был указан';
													}
												?>
											</td>
											<td>
												<?php 
													if (isset($r['request'])) {
														echo $r['request'];
													} else {
														echo 'Не был указан';
													}
												?>
											</td>
											<td>
												<form method="POST" action="apps.php">

													<input type="hidden" name="req_id" value="<?php echo $r['req_id'];?>" />

													<input type="hidden" name="publish" value="1" />

													<button type="submit" class="btn btn-xs btn-success">Разрешить</button>
													
												</form>
											</td>
											<td>
												<form method="POST" action="apps.php">

													<input type="hidden" name="req_id" value="<?php echo $r['req_id'];?>" />

													<input type="hidden" name="publish" value="0" />

													<button type="submit" class="btn btn-xs btn-danger">Отклонить</button>
													
												</form>
											</td>

										</tr>
									<?php } ?>
								</tbody>
							</table>
							
						</div>

					</div>

				</div>

			<?php } ?>
			
		</div>
	</div>

	<script type="text/javascript" src="../js/global/app.min.js"></script>
	<script type="text/javascript" src="js/app/app.js"></script>
	<script type="text/javascript" src="js/app/controllers/allAdvertsController.js"></script>

</body>
</html>