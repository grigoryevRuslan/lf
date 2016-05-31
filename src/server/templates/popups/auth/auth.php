
<div ng-controller="authController">
	
	<div class="popup__header">{{head}}</div>
	
	<form 
		class="form form_signin ajax" 
		method="post"
		action="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ajax/authentication.php" 
		id="formLogin"
		name="loginForm"
		ng-init="login = true;head = 'Вход'"
		ng-show="login == true">

		<div class="form__error alert alert-danger"></div>

		<input name="username" type="email" class="form-control" placeholder="почта" autofocus ng-model="email" required />

		<input name="password" type="password" class="form-control" placeholder="пароль" required />
		
		<label class="checkbox">
			<input name="remember-me" type="checkbox" value="remember-me" checked>Запомнить меня
		</label>
		
		<input type="hidden" name="act" value="login">
		
		<button class="btn btn-primary" type="submit" ng-disabled="!loginForm.$valid">Войти</button>

		<div class="row">
			<div class="col-md-6">
				<a class="btn btn-primary" href="http://<?php echo $GLOBALS['domain']; ?>/app/facebook.php?from_uri=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">Войти через facebook</a>
			</div>
			<div class="col-md-6">
				<a class="btn btn-primary" href="http://<?php echo $GLOBALS['domain']; ?>/app/vk.php?from_uri=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">Войти через vkontakte</a>
				
			</div>
		</div>

		<div class="alert alert-info" style="margin-top:15px;">
			<p>Ещё нет аккаунта? <a href="#"  id="register-btn" ng-click="moveToRegister();head='Регистрация'">Зарегистрируйтесь.</a>
		</div>
	</form>

	<form 
		class="form form_signin ajax" 
		method="post"
		action="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ajax/authentication.php" 
		id="formRegister"
		name="registerForm"
		ng-init="enter = false;"
		ng-show="enter == true">

		<div class="form__error alert alert-danger"></div>

		<input name="username" type="email" ng-model="emailNew" class="form-control" placeholder="почта" autofocus required />
		
		<input name="password1" type="password" class="form-control" placeholder="пароль" required />

		<input name="password2" type="password" class="form-control" placeholder="подтвердите пароль" required />

		<input type="hidden" name="act" value="register">

		<label for="privacy" class="privacy">
			<input 
				type="checkbox"
				id="privacy"
				ng-model="privacy"
				ng-init="privacy = true"
				checked="true" />
			Регистрируясь, вы автоматически соглашаетесь с условиями <a href="content/privacy.php">политики конфеденциальности</a> данного ресурса.
		</label>

		<div class="g-recaptcha" 
			 vc-recaptcha
			 key="'6LetcxwTAAAAADqMNJtSZ1H_YEUZrmK-ygQofI4t'"
			 theme="'light'"
			 on-success="setResponse(response)"
			 on-expire="cbExpiration()"></div>
 		
		<button 
			class="btn btn-primary" 
			type="submit"
			ng-disabled="!privacy || !registerForm.$valid || !submitted">Зарегистрироваться</button>


		<div class="alert alert-info" style="margin-top:15px;">
			<p>Уже есть аккаунт? <a href="#"  id="login-btn" ng-click="login = true;enter = false;;head='Вход'">Войти.</a>
		</div>
	</form>
</div>
