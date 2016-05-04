<?php
	if (!session_start()) die('Sessions does not work');

	include_once 'globals/common.php';
	include_once 'functions/functions.php';

	if (!empty($_POST)) {

			include_once 'globals/db/db.php';
			include_once 'app/save_image.php';

			if (isset ($_POST['mail_delivery']) && $_POST['mail_delivery'] == 'on') {
				$mail_delivery = 1;
			} else {
				$mail_delivery = 0;
			}
			
			if (isset($_POST['item']) && $_POST['item'] != 'default') {
				$item = $_POST['item'];
				$user_item = '';
			} else {
				if (isset($_POST['user_item'])) {
					$user_item = $_POST['user_item'];
					$item = '';
				}
			}

			$description = $_POST['description'];
			$reward = $_POST['reward'];
			$type = $_POST['type'];
			$phone = $_POST['phone'];
			$mail = $_POST['mail'];
			$meta = $_POST['meta'];
			$fb_id = $_SESSION['user_id'];

			if (isset($_POST['coordinates'])) {
				$coordinates = $_POST['coordinates'];
			} else {
				$coordinates = '';
			}

			$mysqltime = date ("Y-m-d H:i:s");

			if (isset($newfilename)) {
				$fileUrl = $newfilename;
			} else {
				$fileUrl = 'no-image-available.png';
			}

			$query = $pdoConnection->prepare("INSERT INTO items (item, user_item, description, coordinates, reward, type, phone, mail, meta, image_uri, date_publish, mail_delivery, user_id) VALUES ('$item', '$user_item', '$description', '$coordinates', '$reward', '$type', '$phone', '$mail', '$meta', '$fileUrl', '$mysqltime', '$mail_delivery', '$fb_id')");
			$result = $query->execute();

			if(!$result) {
				die('Error inserting new record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
			}
	}

	renderHead('Объявление');

?>

<main>
	
	<?php 

		include_once 'templates/header/header.php';
		include_once 'templates/controls/controls.php'; 

	?>
		<?php if ($_GET['type'] == 'found') { ?>
				<h4 class="text-center" style="margin: 40px 0;">Итак, вы что-то нашли. Чтобы быстрее вернуть это владельцу, пожалуйста заполните форму ниже: </h4>
		<?php } else { ?>
				<h4 class="text-center" style="margin: 40px 0;">Итак, вы что-то потеряли. Чтобы быстрее это найти, пожалуйста заполните форму ниже: </h4>
		<?php } ?>
	
		<div class="container">

			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<form action="add.php" method="POST" autocomplete="off" class="form form_add form-horizontal" accept-charset="UTF-8" enctype="multipart/form-data" validate="true" id="form_add">

						<?php 
							if (isset($_GET['type'])) {
						?>
							<input type="hidden" name="type" value="<?php echo $_GET['type']; ?>" />
						<?php
							}
						?>
	
						<div class="form-group">

							<label class="col-sm-4 control-label" for="item">Предмет</label>

							<div class="col-sm-8">
							
								<select class="form-control" name="item" id="item" >
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
								<input type="text" name="user_item" id="user_item" class="form-control" placeholder="название предмета" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="description">Дополнительная информация:</label>
							<div class="col-sm-8">
								<input type="text" name="description" id="description" class="form-control" placeholder="введите всю информацию" required />
							</div>
						</div>

						<div class="form-group reward">
							<label class="col-sm-4 control-label" for="reward">
								<?php if ($_GET['type'] == 'found') { ?>
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
								<input type="text" name="reward" id="reward" class="form-control" placeholder="введите сумму в грн." value="0" />
								<strong class="reward__prefix">грн.</strong>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="phone">Телефон:</label>
							<div class="col-sm-8">
								<strong class="phone_prefix">+38</strong>
								<input type="text" name="phone" id="phone" class="form-control" placeholder="номер телефона" maxlength="10" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="mail">E-mail:</label>
							<div class="col-sm-8">
								<input type="text" name="mail" id="mail" class="form-control" placeholder="электронная почта" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="meta">Ключевые слова:</label>
							<div class="col-sm-8">
								<input type="text" name="meta" id="meta" class="form-control" placeholder="разделенные запятыми" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								Поставьте маркер на место <?php if ($_GET['type'] == 'found') { ?> находки <?php } else { ?> пропажи <?php } ?> : 
								
								<button class="btn btn-mini btn-primary open-popup">Открыть карту</button>

							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<input type="hidden" name="coordinates" value="<?php echo $_SESSION['coordinates']; ?>" id="coordinates" />
								<p id="gmap-address"></p>
							</div>
						</div>

						<label>
							<span>Добавьте изображение:</span>
							<input type='file' id="addUploadFile" name="fileToUpload" />
							<img id="addUploadFilePreview" src="." alt="advert image" />
						</label>

						<label for="mail_delivery">
							<input type="checkbox" name="mail_delivery" id="mail_delivery" checked />
							<span style="width:70%">Хотите получать первыми обьявления о похожих находках/пропажах :</span>
						</label>

						<div class="g-recaptcha" 
							 data-sitekey="6LetcxwTAAAAADqMNJtSZ1H_YEUZrmK-ygQofI4t"
							 data-theme="light"></div>

						<p class="text-center">
							<button type="submit" class="btn btn-primary" />Добавить!</button>
						</p>
					</form>
				</div>
				<div class="col-md-3"></div>
			</div>

		</div>
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
			<span class="popup__close"></span>
		</div>
	</div>
	
	<script type="text/javascript" src="js/global/app.min.js"></script>
	<script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
	<script type="text/javascript" src="js/modules/upload.js"></script>
	<script type="text/javascript" src="js/modules/getcoordinates.js"></script>
</body>
</html>