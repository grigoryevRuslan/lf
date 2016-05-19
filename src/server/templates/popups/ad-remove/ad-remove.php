<form 
	method="POST" 
	class="form"
	action='<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/private.php' ?>' >
	
	<input type="hidden" name="delete" id="ad-remove"></input>

	<h4 class="text-center">Вы действительно хотите удалить это объявление ?</h4>

	<p class="text-center">
		<button type="submit" class="btn btn-xs btn-danger">Удалить навсегда</button>
		
		<a class="btn btn-xs btn-primary" href="#" onclick="$('.popup').fadeOut(500);">Отмена</a>
	</p>

</form>