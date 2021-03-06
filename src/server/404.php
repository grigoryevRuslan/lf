<?php 
	if (!session_start()) die('Sessions does not work');
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';
	
	if (!$GLOBALS['isAuthorised']) {header('Location: http://'.$_SERVER['HTTP_HOST'].'/');}

	renderHead('404. Страница потерялась', ''.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '404. Страница потерялась');
?>

	<main>
		
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php'; ?>
		
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/controls/controls.php'; ?>

		<h1 class="text-center">Документ ещё не найден. Скоро мы найдём его :)</h1>

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

</body>
</html>