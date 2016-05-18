<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';

	$query = $pdoConnection->prepare("SELECT * FROM items ORDER BY date_publish DESC");
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
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="row">
				<ul class="nav navbar-nav">
					<li><a href="http://www.luckfind.me">Домой</a></li>
					<li class="active"><a href="index.php">Админка</a></li>
					<li><a href="feedback.php">Вопросы </a></li>
					<li><a href="secret.php">Секреты</a></li>
				</ul>
				<!-- <div class="user">
					<strong>Пользователь</strong> : <?php echo $_SERVER['PHP_AUTH_USER']; ?>
				</div> -->
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row">
			
			<h1 class="text-center">Все объявления!</h1>

			<?php if (!empty($result)) { ?>
				
				<div class="container results advert">
					<div class="row">
							<p class="text-right"><strong>Всего <?php echo sizeof($result); ?> обьявлений</strong></p>

							<ul class="results" ng-controller="allAdvertsController">
								<?php foreach ($result as $r) { ?>
									<li class="result <?php echo $r['type']; ?>">
										<div class="result__content">
											<?php if (isset($r['date_publish'])) { ?>
												<p class='text-left'>
													<span class="time">Добавлено: <?php echo $r['date_publish'] ?></span>
												</p>
											<?php } ?>
											
											<a href="/advert.php?id=<?php echo $r['id']; ?>" target="_blank">
												<h3>
													<?php
														if ($r['item'] == '') {
															echo $r['user_item'];
														} else {
															echo $r['item'];
														}
													?>
												</h3>
											</a>

											<?php if ($r['item_secret']) { ?>

												<p><strong>Секретный код:</strong><?php echo $r['item_secret']; ?></p>

											<?php } ?>

											<p><?php echo $r['description']; ?></p>
											
											<?php if (isset($r['meta']) && $r['meta'] != "") { ?>
												<p>
													<b>Тэги объявления: </b>
													<span class="result-keywords"><?php echo $r['meta']; ?></span>
												</p>
											<?php } ?>

											<p>
												<span class="advert__views" title="Просмотры"><?php echo $r['views']; ?></span>
												<span class="advert__time" title="Время <?php if ($r['type'] == 'found') {echo 'находки';} else {echo 'пропажи';} ?>"><?php echo $r['item_date']; ?></span>
											</p>

											<!-- <p>
												<a class="btn btn-xs btn-warning edit" href="edit.php?id=<?php echo $r['id']; ?>">Редактировать</a>
											</p> -->

											<p>
												<?php if (!$r['is_published']) { ?>
													<button 
														class="btn btn-xs btn-primary" 
														ng-click="publishAction(<?php echo $r['id']; ?>, true)">Публиковать</button>
												<?php } else { ?>
													<button 
														class="btn btn-xs btn-primary" 
														ng-click="publishAction(<?php echo $r['id']; ?>, false)">Убрать из публикации</button>
												<?php } ?>
											</p>
										</div>
										<div class="result__image">
											<img src="/upload/<?php echo $r['image_uri']; ?>">
										</div>
									</li>
								<?php } ?>
							</ul>

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