<div class="info">
		
	<ul class="info__links">
		<li><a href="http://<?php echo $GLOBALS['domain'] ?>/content/about.php">О проекте</a></li>
		<li><a href="http://<?php echo $GLOBALS['domain'] ?>/content/faq.php">Часто задаваемые вопросы</a></li>
		<li><a href="http://<?php echo $GLOBALS['domain'] ?>/content/privacy.php">Политика конфеденциальности</a></li>
		<?php if ( $GLOBALS['isAuthorised'] ) { ?>
			<li><a class="open-popup btn-feedback" href="#" data-type="feedback">Задать вопрос</a></li>
		<?php } ?>
	</ul>

	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center logo">
				<a href="http://luckfind-dev.me">
					<img src="http://luckfind-dev.me/img/svg/logo.svg" alt="logo">
				</a>		
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/donate/donate.php'; ?>
			</div>
		</div>
	</div>

	<p class="info__copyright">
		Copyright&nbsp;&nbsp;©&nbsp;&nbsp;2016&nbsp;&nbsp;<a href="http://<?php echo $GLOBALS['domain']; ?>">www.luckfind.me</a>
	</p>

</div>