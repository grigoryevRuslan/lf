<?php
	if (!session_start()) die('Sessions does not work');
	header('Content-Type: text/html; charset=UTF8');
?>

<?php 
	
	include_once 'globals/common.php';
	include_once 'functions/functions.php';

	renderHead('Главная');

?>

	<main>
		
		<?php 

			include_once 'templates/header/header.php';
			include_once 'templates/controls/controls.php'; 

		?>
		
		<div class="container" ng-controller="gmapController">
			
			<div class="row">

				<div class="col-md-12 gmap" id="clusterMap"></div>
		
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

	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script type="text/javascript" src="js/global/app.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
	<script type="text/javascript" src="js/libs/markerclusterer.js"></script>
	<script type="text/javascript" src="js/modules/g_map_cluster.js"></script>
	<script type="text/javascript" src="js/modules/ajax-auth.js"></script>
	<script type="text/javascript" src="js/modules/search_autocomplete.js"></script>

</body>
</html>