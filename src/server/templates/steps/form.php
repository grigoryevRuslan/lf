<div class="row steps_main steps_form">
	<div class="col-md-3 col-xs-12 item" 
		 ng-init="iSubject = ''"
		 ng-class="!!iSubject || (sSubject != '' && sSubject != null && sSubject.id != 1000) ? 'step_check' : ''">
		<div class="visual"></div>
		<p>Выберите из выпадающего списка или другое.</p>
	</div>
	<div class="col-md-3 col-xs-12 item"
		 ng-init="sSubject = ''"
		 ng-class="(description && description != '') ? 'step_check' : ''">
		<div class="visual"></div>
		<p>Опишите предмет в поле "Дополнительная информация".</p>
	</div>
	<div class="col-md-3 col-xs-12 item"
		 ng-class="(mail != '' &&mail) ? 'step_check' : ''">
		<div class="visual"></div>
		<p>Ваши контактные данные будут видны только в случае успешной идентификации вас как владельца.</p>
	</div>
	<div class="col-md-3 col-xs-12 item"
		 ng-class="submitted ? 'step_check' : ''">
		<div class="visual"></div>
		<p>Отправьте форму и ожидайте проверки модератором.</p>
	</div>
</div>
