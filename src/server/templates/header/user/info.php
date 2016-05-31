<div class="col-md-12 user__info">

	<img src="<?php echo $_SESSION['user_avatar']; ?>" />
	
	<div class="user__creds">

		<span><?php echo $_SESSION['user_name']; ?></span>

		<a href="http://<?php echo $GLOBALS['domain']; ?>/logout.php">Выйти</a>

	</div>

</div>