<?php 
	$page_uri = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$image_uri = "http://$_SERVER[HTTP_HOST]".$result[0]['image_uri'];
 ?>

<p class="share">

	<b>Поделиться:</b>
	
	<i onclick="Share.facebook('<?php echo $page_uri ?>',
								'Всеукраинское бюро находок',
								'<?php echo $image_uri; ?>/app/upload/<?php echo $result[0]['image_uri']; ?>',
								'<?php echo $result[0]['item']; ?>')" class="share__btn share__btn_fb"></i>

	<i onclick="Share.vkontakte('<?php echo $page_uri ?>',
								'Всеукраинское бюро находок',
								'<?php echo $image_uri; ?>/app/upload/<?php echo $result[0]['image_uri']; ?>',
								'<?php echo $result[0]['item']; ?>')" class="share__btn share__btn_vk"></i>

	<i onclick="Share.twitter('<?php echo $page_uri ?>',
								'<?php echo $result[0]['item']; ?>')" class="share__btn share__btn_tw"></i>

	<i onclick="Share.gplus('<?php echo $page_uri ?>')" class="share__btn share__btn_gplus"></i>

</p>