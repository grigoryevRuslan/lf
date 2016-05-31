<?php

	if (isset($_GET['id'])) {
		if (!session_start()) die('Sessions does not work');

		include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
		include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
		include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';

		$id = $_GET['id'];

		$getAdvert = "SELECT * FROM items WHERE id = $id AND is_published = 1";
		$q = $pdoConnection->prepare($getAdvert);
		$q->execute();
		$result = $q->fetchAll();

		if (sizeof($result[0]) == 0) {
			$noresults = 'Обьявление проверяется модератом.';
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

						<?php if (isset($result[0]['meta']) && $result[0]['meta'] != "") { ?>
							<p>
								<b>Тэги объявления: </b>
								<span class="result-keywords">
									<?php
										$meta = explode(',', $result[0]['meta']);
										foreach ($meta as $metakey) {
											$metatext = trim($metakey);
											echo "<a href='http://".$_SERVER['HTTP_HOST']."/search.php?q=".$metatext."' class='result__tag'>".$metatext."</a>, ";
										}
									?>
								</span>
							</p>
						<?php } ?>

						<p>
							<?php if ($result[0]['reward'] != 0) {
								if ($result[0]['type'] == 'found') { ?>
									<span class="advert__reward">Нашедший просит <strong><?php echo $result[0]['reward']; ?></strong> грн.</span>
								<?php } else { ?>
									<span class="advert__reward">Владелец обьявил награду: <strong><?php echo $result[0]['reward']; ?></strong> грн.</span>
								<?php }
							} else { ?>
								<span class="advert__reward">Информации о деньгах - нет.</span>
							<?php }?>
						</p>
						<p>
							<span id="views" class="advert__views" title="Просмотры"></span>
							<span class="advert__time" title="Время <?php if ($result[0]['type'] == 'found') {echo 'находки';} else {echo 'пропажи';} ?>"><?php echo $result[0]['item_date'] ?></span>
						</p>

						<?php 
							if ($_SESSION['user_id'] != $result[0]['user_id']) {

								if ($GLOBALS['isAuthorised']) { ?>
							
									<div class="verify"
										 ng-controller="verifyController"
										 ng-init="verify.hideField = true;
										 		  verify.advertId = <?php echo $id; ?>;
										 		  verify.advertType = '<?php echo $result[0]['type']; ?>';">

										<button
											class="btn btn-s btn-success" 
											ng-click="verify.hideField = !verify.hideField;
													  response.success = false;
													  response.error = false;
													  response.sending = false;"><?php if ($result[0]['type'] == 'lost') {echo 'Я нашёл';} else {echo 'Я потерял';} ?>. Написать автору</button>

										<form 
											class="verify__request"
											method="POST"
											action="."
											ng-hide="verify.hideField">

											<br />

											<textarea 
												maxlength="300"
												class="form-control"
												row="20"
												cols="30"
												ng-init="verify.request = ''"
												ng-model="verify.request"
												placeholder="Отправьте заявку личным сообщением автору объявления. Для этого введите уникальную особенность (ФИО, номер лицензии, содержимое кошелька или ваш вариант."></textarea>

											<br />

											<p>
												<button
													class="btn btn-s btn-primary"
													ng-click="sendRequest($event);"
													ng-disabled="response.sending || !verify.request">Отправить автору</button>
											</p>

										</form>
										
										<br /><br />

										<p ng-show="response.success || response.error">{{response.success || response.error}}</p>
									</div>							

								<?php } else { ?>
									
									<p>
										<a href="#" class="open-popup" data-type="auth">Зарегистрируйтесь</a>, чтобы отправить заявку автору объявления
									</p>

								<?php }

							} ?>
						
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
						<div id="advertMap">
							<img src="http://<?php echo $GLOBALS['domain']; ?>/img/gif/preloader.gif" class="search__preloader" alt="search__preloader" />
						</div>
					</div>
					
				<?php } ?>
			</div>
		</div>
	<?php
		} else {
	?>
		<div class="container">
			<div class="row">
				<h2 class="text-center"><?php echo $noresults; ?></h2>
			</div>
		</div>
	<?php
		}
	?>
	</main>

	<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/footer.php'; ?>
		
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
	<script type="text/javascript" src="js/modules/ajax-counter.js"></script>
	<script type="text/javascript" src="js/modules/advert-map.js"></script>
</body>
</html>
	
