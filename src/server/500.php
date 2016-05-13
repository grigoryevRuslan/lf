<?php 
	
	include_once 'globals/common.php';
	
	include_once 'functions/functions.php';

	renderHead('500. Внутренняя ошибка сервера', 'http://'.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '500. Внутренняя ошибка сервера');
?>

	<main>
		
		<?php include_once 'templates/header/header.php'; ?>
		
		<?php include_once 'templates/controls/controls.php'; ?>

		<h1 class="text-center">Какая-то херня с сервером :)</h1>

	</main>


	<footer class="text-center">

		<?php include_once 'templates/footer/social.php'; ?>
		
		<?php include_once 'templates/footer/info.php'; ?>

	</footer>

	<script type="text/javascript" src="js/app.min.js"></script>

</body>
</html>