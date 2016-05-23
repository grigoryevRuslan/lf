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
		
		<div class="container" ng-controller="gmapController">
			
			<div class="row gmap">

				<input type="text" class="form-control" placeholder="Введите улицу, район, город ..." id="searchPlace" />

				<div class="switch-markers">
					<span class="icon switch-markers__show-all" data-show="all"></span>
					<span class="icon switch-markers__show-found" data-show="found"></span>
					<span class="icon switch-markers__show-lost" data-show="lost"></span>
				</div>

				<div class="col-md-12" id="clusterMap"></div>
		
			</div>

		</div>

		<?php 
			if ( $GLOBALS['isAuthorised'] ) {
				include_once $_SERVER['DOCUMENT_ROOT'].'/templates/counter/counter.php';
				include_once $_SERVER['DOCUMENT_ROOT'].'/templates/latest/latest.php';
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

	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script type="text/javascript" src="js/global/app.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&amp;render=explicit" async defer
	></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>
	<script type="text/javascript" src="js/libs/markerclusterer.js"></script>
	<script type="text/javascript" src="js/modules/g_map_cluster.js"></script>
	<script type="text/javascript" src="js/modules/ajax-auth.js"></script>
	<script type="text/javascript" src="js/modules/search_autocomplete.js"></script>

</body>
</html>