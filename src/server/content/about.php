<?php 
	
	session_start();
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';

	renderHead('О проекте', ''.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'О проекте');
?>

	<main>
		
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php'; ?>
		
		<h1 class="text-center">Бюро находок.</h1>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>Цель проекта – находить и возвращать утерянное.</p>
					<p>Каждый день миллионы люди теряют и находят документы, гаджеты, животных и многое другое. Часто нашедший готов вернуть утерю ее владельцу. Им только нужно узнать о существовании друг друга, найти друг друга.</p>
					<p>Как правило, ценность утерянной вещи для владельца на много превосходит ее ценность для другого человека.</p>
					<p>Например, личные архивы и фото на флешке в разы превосходят стоимость самой флешки. То, что очень важно для владельца, фактически имеет нулевую стоимость для нашедшего.</p>
					<p>В сервисе заложены два ключевых принципа: максимальная защита от мошенников и простота использования.</p>
					<p>Защита от мошенников работает через инструмент проверки подлинности личностей нашедшего и потерявшего. Раскрытие контактных данных другой стороне происходит только после получения ответа на кодовый вопрос.</p>
					<p>Сервис прост в использовании, благодаря понятной логике процесса и лаконичному дизайну.</p>
					<p>Мы обеспечиваем встречи потерявших и нашедших утерянное.</p>
					<p>Потерял или нашел - на <a href="http://www.luckfind.me">luckfind.me</a> перешел.</p>

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

	<script type="text/javascript" src="http://<?php echo $GLOBALS['domain']; ?>/js/global/app.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&amp;render=explicit" async defer
	></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

</body>
</html>