<?php
	if (!session_start()) die('Sessions does not work');
	header('Content-Type: text/html; charset=UTF8');
?>

<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';

	renderHead('Главная страница', ''.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'Бюро находок');

?>

	<main>
		
		<?php 
			include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php';
			include_once $_SERVER['DOCUMENT_ROOT'].'/templates/controls/controls.php';
		?>
		
		<?php if ($GLOBALS['useragent_type'] == 'desktop') { ?>

			<div class="container gmap-wrapper" ng-controller="gmapController">
				<div class="row gmap">

					<input type="text" class="form-control" placeholder="Найти на карте..." id="searchPlace" />

					<div class="switch-markers">
						<span class="icon icon_active switch-markers__show-all" data-show="all" title="Показать всё"></span>
						<span class="icon switch-markers__show-found" data-show="found" title="Показать находки"></span>
						<span class="icon switch-markers__show-lost" data-show="lost" title="Показать пропажи"></span>
					</div>

					<div id="clusterMap"></div>
			
				</div>
			</div>

		<?php } ?>

		<?php 
			if ( $GLOBALS['isAuthorised'] ) {
				include_once $_SERVER['DOCUMENT_ROOT'].'/templates/steps/main.php';
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
	<script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&amp;render=explicit" async defer
	></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>
	<script type="text/javascript" src="js/libs/markerclusterer.js"></script>

</body>
</html>