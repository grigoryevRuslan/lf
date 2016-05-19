<header class="container">
	
	<div class="row">

		<div class="col-md-4">

			<div class="row">
				
				<div class="col-md-6">
				
					<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/donate/donate.php'; ?>
					
				</div>

				<div class="col-md-6">
					
					<?php if ( $GLOBALS['isAuthorised'] ) { ?>
							
						<button class="btn btn-success open-popup btn-feedback" data-type="feedback">Задать вопрос</button>	

					<?php }?>

				</div>

			</div>

		</div>

		<div class="col-xs-6 col-md-4 logo">
			
			<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/logo/logo.php';?>
			
		</div>

		<div class="col-xs-6 col-md-4 user">
			
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