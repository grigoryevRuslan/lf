<?php 

	session_start();

	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';

	renderHead('Ответы на часто задаваемые вопросы.', 'http://'.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'Ответы на часто задаваемые вопросы.');
?>

	<main>
		
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php'; ?>
		
		<h1 class="text-center">Ответы на часто задаваемые вопросы..</h1>

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
	<script type="text/javascript" src="http://<?php echo $GLOBALS['domain']; ?>/js/global/app.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="http://<?php echo $GLOBALS['domain']; ?>/js/modules/ajax-auth.js"></script>
	<script type="text/javascript" src="http://<?php echo $GLOBALS['domain']; ?>/js/modules/search_autocomplete.js"></script>

</body>
</html>