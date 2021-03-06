<div class="container controls">
	
	<div class="row">
		
		<div class="col-xs-12 col-md-4 controls__btn">

			<a href="http://<?php echo $GLOBALS['domain']; ?>/add.php?type=found" class="btn btn-success">Добавить находку</a>

		</div>

		<div class="col-xs-12 col-md-4 text-center user__search">
				
			<form method="GET" action="search.php" id="search_form" validate="true" class="controls__search">
			
				<input type="text" 
						class="form-control" 
						name="q"
						placeholder="Найти в базе..." 
						id="suggest"
						autocomplete="off" 
						value="<?php isset($_GET['q'])?htmlentities($_GET['q']):''?>"
						required />
			
				<button class="btn search__btn" id="searchButton" type="submit"></button>

				<img src="http://<?php echo $GLOBALS['domain']; ?>/img/gif/preloader.gif" class="search__preloader" alt="search__preloader" />
			
			</form>

		</div>

		<div class="col-xs-12 col-md-4 text-right controls__btn btn_lost">

			<a href="http://<?php echo $GLOBALS['domain']; ?>/add.php?type=lost" class="btn btn-warning">Добавить пропажу</a>

		</div>

	</div>

</div>