<?php

	if (isset($_GET['id'])) {
		if (!session_start()) die('Sessions does not work');

		include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
		include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
		include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';

		$id = $_GET['id'];

		$getAdvert = "SELECT * FROM items WHERE id = $id";
		$q = $pdoConnection->prepare($getAdvert);
		$q->execute();
		$result = $q->fetchAll();

		if (sizeof($result[0]) == 0) {
			$noresults = 'ничего не найдено';
		} else {
			$imageUrl = $GLOBALS['domain'].'/upload/'.$result[0]['image_uri'];
		}
	} else {
		header("Location: index.php");
		exit();
	}

	renderHead('Объявление в бюро находок LuckFind', $imageUrl, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $result[0]['description']);
?>

	<main>
		
		<?php 

			include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php';

		?>

	<?php 
		if (isset($result[0])) {
	?>
		<div class="container">
			<div class="row advert">
				<div class="<?php if($result[0]['coordinates'] == ''){echo 'col-md-8 center-block';} else {echo 'col-md-6';} ?>">
					
					<div class="advert__item">
						<p style="text-align: center;">Объявление #<b><?php echo $id ?></b></p>
						<?php 
								if (isset($result[0]['image_uri'])) {
						?>
								<div class="advert__image">
									<img src="upload/<?php echo $result[0]['image_uri']; ?>" alt="advert" />
								</div>
						<?php }
						?>
						<h3>
							<?php if ($result[0]['item'] != '') {
								echo $result[0]['item'];
							} else {
								echo $result[0]['user_item'];
							}?>
						</h3>
						<p><?php echo $result[0]['description']; ?></p>
						<p><b>Тэги объявления: </b><span class="advert__keywords"><?php echo $result[0]['meta']; ?></span></p>
						<p>
							<?php if ($result[0]['reward'] != 0) {
								if ($result[0]['type'] == 'found') { ?>
									<span class="advert__reward">Нашедший просит <?php echo $result[0]['reward']; ?> грн.</span>
								<?php } else { ?>
									<span class="advert__reward">Владелец обьявил награду: <?php echo $result[0]['reward']; ?> грн.</span>
								<?php }
							} else { ?>
								<span class="advert__reward">Информации о деньгах - нет.</span>
							<?php }?>
						</p>
						<p>
							<span id="views" class="advert__views" title="Просмотры"></span>
							<span class="advert__time" title="Время <?php if ($result[0]['type'] == 'found') {echo 'находки';} else {echo 'пропажи';} ?>"><?php echo $result[0]['item_date'] ?></span>
						</p>
						
						<div id="fb-root"></div>
						<script>(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.6&appId=1688370178097956";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>

						<?php 
							include_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/share.php';
						?>
					</div>

				</div>
				
				<?php if($result[0]['coordinates'] != '') { ?>
				
					<div class="col-md-6">
						<div id="advertMap"></div>
					</div>
					
				<?php } ?>
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

			include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/social.php';
	
			include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/info.php';
	
		?>
	
	</footer>
		
	<?php 
	
	    if ( !$GLOBALS['isAuthorised'] ) {
	        renderPopup('auth');
	    } else {
	        renderPopup('feedback');
	    }

	?>
		
	<script type="text/javascript" src="js/global/app.min.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
	<script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&amp;render=explicit" async defer
	></script>
	<script type="text/javascript" src="js/modules/ajax-auth.js"></script>
	<script type="text/javascript" src="js/modules/share.js"></script>
	<script type="text/javascript" src="js/modules/ajax-counter.js"></script>
	<script type="text/javascript" src="js/modules/advert-map.js"></script>
</body>
</html>
	
