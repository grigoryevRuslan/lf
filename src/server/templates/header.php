<header class="container">
	
	<div class="row">

		<div class="col-md-4">
			
			<?php include_once 'templates/donate.php'; ?>

		</div>

		<div class="col-md-4 logo">
			
			<?php include_once 'templates/logo.php'; ?>

		</div>

		<div class="col-md-4 user">
			
			<div class="row">
			
				<?php 
					if ( $GLOBALS['isAuthorised'] ) {

						include_once 'templates/user/info.php';
						include_once 'templates/user/geolocation.php';

					} else {

						include_once 'templates/user/auth.php';

					}
				?>

			</div>

		</div>

	</div>

</header>