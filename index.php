<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php require_once 'application/classes/init.php';
 $dispContent = new DisplayContent();
 $configEnv = new ConfigEnv();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Photo Gallery</title>
<link href="css/ui-gallery/jquery-ui-1.9.0.custom.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script>
		$(function() {
			$( "#tabs" ).tabs();
		});
	</script>
</head>
<body>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Affichage</a></li>
		<li><a href="#tabs-2">Administration</a></li>
	</ul>
	<div id="tabs-1"><?=$dispContent->displayListGallery(); ?></div>
	<div id="tabs-2">
	
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
echo "<div><span>Initialisation des fichiers XML :</span></div><ul>";
foreach ($contenu_galeries as $nom_gallery) {

	echo "<li><a href='index.php?galleryname=" . $nom_gallery . "&action=refreshxml'>Initialisation de " . $nom_gallery . "</a></li>";
	

}
echo "</ul>";
echo "<div><span>Organisation des images :</span></div><ul>";
foreach ($contenu_galeries as $nom_gallery) {

	echo "<li><a href='sort.php?galleryname=" . $nom_gallery . "'>Organisation de " . $nom_gallery . "</a></li>";
	

}
echo "</ul>"
?>
<?php
 if(isset($_REQUEST['action']) AND $_REQUEST['action'] == 'refreshxml') {
	$galleryName = $_REQUEST['galleryname'];
	$xmlGal = new XmlGallery();
	echo "<div>" . $xmlGal->generateXml($galleryName) . "</div>";
}	
?>
	
	
	
	</div>
</div>




	
</body>
</html>
