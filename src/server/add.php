<?php
	if (!session_start()) die('Sessions does not work');

	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';

	if (!empty($_POST)) {

			include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
			include_once $_SERVER['DOCUMENT_ROOT'].'/app/save_image.php';

			if (isset ($_POST['mail_delivery']) && $_POST['mail_delivery'] == 'on') {
				$mail_delivery = 1;
			} else {
				$mail_delivery = 0;
			}

			if (isset($_POST['user_item']) && $_POST['user_item'] != '') {
				$user_item = $_POST['user_item'];
				$item = '';
			} else {
				$item = $_POST['item'];
				$user_item = '';
			}

			$description = $_POST['description'];
			$type = $_POST['type'];
			$phone = $_POST['phone'];
			$mail = $_POST['mail'];
			$meta = $_POST['meta'];
			$fb_id = $_SESSION['user_id'];

			if (isset($_POST['reward'])) {
				$reward = $_POST['reward'];
			} else {
				$reward = 0;
			}

			if (isset($_POST['coordinates'])) {
				$coordinates = $_POST['coordinates'];
			} else {
				$coordinates = '';
			}

			if (isset($_POST['date'])) {
				$item_date = date_format(date_create_from_format('d-m-Y', $_POST['date']), 'Y-m-d H:i:s');
			} else {
				$item_date = date("Y-m-d H:i:s");
			}

			$mysqltime = date("Y-m-d H:i:s");

			if (isset($newfilename)) {
				$fileUrl = $newfilename;
			} else {
				$fileUrl = 'no-image-available.png';
			}

			if (isset($_POST['secret'])) {
				$secret = $_POST['secret'];
			}

			if (isset($_POST['action'])) {
				if ($_POST['action'] == 'add') {
					$query = $pdoConnection->prepare("INSERT INTO items (item, user_item, description, coordinates, reward, type, phone, mail, meta, image_uri, date_publish, item_date, mail_delivery, user_id, item_secret) VALUES ('$item', '$user_item', '$description', '$coordinates', '$reward', '$type', '$phone', '$mail', '$meta', '$fileUrl', '$mysqltime', '$item_date', '$mail_delivery', '$fb_id', '$secret')");
				} else {
					if ($_POST['action'] == 'edit' && isset($_POST['edit_id'])) {
						$edit_id = $_POST['edit_id'];
						$query = $pdoConnection->prepare("UPDATE items SET item = '$item', user_item = '$user_item', description = '$description', coordinates = '$coordinates', reward = '$reward', type = '$type', phone = '$phone', mail = '$mail', meta = '$meta', image_uri = '$fileUrl', date_publish = '$mysqltime', item_date = '$item_date', mail_delivery = '$mail_delivery', item_secret = '$secret' WHERE id = '$edit_id'");
					}
				}
			}
			
			$result = $query->execute();

			if(!$result) {
				die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
			}
	}

	renderHead('Добавление объявления', 'http://'.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'Добавление объявления бюро находок');

?>

