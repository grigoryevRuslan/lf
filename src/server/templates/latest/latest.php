<div class="container latest" ng-controller="latestController">
	<div class="row">
		<div class="col-md-12 text-right">
			
			<p ng-show="latest[0]">
				<span style="color: red;">Новое!&nbsp;&nbsp;</span>
				<strong>Опубликовано:</strong> {{latest[0].date_publish}}&nbsp;&nbsp;
				<span ng-show="latest[0].type == 'lost'"><strong>Потеря:</strong>&nbsp;&nbsp;</span>
				<span ng-show="latest[0].type == 'found'"><strong>Находка:</strong>&nbsp;&nbsp;</span>
				<a href="/advert.php?id={{latest[0].id}}">{{latest[0].item || latest[0].user_item}}</a>&nbsp;&nbsp;
				<span ng-show="latest[0].reward != '' && latest[0].reward != '0'"><strong>Вознаграждение: </strong> {{latest[0].reward}} грн.</span>
			</p>

		</div>
	</div>
</div>