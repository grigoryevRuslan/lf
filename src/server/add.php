<?php
	include_once 'globals/common.php';
	include_once 'functions/functions.php';

	if (!empty($_POST)) {

			if (!session_start()) die('Sessions does not work');

			include_once 'globals/db/db.php';
			include_once 'app/save_image.php';

			if (isset ($_POST['mail_delivery']) && $_POST['mail_delivery'] == 'on') {
				$mail_delivery = 1;
			} else {
				$mail_delivery = 0;
			}
			
			if (isset($_POST['item']) && $_POST['item'] != 'default') {
				$item = mysqli_real_escape_string($connection, $_POST['item']);
				$user_item = '';
			} else {
				if (isset($_POST['user_item'])) {
					$user_item = mysqli_real_escape_string($connection, $_POST['user_item']);
					$item = '';
				}
			}

			$description = mysqli_real_escape_string($connection, $_POST['description']);
			$reward = $_POST['reward'];
			$type = $_POST['type'];
			$phone = mysqli_real_escape_string($connection, $_POST['phone']);
			$mail = mysqli_real_escape_string($connection, $_POST['mail']);
			$meta = mysqli_real_escape_string($connection, $_POST['meta']);
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

			mysqli_query($connection,"SET NAMES 'utf8'"); 
			mysqli_query($connection,"SET CHARACTER SET 'utf8'");
			mysqli_query($connection,"SET SESSION collation_connection = 'utf8_general_ci'");
			$query = "INSERT INTO items (item, user_item, description, coordinates, reward, type, phone, mail, meta, image_uri, date_publish, mail_delivery, user_id) VALUES ('$item', '$user_item', '$description', '$coordinates', '$reward', '$type', '$phone', '$mail', '$meta', '$fileUrl', '$mysqltime', '$mail_delivery', '$fb_id')";

			if(!$connection->multi_query($query)) {
				die('Error inserting new record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
			} else {
				#too much long sending :(
				#sendAdvert($description);
				header("Location: index.php");
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
					<form action="add.php" method="POST" autocomplete="off" class="form form_add form-horizontal" accept-charset="UTF-8" enctype="multipart/form-data" validate="true">

						<?php 
							if (isset($_GET['type'])) {
						?>
							<input type="hidden" name="type" value="<?php echo $_GET['type']; ?>" />
						<?php
							}
						?>
	
						<div class="form-group">
							<label class="col-sm-2 control-label" for="item">Предмет</label>
							<div class="col-sm-10">
							
								<select class="form-control" name="item" id="item" >
									<option value="default" selected>Выберите предмет из списка</option>
									<option value="Паспорт">Паспорт</option>
									<option value="Доверенность">Доверенность</option>
									<option value="Лицензия">Лицензия</option>
									<option value="Водительские">Водительские права</option>
								</select>
								
							</div>
						</div>

						<label>
							<span>Или введите своё:</span>
							<input type="text" name="user_item" placeholder="название предмета" />
						</label>

						<label>
							<span>Дополнительная <br /> информация:</span>
							<textarea name="description" cols="7" rows="7" placeholder="введите всю информацию" required></textarea>
						</label>

						<label>
							<?php if ($_GET['type'] == 'found') { ?>
								<span>
										Вознаграждение
								</span>
							<?php } else { ?>
								<span>
										Сколько заплатите ?
								</span>
							<?php } ?>
							<input type="text" name="reward" placeholder="введите сумму в грн." value="0" />
							<strong style="margin-left:10px;">грн.</strong>
						</label>

						<label>
							<span>Телефон:</span>
							<span>
								<strong style="margin: 0 5px 0 -30px;">+38</strong>
								<input type="text" name="phone" placeholder="номер телефона" maxlength="10"></span>
						</label>

						<label>
							<span>E-mail:</span>
							<input type="text" name="mail" placeholder="электронная почта" />
						</label>

						<label>
							<span>Ключевые слова:</span>
							<input type="text" name="meta" placeholder="разделенные запятыми" />
						</label>

						<label class="gmap-label">
							<span>Поставьте маркер на<br /> место 
								<?php if ($_GET['type'] == 'found') { ?> находки <?php } else { ?> пропажи <?php } ?> :</span>
							<button class="btn btn-mini btn-primary add_coords">Открыть карту</button>
							<input type="hidden" name="coordinates" value="<?php echo $_SESSION['coordinates']; ?>" id="coordinates" />
							<p id="gmap-address"></p>
						</label>

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

						<p class="center">
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
	<!--rewrite template through search input box-->
	<div class="popup popup_gmap">
		<div class="popup__container">
			<input id="pac-input" class="controls" type="text" placeholder="Search Box" />
			<div id="mapCanvas"></div>
		</div>
		<span class="popup__close">Close[X]</span>
	</div>


	<script type="text/javascript" src="js/global/app.min.js"></script>
	<script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
	<script type="text/javascript" src="js/modules/g_search_box.js"></script>
	<script type="text/javascript" src="js/modules/upload.js"></script>
	<script type="text/javascript" src="js/modules/getcoordinates.js"></script>
</body>
</html>