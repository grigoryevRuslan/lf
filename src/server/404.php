<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';

	renderHead('404. Страница потерялась', 'http://'.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '404. Страница потерялась');
?>

	<main>
		
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php'; ?>
		
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/controls/controls.php'; ?>

		<h1 class="text-center">Документ ещё не найден. Скоро мы найдём его :)</h1>

	</main>


	<footer class="text-center">

		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/social.php'; ?>
		
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/info.php'; ?>

	</footer>

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
	<script type="text/javascript" src="js/modules/ajax-auth.js"></script>
	<script type="text/javascript" src="js/modules/search_autocomplete.js"></script>

</body>
</html>