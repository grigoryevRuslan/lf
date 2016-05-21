<?php 
	
	session_start();
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';

	renderHead('О проекте', 'http://'.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'О проекте');
?>

	<main>
		
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php'; ?>
		
		<h1 class="text-center">Бюро находок.</h1>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>Цель проекта - находить потери.</p>
					<p>Каждый день миллионы люди теряют и находят документы, телефоны, животных и
					много другое. И часто нашедший готов вернуть потерю ее владельцу. Только им
					нужно узнать о существовании и найти друг друга.</p>
					<p>Как правило ценность потерянной вещи для владельца на много превосходит
					ценность для другого человека.</p>
					<p>Например, личные архивы и фото на флешке в разы превосходит стоимость самой
					флешки. Это очень важно для владельца и фактически имеет нулевую стоимость
					для нашедшего.</p>
					<p>В сервис два ключевых принципах: максимальная защита от мошенников и простота
					использования.</p>
					<p>Защита от мошенников через инструмент проверки подлинности нашедшего и
					потерявшего. Раскрытие контактных данных другой стороне передается только после
					получения ответа на кодовый вопрос.</p>
					<p>Простота использования сервиса благодаря понятной логики процесса и
					лаконичному дизайну.</p>
					<p>Обеспечиваем встречи потерявших и нашедших что-то важное.</p>
					<p>Потерял или нашел на luckfind.me перешел.</p>

				</div>
			</div>
		</div>

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
	<script type="text/javascript" src="http://<?php echo $GLOBALS['domain']; ?>/js/global/app.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&amp;render=explicit" async defer
	></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="http://<?php echo $GLOBALS['domain']; ?>/js/modules/ajax-auth.js"></script>
	<script type="text/javascript" src="http://<?php echo $GLOBALS['domain']; ?>/js/modules/search_autocomplete.js"></script>

</body>
</html>