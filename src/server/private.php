<?php 
	if (!session_start()) die('Sessions does not work');
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
	
	if (!$GLOBALS['isAuthorised']) {header('Location: http://'.$_SERVER['HTTP_HOST'].'/');}
	
	renderHead('Личный кабинет', ''.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'Личный кабинет');

	if ( $GLOBALS['isAuthorised'] ) {

		if (isset($_POST['delete'])) {
			$deleteID = intval($_POST['delete']);
			$delete_q = $pdoConnection->prepare("
				UPDATE 
					items 
				SET 
					is_deleted = 1,
					is_published = 0
				WHERE 
					id = '$deleteID'
			");
			$delete_q->execute();
		}

		if (isset($_GET['from'])) {
			$from = $_GET['from'];
		} else {
			$from = 0;
		}

		$userID = $_SESSION['user_id'];

		$amount = intval( $pdoConnection->query("SELECT COUNT(*) as count FROM items WHERE user_id = '$userID' AND is_published = 1")->fetchColumn() );

		$fetch_q = $pdoConnection->prepare("
			SELECT * 
			FROM items 
			WHERE user_id = '$userID' 
			AND is_published = 1 
			ORDER BY date_publish DESC 
			LIMIT $from, 5
		");
		
		$fetch_q->execute();
		$result = $fetch_q->fetchAll();

		if ($amount == 0) {
			$noresult = 'У вас ещё нет обьявлений';
		}
	}
?>
	<main>
		
		<?php 

			include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php';

			if ($amount == 0) {

				include_once $_SERVER['DOCUMENT_ROOT'].'/templates/controls/controls.php';

			}

		?>

		<div class="container results advert">
	
			<?php if ($amount > 5) { ?>
				
				<div class="row text-center">
					<ul class="pagination">
						
						<?php for ($i = 0; $i <= $amount; $i+=5) { 
							if ($i == $from) { ?>
								
								<li class="active">
									<span><?php echo $i; ?>-<?php echo ($i + 5); ?></span>
								</li>
								
							<?php } else { ?>
							
								<li>
									<a href="/private.php?from=<?php echo $i; ?>">
										<?php echo $i; ?>-<?php echo ($i + 5); ?>
									</a>
								</li>

							<?php }

						} ?>		

					</ul>
				</div>

			<?php } ?>

			<div class="row">
					<?php 
						if (!empty($result)) {
					?>
					<p class="text-right"><strong>У вас <?php echo $amount; ?> обьявлений</strong></p>

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
										<a class="btn btn-xs btn-danger delete open-popup" 
											data-type="ad-remove" 
											href="#"
											data-remove="<?php echo $r['id']; ?>">Удалить</a>
										
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
	
	<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/footer.php'; ?>
		
	<?php 
	
	    if ( !$GLOBALS['isAuthorised'] ) {
	        renderPopup('auth');
	    } else {
	        renderPopup('feedback');
	        renderPopup('ad-remove');
	    }

	?>
		
	<script type="text/javascript" src="js/global/app.min.js"></script>

</body>
</html>