<main>
	
	<?php 

		include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php';

	?>
		<?php if ($_GET['type'] == 'found') { ?>
				<h4 class="text-center" style="margin: 40px 0;">Итак, вы что-то нашли. Чтобы быстрее вернуть это владельцу, пожалуйста заполните форму ниже: </h4>
		<?php } else { ?>
				<h4 class="text-center" style="margin: 40px 0;">Итак, вы что-то потеряли. Чтобы быстрее это найти, пожалуйста заполните форму ниже: </h4>
		<?php } ?>
	
		<div class="container" ng-controller="addAdvertController">

			<div class="row steps_wrapper">
				
				<div class="col-md-3"></div>

				<div class="col-md-6 steps">

					<div class="col-xs-3 text-center">
						<span class="step" 
							  ng-class="((iSubject != '' || sSubject != '') && sSubject != null && (sSubject.id != 1000 || iSubject != '')) ? 'step_check' : ''"></span>
					</div>

					<div class="col-xs-3 text-center">
						<div class="step"
							 ng-class="(description && description != '') ? 'step_check' : ''"></div>
					</div>

					<div class="col-xs-3 text-center">
						<div class="step"
							 ng-class="(phone || mail) ? 'step_check' : ''"></div>
					</div>

					<div class="col-xs-3 text-center">
						<div class="step"
							 ng-class="submitted ? 'step_check' : ''"></div>
					</div>

				</div>

				<div class="col-md-3"></div>
			
			</div>

			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<form 
						action="add.php" 
						name="form" 
						method="POST" 
						autocomplete="off" 
						class="form form_add form-horizontal form_<?php echo $_GET['type']; ?>" 
						accept-charset="UTF-8" 
						enctype="multipart/form-data" 
						validate="true" 
						id="form_add">

						<input type="hidden" name="action" value="add" />

						<input type="hidden" name="meta" value="{{meta}}" />

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
							
								<select class="form-control"
										name="item"
										id="item"
										ng-model="sSubject"
										ng-init="sSubject = ''"
										ng-change="iSubject = ''"
										ng-options="code as code.name for code in codes track by code.name">
										<option value="">Выберите из списка ниже:</option>
								</select>
								
							</div>
						</div>

						<div class="form-group"
							 ng-show="sSubject != '' && sSubject != null && sSubject.id != 1000">
								
							<label for="secret" class="col-sm-4 control-label">
								Секретный код
								<div class="g-info">
									<div class="g-info__tooltip">{{sSubject.description}}</div>
								</div>
							</label>
							
							<div class="col-sm-8">
							
								<input type="text" 
									   class="form-control"
									   name="secret"
									   id="secret"
									   ng-model="secret"
									   maxlength="100" 
									   placeholder="Пример: {{sSubject.example}}" />

							</div>	

						</div>

						<div class="form-group" ng-show="sSubject.id == 1000">
							<label class="col-sm-4 control-label" for="user_item">Или введите своё:</label>
							<div class="col-sm-8">
								<input 
									type="text" 
									name="user_item" 
									id="user_item" 
									class="form-control" 
									placeholder="название предмета"
									ng-model="iSubject"
									ng-init="iSubject = ''" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">Дата <?php if ($_GET['type'] == 'found') { ?> находки <?php } else { ?> пропажи <?php } ?></label>
							<div class="col-sm-8 datepicker-wrapper">
								<input 
									type="text" 
									id="datepicker" 
									name="date" 
									class="form-control"
									data-default="12-05-2016" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="description">Дополнительная информация:</label>
							<div class="col-sm-8">
								<textarea 
									ng-model="description"
									ng-init="description = ''"
									name="description" 
									id="description" 
									maxlength="300" 
									class="form-control" 
									placeholder="введите всю информацию"
									required></textarea>
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
								<input 
									type="text" 
									name="reward" 
									id="reward" 
									class="form-control" 
									placeholder="введите сумму в грн."
									ng-model="reward" 
									maxlength="6" 
									value="0"
									numeric-only />
								<strong class="reward__prefix">грн.</strong>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="phone">Телефон:</label>
							<div class="col-sm-8">
								<strong class="phone_prefix">+3</strong>
								<input 
									type="text" 
									name="phone" 
									id="phone" 
									class="form-control" 
									placeholder="номер телефона" 
									maxlength="10"
									minlength="10" 
									ng-model="phone"
									numeric-only />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="mail">E-mail:</label>
							<div class="col-sm-8">
								<span 
									class="form-error"
									ng-show="!form.mail.$valid">Неверный формат почты</span>
								<input 
									type="email" 
									name="mail" 
									id="mail" 
									class="form-control" 
									placeholder="электронная почта"
									ng-model="mail" />
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
								Поставьте маркер на место <?php if ($_GET['type'] == 'found') { ?> находки <?php } else { ?> пропажи <?php } ?> : 
								
								<button class="btn btn-mini btn-primary open-popup">Открыть карту</button>

							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-8">
								<input type="hidden" name="coordinates" id="coordinates" />
								<p id="gmap-address"></p>
							</div>

							<div class="col-sm-2">
								<span id="clearAddress">&times;</span>
							</div>
						</div>

						<label>
							<span>Добавьте изображение (размером не более 10 Мб):</span>
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
								ng-disabled="!submitted || !description || description == '' || ((sSubject.id == '' || sSubject == '' || sSubject == null || sSubject.id == 1000) && iSubject == '') || (!phone && !mail) || !form.$valid" />Добавить!</button>
						</p>
					</form>
				</div>
				<div class="col-md-3"></div>
			</div>

		</div>
	</main>

	<footer class="text-center">
	
		<?php 

			include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/social.php';
	
			include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/info.php';
	
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
</body>
</html>