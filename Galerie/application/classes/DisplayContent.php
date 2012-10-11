<?php

class DisplayContent {

	function __construct(){

	}

	function displayListGallery() {
		
		$confEnv = new ConfigEnv(); 
		
		if ($handle = opendir($confEnv->getFileUrl()))
		{
			$contenu_galeries=array();
			$cpt=0;
			while (false !== ($file = readdir($handle)))
			{
				if($file != "." && $file != ".." ){
					if(is_dir($confEnv->getFileUrl() . '/' .$file))
						$contenu_galeries[$cpt]=$file;
				}
				$cpt++;
			}
			closedir($handle);
		}
		
		$html = '<ul>';
		foreach ($contenu_galeries as $nom_gallery) {
			$html = $html."<li><a href='screen.html?galleryname=" . $nom_gallery . "'>" . $nom_gallery . "</a></li>";
		}
		$html = $html.'</ul>';
		
		return $html;
	}

}

?>