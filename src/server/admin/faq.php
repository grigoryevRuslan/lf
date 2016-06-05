<?php 
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';

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

	<div class="container faqs"
		 ng-controller="faqController"
		 ng-init="faq = {};faq.sending = false;faq.latest = [];">
			
		<h1 class="text-center">ЧАВО</h1>

		<div class="row">
			<div class="col-md-7">
				<h4 class="text-center"><strong>Текущие</strong></h4>
				<ol class="results">
					<li ng-repeat="f in faq.latest" 
						ng-show="faq.latest" 
						class="col-md-12">
						<p>
							<strong>Вопрос: </strong>
							{{f.question}}
						</p>
						<p>
							<strong>Ответ: </strong>
							{{f.answer}}
						</p>
						<p>
							<button class="btn btn-primary btn-xs"
									ng-click="edit(f.id)">Редактировать</button>
						</p>
					</li>
				</ol>
			</div>

			<div class="col-md-5">
			
				<span 
					class="faq__response"
					ng-show="(faq.success || faq.error) && faq.showresponse">{{faq.success || faq.error}}</span>
					
				<div class="row">
					<div class="col-md-12 text-center">
						<h4><strong>Добавить новые</strong></h4>
					</div>
					<div class="row">
						<div class="col-md-12">
							<textarea 
								name="question"
								ng-model="faq.question"
								placeholder="Тут ввести вопрос..."
								class="form-control"
								rows="8"></textarea>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-12">
							<textarea 
								name="answer"
								ng-model="faq.answer"
								placeholder="Тут ввести ответ..."
								class="form-control"
								rows="8"></textarea>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-12 text-center">
							<button 
								class="btn btn-primary btn-success btn-l"
								ng-disabled="!faq.answer || !faq.question || faq.sending"
								ng-click="save(faq)">Сохранить</button>
							<button 
								class="btn btn-primary btn-danger btn-l"
								ng-show="faq.answer || faq.question"
								ng-click="clear()">Очистить</button>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<script type="text/javascript" src="../js/global/app.min.js"></script>
	<script type="text/javascript" src="js/app/app.js"></script>
	<script type="text/javascript" src="js/app/controllers/faqController.js"></script>
	<script type="text/javascript" src="js/app/factories/getFaqFactory.js"></script>

</body>
</html>