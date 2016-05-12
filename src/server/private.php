<?php 

	if (!session_start()) die('Sessions does not work');

	include_once 'globals/common.php';
	include_once 'globals/db/db.php';
	include_once 'functions/functions.php';

	renderHead('Личный кабинет');

	if ( $GLOBALS['isAuthorised'] ) {

		if (isset($_GET['delete'])) {
			$deleteID = $_GET['delete'];
			$delete_q = $pdoConnection->prepare("DELETE FROM items WHERE id = '$deleteID'");
			$delete_q->execute();
		}

		$userID = $_SESSION['user_id'];
		$rows = [];
		$fetch_q = $pdoConnection->prepare("SELECT * FROM items WHERE user_id = '$userID' ORDER BY date_publish DESC");
		$fetch_q->execute();
		$result = $fetch_q->fetchAll();

		if (sizeof($result) == 0) {
			$noresult = 'У вас ещё нет обьявлений';
		}
	}
?>
	<main>
		
		<?php 

			include_once 'templates/header/header.php';

		?>

		<div class="container results advert">
			<div class="row">
					<?php 
						if (!empty($result)) {
					?>
					<p class="text-right"><strong>У вас <?php echo sizeof($result); ?> обьявлений</strong></p>

					<ul class="results">
						<?php foreach ($result as $r) { ?>
							<li class="result <?php echo $r['type']; ?>">
								<div class="result__content">
									<?php if (isset($r['date_publish'])) { ?>
										<p class='text-left'>
											<span class="time">Добавлено: <?php echo $r['date_publish'] ?></span>
										</p>
									<?php } ?>
									
									<a href="advert.php?id=<?php echo $r['id']; ?>">
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

									<p>
										<a class="btn btn-xs btn-danger delete" href="?delete=<?php echo $r['id']; ?>">Удалить</a>
										
										<a class="btn btn-xs btn-warning edit" href="edit.php?id=<?php echo $r['id']; ?>">Редактировать</a>
									</p>
								</div>
								<div class="result__image">
									<img src="upload/<?php echo $r['image_uri']; ?>">
								</div>
							</li>
						<?php } ?>
					</ul>

					<?php } else { ?>
						<p class="text-center">
							<?php echo $noresult; ?>
						</p>
					<?php } ?>

			</div>
		</div>
		
	</main>
	
	<footer class="text-center">
	
		<?php 

			include_once 'templates/footer/social.php';
	
			include_once 'templates/footer/info.php';
	
		?>
	
	</footer>
		
	<?php 
	
		if ( !$GLOBALS['isAuthorised'] ) {
			renderPopup('auth');
		}
	
	?>
		
	<script type="text/javascript" src="js/global/app.min.js"></script>

</body>
</html>