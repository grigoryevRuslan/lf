<div class="info">
		
	<ul class="info__links">
		<li><a href="http://<?php echo $GLOBALS['domain'] ?>/content/about.php">О проекте</a></li>
		<li><a href="http://<?php echo $GLOBALS['domain'] ?>/content/faq.php">Часто задаваемые вопросы</a></li>
		<li><a href="http://<?php echo $GLOBALS['domain'] ?>/content/privacy.php">Политика конфеденциальности</a></li>
		<?php if ( $GLOBALS['isAuthorised'] ) { ?>
			<li><a class="open-popup btn-feedback" href="#" data-type="feedback">Задать вопрос</a></li>
		<?php } ?>
		<li><a href="https://www.liqpay.com/api/3/checkout?data=eyJ2ZXJzaW9uIjozLCJhY3Rpb24iOiJwYXkiLCJwdWJsaWNfa2V5IjoiaTE1NDA0NTY0NTk2IiwiYW1vdW50IjoiMTAiLCJjdXJyZW5jeSI6IlVBSCIsImRlc2NyaXB0aW9uIjoi0J%2FQvtC80L7Rh9GMINC%2F0YDQvtC10LrRgtGDIiwidHlwZSI6ImJ1eSIsImxhbmd1YWdlIjoicnUifQ%3D%3D&signature=jCswg60o3uQQku%2BsHJwibh5TJl8%3D">Помочь проекту</a></li>
	</ul>

	<p class="info__copyright">
		Copyright&nbsp;&nbsp;©&nbsp;&nbsp;2016&nbsp;&nbsp;<a href="http://<?php echo $GLOBALS['domain']; ?>">www.luckfind.me</a>
	</p>

</div>