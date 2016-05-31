<?php 
	$page_uri = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$image_uri = "http://$_SERVER[HTTP_HOST]".'/upload/'.$result[0]['image_uri'];
?>

 <?php if ( $GLOBALS['isAuthorised'] ) { ?>
 
	<p class="share"
		ng-controller="shareController">

		<b>Рассказать об этом в ленте:</b>
		
		<i class="share__btn share__btn_fb fb-share-button" 
		   data-href="http://<?php echo $_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI] ?>" 
		   data-layout="icon"
		   data-mobile-iframe="true"></i>

		<i ng-click="shareVk('<?php echo $page_uri ?>',
									'Всеукраинское бюро находок',
									'<?php echo $image_uri; ?>',
									'<?php echo $result[0]['item']; ?>')" class="share__btn share__btn_vk"></i>

		<i ng-click="shareTwitter('<?php echo $page_uri ?>',
									'<?php echo $result[0]['item']; ?>')" class="share__btn share__btn_tw"></i>

		<i ng-click="shareGplus('<?php echo $page_uri ?>')" class="share__btn share__btn_gplus"></i>

	</p>

<?php } ?>