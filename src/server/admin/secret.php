<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';

	$query = $pdoConnection->prepare("SELECT * FROM secret");
	$query->execute();
	$result = $query->fetchAll();

?>

<!DOCTYPE html>
<html lang="en" ng-app="admin">
<head>
	<meta charset="UTF-8">
	<title>Admin part</title>
	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>

	<?php include_once $_SERVER['DOCUMENT_ROOT'].'/admin/templates/menu.php'; ?>

	<div class="container secrets">
			
		<h1 class="text-center">Секретные коды. Образцы.</h1>

		<?php if (!empty($result)) { ?>

			<div class="row">
			
				<div class="col-md-4">
					<strong>Наименование:</strong>
				</div>

				<div class="col-md-4">
					<strong>Описание:</strong>
				</div>
				
				<div class="col-md-4 text-center">
					<strong>Пример:</strong>
				</div>
				
			</div>

			<?php foreach ($result as $r) { ?>

				<div class="row secret">
				
					<div class="col-md-4">
						<?php echo $r['name'] ?>
					</div>

					<div class="col-md-4">
						<?php echo $r['description'] ?>
					</div>
					
					<div class="col-md-4 text-center">
						<?php echo $r['example'] ?>
					</div>
					
				</div>

			<?php } ?>

		<?php } ?>

	</div>

	<div class="container">
		<div class="row">

			<div class="col-md-12">
				<form 
					method="POST" 
					class="form form_secret"
					action='/' 
					name="formSecret"
					ng-controller="secretController"
					validate="true">
					
					<div class="col-md-2">
						
						<input 
							class="form-control"
							type="text"
							placeholder="Наименование предмета"
							required="true"
							ng-model="name"
							maxlength="30" />

					</div>

					<div class="col-md-3">
						
						<textarea 
							class="form-control"
							ng-model="description"
							placeholder="Краткое описание предмета" 
							required="true"
							maxlength="250"></textarea>

					</div>

					<div class="col-md-3">
						
						<input 
							class="form-control"
							type="text"
							placeholder="Пример кода"
							required="true"
							ng-model="example"
							maxlength="30" />

					</div>

					<div class="col-md-2">
						
						<button 
							type="submit"
							class="btn btn-primary"
							ng-click="save($event)"
							ng-disabled="isSending || !formSecret.$valid">Сохранить</button>

					</div>

					<div class="col-md-2">
						
						<span style="color: green;">{{response.success || response.error}}</span>

					</div>
				</form>
			</div>
			
		</div>
	</div>

	<script type="text/javascript" src="../js/global/app.min.js"></script>
	<script type="text/javascript" src="js/app/app.js"></script>
	<script type="text/javascript" src="js/app/controllers/secretController.js"></script>

</body>
</html>