<?php 
	
	if (!session_start()) die('Sessions does not work');
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';

	if (isset($_SESSION['user_id'])) { 
		$user_id = $_SESSION['user_id'];
	} else {
		die('Error!');
	}

	$requestToMeQuery = "
		SELECT 
			a.item, a.user_item, a.item_secret, a.phone, a.mail, b.id, b.advert_id, b.user_id, b.advert_type, b.request, b.status
		FROM 
			items a, request b 
		WHERE 
			a.user_id = '$user_id' 
		AND 
			a.is_published = 1 
		AND 
			b.advert_id = a.id 
		AND 
			b.user_id != '$user_id'
	";

	$requestToMe = $pdoConnection->prepare($requestToMeQuery);
	$requestToMe->execute();
	$resultRequestToMe = $requestToMe->fetchAll(PDO::FETCH_ASSOC);

	$myRequestQuery = "
		SELECT 
			*
		FROM 
			items i
		INNER JOIN 
			request r
		ON 
			i.id = r.advert_id
		WHERE 
			i.is_published = 1
		AND 
			r.user_id = '$user_id'
	";

	$myRequests = $pdoConnection->prepare($myRequestQuery);
	$myRequests->execute();
	$resultMyRequests = $myRequests->fetchAll(PDO::FETCH_ASSOC);

	renderHead('Ответы на объявления', 'http://'.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'Ответы на объявления');
?>

	<main>
		
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php'; ?>

		<?php if ($resultRequestToMe) { ?>
		
			<h1 class="text-center">Заявки на ваши обьявления.</h1>

			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<table 
							class="table table-striped table-bordered request" 
							ng-controller="requestController"
							ng-init="response = {};reqs = {};">

							<thead>
								<th>Объявление</th>
								<th>Секретное поле пользователя</th>
								<th>Ваше секретное поле</th>
								<th>Состояние</th>
								<th class="cell-s" colspan="2">Ваши действия</th>
							</thead>

							<tbody>
								<?php foreach ($resultRequestToMe as $r) { ?>
									<tr 
										class="request__item"
										ng-init="reqs[<?php echo $r['id']; ?>] = {isAction: false}">
										<td>
											<a href="/advert.php?id=<?php echo $r['advert_id']; ?>">
												<?php if (isset($r['item']) && $r['item'] != '') {echo $r['item'];} else {echo $r['user_item'];} ?>
											</a>
										</td>

										<td>
											<p>
												<?php echo $r['request']; ?>
											</p>
										</td>

										<td>
											<p>
												
												<?php if (isset($r['item_secret']) && $r['item_secret'] != '') {

													echo $r['item_secret'];

												} else {

													echo 'Вы не указывали код в объявлении.';

												}?>

											</p>
										</td>

										<td>
											<p class="item-status_<?php echo $r['status']; ?>">
												<?php 
													switch ( $r['status'])
													{
														case 0:
															echo "Ожидает вашего ответа";
															break;

														case 1: {
																echo "<span>Вы одобрили запрос. <br />Ваши контактные данные отправлены автору объявления.</span>
																	<p>Контакты автора: </p>";
																
																if (isset($r['phone']) && $r['phone'] != '') {
																	echo "<p><strong>Телефон:</strong> +38".
																		$r['phone'].
																		"</p>";
																}

																if (isset($r['mail']) && $r['mail'] != '') {
																	echo '<p><strong>Почта:  </strong>'.
																		'<a href="mailto:'.$r['mail'].'"'.'>'.
																		$r['mail'].
																		'</a></p>';
																}

																break;
															}

														case 2:
															echo "Вы отклонили запрос, но будут и ещё заявки.";
															break;

														default:
															assert ( 0 && "internal error" );
													}
												?>
											</p>
										</td>	
										
										<?php if ($r['status'] == 0) { ?>
											
											<td>
												<button 
													class="btn btn-sm btn-success"
													ng-click="actionRequest(<?php echo $r['id']; ?>, true)"
													ng-disabled="reqs[<?php echo $r['id']; ?>].isAction">Открыть контакты</button>
											</td>

											<td>
												<button 
													class="btn btn-sm btn-danger"
													ng-click="actionRequest(<?php echo $r['id']; ?>, false)"
													ng-disabled="reqs[<?php echo $r['id']; ?>].isAction">Отклонить запрос</button>
											</td>	

										<?php } else { ?>
											
											<td colspan="2" class="cell-s">
												<p>Вы уже ответили</p>
											</td>

										<?php } ?>

									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		<?php } else { ?>
		
			<p class="text-center">К вам ещё не поступали заявки.</p>
		
		<?php } ?>

		<?php if ($resultMyRequests) { ?>

			<h1 class="text-center">Ваши заявки на объявления пользователей</h1>

			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<table 
							class="table table-striped table-bordered request" 
							ng-controller="requestController"
							ng-init="response = {};reqs = {};">

							<thead>
								<th>Объявление</th>
								<th>Секретное поле пользователя</th>
								<th>Ваше секретное поле</th>
								<th>Состояние</th>
							</thead>

							<tbody>
								<?php foreach ($resultMyRequests as $r) { ?>
									<tr 
										class="request__item"
										ng-init="reqs[<?php echo $r['id']; ?>] = {isAction: false}">
										<td>
											<a href="/advert.php?id=<?php echo $r['advert_id']; ?>">
												<?php if (isset($r['item']) && $r['item'] != '') {echo $r['item'];} else {echo $r['user_item'];} ?>
											</a>
										</td>

										<td>
											<p>
												<?php echo $r['request']; ?>
											</p>
										</td>

										<td>
											<p>
												
												<?php if (isset($r['item_secret']) && $r['item_secret'] != '') {

													echo $r['item_secret'];

												} else {

													echo 'Вы не указывали код в объявлении.';

												}?>

											</p>
										</td>

										<td>
											<p class="item-status_<?php echo $r['status']; ?>">
												<?php 
													switch ( $r['status'])
													{
														case 0:
															echo "Ожидает ответа от автора объявления";
															break;

														case 1: {
																echo "<span>Автор одобрил запрос. <br />Ваши контактные данные отправлены автору объявления.</span>
																<p>Контакты автора: </p>";
																
																if (isset($r['phone']) && $r['phone'] != '') {
																	echo "<p><strong>Телефон:</strong> +38".
																		$r['phone'].
																		"</p>";
																}

																if (isset($r['mail']) && $r['mail'] != '') {
																	echo '<p><strong>Почта:  </strong>'.
																		'<a href="mailto:'.$r['mail'].'"'.'>'.
																		$r['mail'].
																		'</a></p>';
																}

																break;
															}

														case 2:
															echo "Ваш запрос отклонен";
															break;

														default:
															assert ( 0 && "internal error" );
													}
												?>
											</p>
										</td>

									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		<?php } else { ?>
		
			<p class="text-center">Вы ещё не отправляли заявки на объявления.</p>

		<?php } ?>

	</main>


	<footer class="text-center">

		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/social.php'; ?>
		
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/info.php'; ?>

	</footer>

	<?php 
	
	    if ( !$GLOBALS['isAuthorised'] ) {
	        renderPopup('auth');
	    } else {
	        renderPopup('feedback');
	    }

	?>

	<script type="text/javascript" src="js/global/app.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&amp;render=explicit" async defer
	></script>
	<script type="text/javascript" src="js/modules/ajax-auth.js"></script>

</body>
</html>