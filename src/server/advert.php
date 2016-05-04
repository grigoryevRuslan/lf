<?php

	if (isset($_GET['id'])) {
		if (!session_start()) die('Sessions does not work');

		include_once 'globals/common.php';
		include_once 'globals/db/db.php';
		include_once 'functions/functions.php';

		$id = $_GET['id'];

		$getAdvert = "SELECT * FROM items WHERE id = $id";
		$q = $pdoConnection->prepare($getAdvert);
		$q->execute();
		$result = $q->fetchAll();

		if (sizeof($result[0]) == 0) {
			$noresults = 'ничего не найдено';
		}
	} else {
		header("Location: index.php");
		exit();
	}

	renderHead('Объявление');
?>

	<main>
		
		<?php 

			include_once 'templates/header/header.php';
			include_once 'templates/controls/controls.php'; 

		?>

	<?php 
		if (isset($result[0])) {
	?>
		<div class="container">
			<div class="row">
				<div class="col-md-4 center-block advert">
					
					<div class="advert__item">
						<p style="text-align: center;">Объявление #<b><?php echo $id ?></b></p>
						<?php 
								if (isset($result[0]['image_uri'])) {
						?>
								<img src="upload/<?php echo $result[0]['image_uri']; ?>" alt="advert" />
						<?php }
						?>
						<h3><?php echo $result[0]['item']; ?></h3>
						<p><?php echo $result[0]['description']; ?></p>
						<p><b>Тэги объявления: </b><span class="advert__keywords"><?php echo $result[0]['meta']; ?></span></p>
						<p>
							<?php if  ($result[0]['reward'] != 0) {
								if  ($result[0]['type'] == 'found') { ?>
									<span class="advert__reward">Нашедший просит <?php echo $result[0]['reward']; ?> грн.</span>
								<?php } else { ?>
									<span class="advert__reward">Владелец обьявил награду: <?php echo $result[0]['reward']; ?> грн.</span>
								<?php }
							} else { ?>
								<span class="advert__reward">Информации о деньгах - нет.</span>
							<?php }?>
						</p>
						<span id="views" class="advert__views" title="Просмотры">0</span>
						<?php 
							include_once 'templates/share/share.php';
						?>
					</div>

				</div>
			</div>
		</div>
	<?php
		} else {
	?>
		<div class="container">
			<div class="row">
				<p class="center"><?php echo $noresults; ?></p>
			</div>
		</div>
	<?php
		}
	?>
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
	<script type="text/javascript" src="js/modules/share.js"></script>
	<script type="text/javascript" src="js/modules/ajax-counter.js"></script>
</body>
</html>
	