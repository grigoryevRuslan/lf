<?php
	if (!session_start()) die('Sessions does not work');

	include_once 'globals/common.php';
	include_once 'functions/functions.php';

	if (isset($_GET['id']) && isset($_SESSION['user_id'])) {

			include_once 'globals/db/db.php';
			include_once 'app/save_image.php';
			
			$id = $_GET['id'];
			$userId = $_SESSION['user_id'];
			$getEditQuery = $pdoConnection->prepare("SELECT * FROM items WHERE id = '$id' AND user_id = '$userId'");
			$getEditQuery->execute();
			$resultGetEditQuery = $getEditQuery->fetchAll();
	}

	renderHead('Редактирование объявления');

?>

<main>
	
	<?php 

		include_once 'templates/header/header.php';

	?>
		
		<?php if ($resultGetEditQuery) { ?>

		<div class="container" ng-controller="addAdvertController" ng-init="preloadTags = '<?php echo $resultGetEditQuery[0]['meta']; ?>'">

			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<form action="add.php" method="POST" autocomplete="off" class="form form_add form-horizontal" accept-charset="UTF-8" enctype="multipart/form-data" validate="true" id="form_add">

						<input type="hidden" name="action" value="edit" />

						<input type="hidden" name="edit_id" value="<?php echo $resultGetEditQuery[0]['id']; ?>" />

						<input type="hidden" name="type" value="<?php echo $resultGetEditQuery[0]['type']; ?>" />
							
						<input type="hidden" name="meta" value="{{meta}}" />
						
						<div class="form-group">

							<label class="col-sm-4 control-label" for="item">Предмет</label>

							<div class="col-sm-8">
							
								<select class="form-control"
										name="item"
										id="item"
										ng-model="sSubject"
										ng-init="sSubject = '<?php if ($resultGetEditQuery[0]['item'] != '') {echo $resultGetEditQuery[0]['item'];} else {echo 'default';} ?>'"
										ng-disabled="iSubject != ''">
									<option value="default" selected>Выберите предмет из списка</option>
									<option value="Паспорт">Паспорт</option>
									<option value="Доверенность">Доверенность</option>
									<option value="Лицензия">Лицензия</option>
									<option value="Водительские">Водительские права</option>
								</select>
								
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="user_item">Или введите своё:</label>
							<div class="col-sm-8">
								<input 
									type="text" 
									name="user_item" 
									id="user_item" 
									class="form-control" 
									placeholder="название предмета"
									ng-model="iSubject"
									ng-init="iSubject = '<?php if ($resultGetEditQuery[0]['user_item'] != '') {echo $resultGetEditQuery[0]['user_item'];} else {echo '';} ?>'"
									ng-disabled="sSubject != 'default'" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">Дата <?php if ($resultGetEditQuery[0]['type'] == 'found') { ?> находки <?php } else { ?> пропажи <?php } ?></label>
							<div class="col-sm-8 datepicker-wrapper">
								<input 
									type="text" 
									id="datepicker" 
									name="date" 
									class="form-control"
									data-default="<?php echo $resultGetEditQuery[0]['item_date']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="description">Дополнительная информация:</label>
							<div class="col-sm-8">
								<textarea 
									name="description" 
									ng-init="description = '<?php echo $resultGetEditQuery[0]['description']; ?>'"
									ng-bind="description"
									id="description" 
									maxlength="300" 
									class="form-control" 
									placeholder="введите всю информацию"
									required><?php echo $resultGetEditQuery[0]['description'] ?></textarea>
							</div>
						</div>

						<div class="form-group reward">
							<label class="col-sm-4 control-label" for="reward">
								<?php if ($resultGetEditQuery[0]['type'] == 'found') { ?>
									<span>
											Вознаграждение
									</span>
								<?php } else { ?>
									<span>
											Сколько заплатите ?
									</span>
								<?php } ?>
							</label>
							<div class="col-sm-8">
								<input 
									ng-model="reward"
									ng-init="reward = '<?php echo $resultGetEditQuery[0]['reward'] ?>'"
									name="reward" 
									id="reward" 
									class="form-control" 
									placeholder="введите сумму в грн." />
								<strong class="reward__prefix">грн.</strong>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="phone">Телефон:</label>
							<div class="col-sm-8">
								<strong class="phone_prefix">+38</strong>
								<input 
									type="text" 
									name="phone" 
									id="phone" 
									class="form-control" 
									placeholder="номер телефона" 
									maxlength="10"
									ng-model="phone"
									ng-init="phone = '<?php echo $resultGetEditQuery[0]['phone'] ?>'" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="mail">E-mail:</label>
							<div class="col-sm-8">
								<input 
									type="text" 
									name="mail" 
									id="mail" 
									class="form-control" 
									placeholder="электронная почта"
									ng-model="mail"
									ng-init="mail = '<?php echo $resultGetEditQuery[0]['mail'] ?>'" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="meta">Ключевые слова:</label>
							<div class="col-sm-8">
								<tags-input 
									ng-model="tags"
									max-tags="10"
									placeholder="После ввода - Enter">
								</tags-input>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								Поставьте маркер на место <?php if ($resultGetEditQuery[0]['type'] == 'found') { ?> находки <?php } else { ?> пропажи <?php } ?> : 
								
								<button class="btn btn-mini btn-primary open-popup">Открыть карту</button>

							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-10">
								<input type="hidden" name="coordinates" value="<?php if ( isset($resultGetEditQuery[0]['coordinates']) && $resultGetEditQuery[0]['coordinates'] != '' ) { echo $resultGetEditQuery[0]['coordinates'];} ?>" id="coordinates" />
								<p id="gmap-address"></p>
							</div>
							<div class="col-sm-2">
								<span id="clearAddress">&times;</span>
							</div>
						</div>

						<label>
							<span>Добавьте изображение (размером меньше 1 Мб):</span>
							<input type='file' id="addUploadFile" name="fileToUpload" />
							<img id="addUploadFilePreview" src="." alt="advert image" />
						</label>

						<label for="mail_delivery">
							<input type="checkbox" name="mail_delivery" id="mail_delivery" checked />
							<span style="width:70%">Хотите получать первыми обьявления о похожих находках/пропажах :</span>
						</label>

						<div class="g-recaptcha" 
						     vc-recaptcha
							 key="'6LetcxwTAAAAADqMNJtSZ1H_YEUZrmK-ygQofI4t'"
							 theme="'light'"
							 on-success="setResponse(response)"
							 on-expire="cbExpiration()"></div>

						<p class="text-center">
							<button 
								type="submit" 
								class="btn btn-primary"
								ng-disabled="!submitted || !description || description == '' || (sSubject == 'default' && iSubject == '') || (!phone && !mail)" />Сохранить</button>
						</p>
					</form>
				</div>
				<div class="col-md-3"></div>
			</div>

		</div>

		<?php } else { ?> 
			<h2 class="text-center">Доступ запрещен! </h2>
		<?php } ?>
	</main>

	<footer class="text-center">
	
		<?php 

			include_once 'templates/footer/social.php';
	
			include_once 'templates/footer/info.php';
	
		?>
	
	</footer>

	<div class="popup popup_map">
		<div class="popup__container">
			<div id="mapCanvas" class="gmap"></div>
			<span class="popup__close">&times;</span>
		</div>
	</div>
	
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script type="text/javascript" src="js/global/app.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&amp;render=explicit" async defer
	></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
	<script type="text/javascript" src="js/modules/upload.js"></script>
	<script type="text/javascript" src="js/modules/getcoordinates.js"></script>
	<script type="text/javascript" src="js/modules/datepicker.js"></script>
</body>
</html>