<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Affichage</a></li>
		<li><a href="#tabs-2">Administration</a></li>
	</ul>
	<div id="tabs-1"><?=$this->displaycontent->displayListGallery(); ?></div>
	<div id="tabs-2">
	
	<?php 

if ($handle = opendir('./galeries'))
{
	$contenu_galeries=array();
	$cpt=0;
	while (false !== ($file = readdir($handle)))
	{
		if($file != "." && $file != ".." ){
			if(is_dir('./galeries' . '/' .$file))
				$contenu_galeries[$cpt]=$file;
		}
		$cpt++;
	}
	closedir($handle);
}
echo "<div><span>Initialisation des fichiers XML :</span></div><ul>";
foreach ($contenu_galeries as $nom_gallery) {

	echo "<li><a href='admin/init/" . $nom_gallery . "'>Initialisation de " . $nom_gallery . "</a></li>";
	

}
echo "</ul>";
echo "<div><span>Organisation des images :</span></div><ul>";
foreach ($contenu_galeries as $nom_gallery) {

	echo "<li><a href='/admin/sort/" . $nom_gallery . "'>Organisation de " . $nom_gallery . "</a></li>";
	

}
echo "</ul>"
?>
<?php
/*
 if(isset($_REQUEST['action']) AND $_REQUEST['action'] == 'refreshxml') {
	$galleryName = $_REQUEST['galleryname'];
	$xmlGal = new XmlGallery();
	echo "<div>" . $xmlGal->generateXml($galleryName) . "</div>";
}	*/
?>
	
	
	
	</div>
</div>
