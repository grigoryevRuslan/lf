<?php 
	if (!session_start()) die('Sessions does not work');
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
	
	if (!$GLOBALS['isAuthorised']) {header('Location: http://'.$_SERVER['HTTP_HOST'].'/');}
	
	if (isset($_SESSION['user_id'])) { 
		$user_id = $_SESSION['user_id'];
	} else {
		die('Error!');
	}

	$requestToMeQuery = "
		SELECT i.id, i.item, i.user_item, i.item_secret, r.user_id, r.id as req_id, r.request, r.status, u.username
		FROM items i
		INNER JOIN request r ON i.id = r.advert_id
		INNER JOIN users u  ON u.Fuid = r.user_id
		WHERE i.user_id = '$user_id'
		AND i.is_published = 1
		AND r.is_published != 0
		AND r.status != 2
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
		AND
			r.is_published != 0
	";

	$myRequests = $pdoConnection->prepare($myRequestQuery);
	$myRequests->execute();
	$resultMyRequests = $myRequests->fetchAll(PDO::FETCH_ASSOC);

	renderHead('Ответы на объявления', ''.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'Ответы на объявления');
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
										ng-init="reqs[<?php echo $r['req_id']; ?>] = {isAction: false}">
										<td>
											<a href="/advert.php?id=<?php echo $r['id']; ?>">
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
														case 3: {
																echo "<span>Вы одобрили запрос. <br />Ваши контактные данные отправлены автору объявления.</span>
																	<p>Контакты автора: </p>";

																if (isset($r['username']) && $r['username'] != '') {
																	echo '<p><strong>Почта:  </strong>'.
																		'<a href="mailto:'.$r['username'].'"'.'>'.
																		$r['username'].
																		'</a></p>';
																}

																break;
															}

														case 4:
															echo "Вы отклонили запрос, но будут и ещё заявки.";
															break;
													}
												?>
											</p>
										</td>	
										
										<?php if ($r['status'] == 1) { ?>
											
											<td>
												<button 
													class="btn btn-sm btn-success"
													ng-click="actionRequest(<?php echo $r['req_id']; ?>, 3)"
													ng-disabled="reqs[<?php echo $r['req_id']; ?>].isAction">Открыть контакты</button>
											</td>

											<td>
												<button 
													class="btn btn-sm btn-danger"
													ng-click="actionRequest(<?php echo $r['req_id']; ?>, 4)"
													ng-disabled="reqs[<?php echo $r['req_id']; ?>].isAction">Отклонить запрос</button>
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
												
												<?php if (isset($r['item_secret']) && $r['item_secret'] != '') {

													echo $r['item_secret'];

												} else {

													echo 'Вы не указывали код в объявлении.';

												}?>

											</p>
										</td>

										<td>
											<p>
												<?php echo $r['request']; ?>
											</p>
										</td>

										<td>
											<p class="item-status_<?php echo $r['status']; ?>">
												<?php 
													switch ( $r['status'])
													{
														case 1:
															echo "<span>Одобрено модератором. Ожидайте ответа от автора объявления.</p>";
															break;
														case 2:
															echo "Отказано модератором";
															break;

														case 3: {
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

														case 4:
															echo "Ваш запрос отклонен автором объявления.";
															break;
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

	<?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/footer.php'; ?>

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

</body>
</html>