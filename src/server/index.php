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
	<script type="text/javascript" src="js/app.min.js"></script>

</body>
</html>