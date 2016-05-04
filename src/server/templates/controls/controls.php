<div class="container controls">
	
	<div class="row">
		
		<div class="col-md-4 text-right">
			
			<a href="add.php?type=found" class="btn btn-success">Я нашел</a>

		</div>

		<div class="col-md-4 text-center user__search">
				
			<form method="GET" action="search.php" id="search_form" validate="true" class="controls__search">
			
				<input type="text" 
						class="form-control" 
						name="q"
						placeholder="Найти предмет..." 
						id="suggest"
						autocomplete="off" 
						value="<?php isset($_GET['q'])?htmlentities($_GET['q']):''?>"
						required />
			
				<button class="btn search__btn" id="searchButton" type="submit"></button>
			
			</form>

		</div>

		<div class="col-md-4 text-left">
			
			<a href="add.php?type=lost" class="btn btn-warning">Я потерял</a>

		</div>

	</div>

</div>