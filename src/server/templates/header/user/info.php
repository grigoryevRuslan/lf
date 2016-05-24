<div class="col-md-12 user__info">

	<img src="https://graph.facebook.com/<?php echo $_SESSION['user_id']; ?>/picture" />
	
	<div class="user__creds">

		<span><?php echo $_SESSION['user_name']; ?></span>

		<a href="http://<?php echo $GLOBALS['domain']; ?>/logout.php">Выйти</a>

	</div>

</div>