<div ng-controller="authController">
	
	<form 
		class="form form_signin ajax" 
		method="post"
		action="ajax/authentication.php" 
		id="formLogin"
		ng-init="login = true"
		ng-show="login == true">

		<div class="form__error alert alert-danger"></div>

		<input name="username" type="text" class="form-control" placeholder="логин" autofocus>
		
		<input name="password" type="password" class="form-control" placeholder="пароль">
		
		<label class="checkbox">
			<input name="remember-me" type="checkbox" value="remember-me" checked>Запомнить меня
		</label>
		
		<input type="hidden" name="act" value="login">
		
		<button class="btn btn-primary" type="submit">Войти</button>

		<div class="alert alert-info" style="margin-top:15px;">
			<p>Ещё нет аккаунта? <a href="#"  id="register-btn" ng-click="login = false;enter = true;">Зарегистрируйтесь.</a>
		</div>
	</form>

	<form 
		class="form form_signin ajax" 
		method="post" 
		action="ajax/authentication.php" 
		id="formRegister"
		ng-init="enter = false"
		ng-show="enter == true">

		<div class="form__error alert alert-danger"></div>

		<input name="username" type="text" class="form-control" placeholder="логин" autofocus>

		<input name="password1" type="password" class="form-control" placeholder="пароль">

		<input name="password2" type="password" class="form-control" placeholder="подтвердите пароль">

		<input type="hidden" name="act" value="register">

		<button class="btn btn-primary" type="submit">Регистрация</button>


		<div class="alert alert-info" style="margin-top:15px;">
			<p>Уже есть аккаунт? <a href="#"  id="login-btn" ng-click="login = true;enter = false;">Войти.</a>
		</div>
	</form>
</div>
