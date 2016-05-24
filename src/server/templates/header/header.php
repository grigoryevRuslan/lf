<header class="container">
	
	<div class="row">

		<div class="col-md-4">

		</div>

		<div class="col-xs-5 col-md-4 logo">
			
			<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/logo/logo.php';?>
			
		</div>

		<div class="col-xs-7 col-md-4 user">
			
			<div class="row">
			
				<?php 
					if ( $GLOBALS['isAuthorised'] ) {

						include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/user/info.php';

					} else {

						include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/user/auth.php';

					}
				?>

			</div>

		</div>

	</div>

</header>