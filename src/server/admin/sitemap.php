<?php
    set_time_limit(0);
 
    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/helpers/sitemapClass.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';

    $query = $pdoConnection->prepare("SELECT id FROM items WHERE is_published = 1");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if(!$result) {
    	die('Error record. ' . $connection->connect_errno . ': ' . $connection->connect_error);
    }

    $sitemap = new sitemap();
     
    $sitemap->set_ignore(array("javascript:", ".css", ".js", ".ico", ".jpg", ".png", ".jpeg", ".swf", ".gif", "facebook.php", "vk.php", "add.php", "#"));

    $sitemap->get_links("http://www.luckfind.me");
     
    $sitemap->addArrayIds($result);

    $arr = $sitemap->get_array();
     
    $map = $sitemap->generate_sitemap();
    file_put_contents('../sitemap.xml' , $map);

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

	<div class="container">
			
		<h1 class="text-center">Карта сайта обновлена.</h1>

	</div>
</body>
</html>