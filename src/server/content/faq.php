<?php 

	session_start();

	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';

	$faqs = "SELECT * FROM faq";
	$q = $pdoConnection->prepare($faqs);
	$q->execute();
	$result = $q->fetchAll(PDO::FETCH_ASSOC);

	renderHead('Ответы на часто задаваемые вопросы', ''.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'Ответы на часто задаваемые вопросы.');
?>

	<main>
		
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php'; ?>
		
		<h1 class="text-center">Ответы на часто задаваемые вопросы..</h1>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="faq">
						<?php if ($result) { ?>
							<?php foreach ($result as $r) { ?>
							<li>
								<p class="faq__header"><strong><?php echo $r['question']; ?></strong></p>
								<p class="faq__content"><?php echo $r['answer']; ?></p>
							</li>
							<?php } ?>
						<?php } ?>
					</ul>
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