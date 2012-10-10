<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php require_once 'application/classes/init.php';?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Photo Gallery</title>
</head>
<body>
<ul>
<?php 

if ($handle = opendir($configEnv->getFileUrl()))
{
	$contenu_galeries=array();
	$cpt=0;
	while (false !== ($file = readdir($handle)))
	{
		if($file != "." && $file != ".." ){
			if(is_dir($configEnv->getFileUrl() . '/' .$file))
				$contenu_galeries[$cpt]=$file;
		}
		$cpt++;
	}
	closedir($handle);
}
foreach ($contenu_galeries as $nom_gallery) {

	echo "<li><a href='admin.php?galleryname=" . $nom_gallery . "&action=refreshxml'>Initialisation de " . $nom_gallery . "</a></li>";

}
?>
</ul>
<?php
 if(isset($_REQUEST['action']) AND $_REQUEST['action'] == 'refreshxml') {
	$galleryName = $_REQUEST['galleryname'];
	$xmlGal = new XmlGallery();
	echo "<div>" . $xmlGal->generateXml($galleryName) . "</div>";
}	
?>
<div></div>
</body>
</html>