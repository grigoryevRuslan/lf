<?php
	if (!session_start()) die('Sessions does not work');

	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';

	renderHead('Добавление объявления', ''.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'Добавление объявления');

?>

<main>
	
	<?php 

		include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php';
		include_once $_SERVER['DOCUMENT_ROOT'].'/templates/controls/controls.php';

	?>
	
		<div class="container" ng-controller="addAdvertController">

			<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/steps/form.php'; ?>

			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<?php if (!$GLOBALS['isAuthorised']) { ?>

						<div class="row">
							<div class="col-md-12 text-center">
								<p>
									<strong>Перед заполнением формы <a href="#" class="open-popup" data-type="auth">авторизуйтесь</a> на сайте.</strong>
								</p>
							</div>
						</div>

					<?php } ?>


					<form 
						action="complete.php" 
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
						
						<div class="form-step">

							<div class="form-step__badge" ng-init="fStep.toggle = true">
								Шаг-1
							</div>

							<div ng-class="{true : 'toggle toggle_up', false :'toggle toggle_down'}[fStep.toggle]" ng-click="fStep.toggle = !fStep.toggle">
								{{fStep.toggle ? 'Свернуть' : 'Развернуть'}}
							</div>

							<div class="form-step__wrapper" ng-show="fStep.toggle">

								<div class="form-group">

									<div class="col-md-7">
									
										<select class="form-control"
												name="item"
												id="item"
												ng-model="sSubject"
									 		    ng-change="iSubject = ''"
												ng-options="code as code.name for code in codes track by code.name">
												<option value="">Выберите из списка ниже:</option>
										</select>
										
									</div>

									<label class="col-md-5 control-label" for="item">
										На первом шаге неоходимо указать <br />найденный Вами предмет.
									</label>
								</div>

								<div class="form-group"
									 ng-show="sSubject != '' && sSubject != null && sSubject.id != 1000">
									
									<div class="col-md-7">
									
										<input type="text" 
											   class="form-control"
											   name="secret"
											   id="secret"
											   ng-model="secret"
											   maxlength="100" 
											   placeholder="Пример: {{sSubject.example}}" />

									</div>	

									<label for="secret" class="col-md-5 control-label">
										Секретный код
										<div class="g-info">
											<div class="g-info__tooltip">{{sSubject.description}}</div>
										</div>
									</label>

								</div>

								<div class="form-group" ng-show="sSubject.id == 1000">
									<div class="col-md-7">
										<input 
											type="text" 
											name="user_item" 
											id="user_item" 
											class="form-control" 
											placeholder="название..."
											ng-model="iSubject"
											ng-required="sSubject.id == 1000" />
									</div>

									<label class="col-md-5 control-label" for="user_item">Или введите своё</label>
								</div>

								<div class="form-group">
									<div class="col-md-7 datepicker-wrapper">
										<input 
											type="text" 
											id="datepicker" 
											name="date" 
											class="form-control"
											data-default="12-05-2016" />
									</div>

									<label class="col-md-5 control-label">Дата <?php if ($_GET['type'] == 'found') { ?> находки <?php } else { ?> пропажи <?php } ?></label>
								</div>

								<div class="form-group">
									<div class="col-md-7">
										<textarea 
											ng-model="description"
											ng-init="description = ''"
											name="description" 
											id="description" 
											maxlength="300" 
											class="form-control" 
											placeholder="введите всю информацию"
											required ></textarea>
									</div>

									<label class="col-md-5 control-label" for="description">Дополнительная информация:</label>
								</div>
								
							</div>

						</div>

						<div class="form-step">

							<div class="form-step__badge" ng-init="fStep.toggle2 = true">
								Шаг-2
							</div>

							<div ng-class="{true : 'toggle toggle_up', false :'toggle toggle_down'}[fStep.toggle2]" ng-click="fStep.toggle2 = !fStep.toggle2">
								{{fStep.toggle2 ? 'Свернуть' : 'Развернуть'}}
							</div>

							<div class="form-step__wrapper" ng-show="fStep.toggle2">

								<div class="form-group reward">
									<div class="col-md-5" ng-init="reward = 0">
										<div range-slider min="0" max="10000" model-max="reward" pin-handle="min"></div>
									</div>
									<div class="col-md-2 text-center" style="margin: 9px 0 0 0;">
										{{reward == 0 ? '+ в карму' : reward + ' грн'}}.
									</div>

									<label class="col-md-5 control-label" for="reward">
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
								</div>

								<div class="form-group">
									<div class="col-md-7">
										<input 
											type="text" 
											name="phone" 
											id="phone" 
											ng-model="phone"
											ng-init="phone = ''"
											class="form-control" 
											placeholder="(___) ___-__-__"
											ui-mask="(999) 999-99-99"
											ui-mask-placeholder
											ui-mask-placeholder-char="_" />
									</div>

									<label class="col-md-5 control-label" for="phone">Телефон:</label>
								</div>

								<div class="form-group">
									<div class="col-md-7">
										<input 
											type="email" 
											name="mail" 
											id="mail" 
											class="form-control" 
											placeholder="электронная почта"
											ng-model="mail"
											ng-init="mail = ''"
											required />
									</div>

									<label class="col-md-5 control-label" for="mail">E-mail:</label>
								</div>

							</div>

						</div>

						<div class="form-step">

							<div class="form-step__badge" ng-init="fStep.toggle3 = true">
								Шаг-3
							</div>

							<div ng-class="{true : 'toggle toggle_up', false :'toggle toggle_down'}[fStep.toggle3]" ng-click="fStep.toggle3 = !fStep.toggle3">
								{{fStep.toggle3 ? 'Свернуть' : 'Развернуть'}}
							</div>

							<div class="form-step__wrapper" ng-show="fStep.toggle3">
								<div class="form-group">
									<div class="col-md-7">
										<tags-input 
											ng-model="tags"
											max-tags="10"
											placeholder="После ввода - Enter">
										</tags-input>
									</div>

									<label class="col-md-5 control-label" for="meta">Ключевые слова:</label>
								</div>

								<div class="form-group">

									<div class="col-md-3">
										<a class="btn-geo btn-geo_green open-popup btn-map" data-type="map">Открыть карту</a>
									</div>
									<div class="col-md-9" style="padding-top: 5px;">
										<div class="row">
											<div class="col-md-10">
												<input type="hidden" name="coordinates" id="coordinates" />
												<p id="gmap-address"></p>
											</div>

											<div class="col-md-2">
												<span id="clearAddress">&times;</span>
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">

									<div class="col-md-7">
										<label class="btn btn-default btn-upload">
											<span>Загрузить фото</span>
											<input type="file" 
												id="addUploadFile" 
												name="fileToUpload"
												onchange="angular.element(this).scope().setFile(this)" 
												accept="image/*">
										</label>
										
										<div class="row">
											<div class="col-md-12">
												<img id="addUploadFilePreview" 
													ng-show="imageSource" 
													ng-src="{{imageSource}}" 
													alt="advert image" />
											</div>
										</div>
									</div>

									<label class="col-md-5 control-label">
										Изображение <br />(не более 10 Мб)
									</label>
								</div>

								<div class="form-group">
									<div class="col-md-7">
										<div class="g-recaptcha" 
										     vc-recaptcha
											 key="'6LetcxwTAAAAADqMNJtSZ1H_YEUZrmK-ygQofI4t'"
											 theme="'light'"
											 on-success="setResponse(response)"
											 on-expire="cbExpiration()"></div>
									</div>

									<label for="mail_delivery" class="col-md-4 control-label">
										<input type="checkbox" name="mail_delivery" id="mail_delivery" checked />
										<span style="width:70%">Хотите получать первыми обьявления о похожих находках/пропажах :</span>
									</label>
								</div>
							</div>

						</div>
							
						<?php if ($GLOBALS['isAuthorised']) { ?>

							<p class="text-center">
								<button 
									type="submit" 
									class="btn btn-success"
									ng-disabled="!submitted || !description || description == '' || ((sSubject.id == '' || sSubject == '' || sSubject == null || sSubject.id == 1000) && iSubject == '') || !mail || !form.$valid" />Добавить!</button>
							</p>

						<?php } ?>
					</form>
				</div>
				<div class="col-md-2"></div>
			</div>

		</div>
	</main>

	<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/footer.php'; ?>
		
	<?php 
		renderPopup('feedback'); 
		renderPopup('map');
		renderPopup('auth');
	?>
	
	<script type="text/javascript" src="js/global/app.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&amp;render=explicit" async defer
	></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>
	<script type="text/javascript" src="js/modules/getcoordinates.js"></script>
</body>
</html>