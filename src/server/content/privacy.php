<?php 
	
	session_start();

	include_once '../globals/common.php';
	
	include_once '../functions/functions.php';

	renderHead('Политика конфеденциальности', 'http://'.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'Политика конфеденциальности');
?>

	<main>
		
		<?php include_once '../templates/header/header.php'; ?>
		
		<h1 class="text-center">Правила использования сайта.</h1>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					
					<ol class="ordered-list">
						<li>	 
							Используя сайт либо регистрируясь на сайте, Пользователь соглашается с настоящими Правилами в полном объеме, без всяких оговорок и исключений.
						</li>
						<li>
							В случае несогласия или частичного несогласия с Правилами,  Пользователь обязан покинуть Сайт. 
							Сайт не проверяет достоверность публикуемой информации о находках. Ответственность за достоверность публикуемой информации о находках несет Пользователь.
						</li>
						<li>
							Пользователь, нашедший потерянную вещь, и разместивший соответствующую информацию на сайте обязан соблюдать законодательство о находках той страны, в которой данная вещь найдена. 
						</li>
						<li>
							В правоотношениях, а также спорах между Пользователями - собственниками потерянных вещей и лицами их нашедшими Сайт участия не принимает, и не несет ответственность за действия какой-либо из сторон.
							Все персональные данные, которые Пользователь указывает при регистрации на сайте, в силу природы сайта, являются доступными любому пользователю сети Интернет.
						</li>
						<li>
							Сайт не несет ответственности за действия третьих лиц, получивших в результате использования сайта доступ к информации о Пользователе, которую он указал при регистрации на сайте.
						</li>
					</ol>
					
				</div>
			</div>
		</div>

	</main>

	<footer class="text-center">

		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/footer.php'; ?>
		
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
	<script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&amp;render=explicit" async defer
	></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="http://<?php echo $GLOBALS['domain']; ?>/js/modules/ajax-auth.js"></script>
	<script type="text/javascript" src="http://<?php echo $GLOBALS['domain']; ?>/js/modules/search_autocomplete.js"></script>

</body>
</html>