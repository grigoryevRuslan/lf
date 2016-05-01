<?php
	session_start();
	header('Content-Type: text/html; charset=UTF8');
?>

<?php 
	
	include_once 'globals/common.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Главная</title>
	<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
	<link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAA////AN0A/wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAERERERAAAAAREREREAAAABEREREQAAAAEAAAABAAAAAQEQEQEAAAABESIhEQAAAAEREhERAAAAARAREBEAAAAREBEQERAAAREREREREQARABERERABEBEREREREREQAREQAAAREQAAAAAAAAAAD//wAA//8AAPAHAADwBwAA8AcAAPAHAADwBwAA8AcAAPAHAADwBwAA4AMAAMABAACAAAAAgAAAAMPhAAD//wAA" rel="icon" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<div class="header container">
		<div class="row">
			<div class="col-md-4">
				
				<?php include_once 'templates/donate.php' ?>

			</div>

			<div class="col-md-4 logo">
				
				<a href="http://<?php echo $GLOBALS['domain']; ?>">
					<img src="img/svg/logo.svg" alt="logo" />
				</a>

			</div>

			<div class="col-md-4 user">
				
				<?php 
					if ( $GLOBALS['isAuthorised'] ) {
						echo 'authorised';
					} else {
				?>
				
					<ul class="user__auth">
						
						<li class="auth__fb">
							
							<a href="config/fb/fbconfig.php"></a>

						</li>
						
						<li class="auth__simple">
							
							<a href="#" id="open_forms"></a>

						</li>
						
					</ul>

				<?php
					}
				?>

			</div>
		</div>
	</div>

	<script type="text/javascript" src="js/app.min.js"></script>
</body>
</html>