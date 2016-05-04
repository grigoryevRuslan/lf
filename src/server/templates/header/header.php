<header class="container">
	
	<div class="row">

		<div class="col-md-4">
			
			<?php include_once 'donate/donate.php'; ?>

		</div>

		<div class="col-md-4 logo">
			
			<?php include_once 'logo/logo.php';?>
			
		</div>

		<div class="col-md-4 user">
			
			<div class="row">
			
				<?php 
					if ( $GLOBALS['isAuthorised'] ) {

						include_once 'user/info.php';

					} else {

						include_once 'user/auth.php';

					}
				?>

			</div>

		</div>

	</div>

</header>