<div class="col-md-12 user__info" ng-controller="pmController">

	<img src="https://graph.facebook.com/<?php echo $_SESSION['user_id']; ?>/picture" />
	
	<div class="user__creds">

		<span><?php echo $_SESSION['user_name']; ?></span>

		<a 
			href="http://<?php echo $GLOBALS['domain']; ?>/pm.php" 
			class="user__pm user__pm_recieved">
			<span class="pm"ng-show="pm">{{pm}}</span>
		</a>

		<a href="http://<?php echo $GLOBALS['domain']; ?>/private.php" class="user__pm user__pm_private"></a>

		<a href="http://<?php echo $GLOBALS['domain']; ?>/logout.php">Выйти</a>

	</div>

</div>