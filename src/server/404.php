<?php 
	
	include_once 'globals/common.php';
	
	include_once 'functions/functions.php';

	renderHead('404. Страница потерялась');
?>

	<main>
		
		<?php include_once 'templates/header/header.php'; ?>
		
		<?php include_once 'templates/controls/controls.php'; ?>

		<h1 class="text-center">Документ ещё не найден. Скоро мы найдём его :)</h1>

	</main>


	<footer class="text-center">

		<?php include_once 'templates/footer/social.php'; ?>
		
		<?php include_once 'templates/footer/info.php'; ?>

	</footer>

	<script type="text/javascript" src="js/app.min.js"></script>

</body>
</html>