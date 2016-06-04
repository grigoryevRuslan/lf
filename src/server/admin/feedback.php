<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';

	$query = $pdoConnection->prepare("SELECT * FROM feedback ORDER BY id DESC");
	$query->execute();
	$result = $query->fetchAll();

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
			
			<h1 class="text-center">Список обращений.</h1>

			<?php if (!empty($result)) { ?>
				
				<div class="container">

					<div class="row">

						<div class="col-md-12 feedbacks">

							<?php foreach ($result as $r) { ?>
								
								<div class="row">

									<p>
										Обращение # 
										<strong><?php echo $r['id']; ?></strong>

										<strong>&nbsp;&nbsp;|&nbsp;&nbsp;</strong>

										<strong>Имя: </strong>
										<span>
											<?php echo $r['name'] ?>
										</span>

										<strong>&nbsp;&nbsp;|&nbsp;&nbsp;</strong>

										<strong>Электропочта: </strong>
										<span>
											<?php echo '<a href="mailto:'.$r['mail'].'"'.'>'.
											$r['mail'].'</a>'; ?>
										</span>
									</p>

									<div>	
										<strong>Обращение: </strong>
										<p>
											<?php echo $r['description']; ?>
										</p>
									</div>

								</div>

							<?php } ?>
							
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