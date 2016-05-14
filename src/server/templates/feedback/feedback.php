<form 
	method="POST" 
	class="form form_feedback"
	action='/' 
	name="form_feedback"
	ng-controller="feedbackController"
	validate="true">
	
	<h2>Оставьте ваш вопрос здесь:</h2>
	
	<input 
		class="form-control"
		type="text"
		placeholder="Введите ваше имя"
		required="true"
		ng-model="name"
		maxlength="20" />

	<input 
		class="form-control"
		type="email"
		placeholder="Введите ваш e-mail" 
		ng-model="email"
		required="true" />

	<textarea 
		class="form-control"
		ng-model="text"
		placeholder="Введите ваше обращение" 
		required="true"
		maxlength="250"></textarea>

	<button 
		type="submit"
		class="btn btn-primary"
		ng-click="sendFeedback($event)"
		ng-disabled="isSending || !form_feedback.$valid">Отправить</button>

	<span 
		class="feedback__preloader"
		ng-show="response.sending">
			<img src="../img/gif/preloader.gif" alt="preloader" />
		</span>

	<span 
		class="feedback__success"
		ng-show="response.success != ''">{{response.success}}</span>
	<span 
		class="feedback__error"
		ng-show="response.error != ''">{{response.error}}</span>

</form>