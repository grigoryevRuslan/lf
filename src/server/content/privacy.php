<?php 

	include_once '../globals/common.php';
	
	include_once '../functions/functions.php';

	renderHead('Политика конфеденциальности', 'http://'.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'Политика конфеденциальности');
?>

	<main>
		
		<?php include_once '../templates/header/header.php'; ?>
		
		<?php include_once '../templates/controls/controls.php'; ?>

		<h1 class="text-center">Политика конфеденциальности.</h1>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
				</div>
			</div>
		</div>

	</main>


	<footer class="text-center">

		<?php include_once '../templates/footer/social.php'; ?>
		
		<?php include_once '../templates/footer/info.php'; ?>

	</footer>

	<script type="text/javascript" src="http://<?php echo $GLOBALS['domain']; ?>/js/global/app.min.js"></script>

</body>
</html>