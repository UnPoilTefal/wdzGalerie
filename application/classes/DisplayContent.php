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
			$html = $html."<li><a href='screen.php?galleryname=" . $nom_gallery . "'>" . $nom_gallery . "</a></li>";
		}
		$html = $html.'</ul>';
		
		return $html;
	}
	
	function displayGallery($galleryName) {
		
		$sHtml = '';
		try {
			$displayDoc = new GalleryContent($galleryName);
			$imagesNodeList = $displayDoc->getImages()->getElementsByTagName('image');
			
			foreach ($imagesNodeList as $imageNode) {
					
				if($imageNode->getAttribute('display') == '1') {
			
					$sUrl = $imageNode->getAttribute('url');
					$sOrder = $imageNode->getAttribute('order');
					$sThumb = '';
					$sCaption = '';
			
					$thumbNodeList = $imageNode->getElementsByTagName('thumb');
			
					foreach ($thumbNodeList as $thumbNode) {
						$sThumb = $thumbNode->getAttribute('thumburl');
					}
			
					$captionNodeList = $imageNode->getElementsByTagName('caption');
			
					foreach ($captionNodeList as $captionNode) {
						$sCaption = $captionNode->nodeValue;
					}
			
					$sHtml = $sHtml . "<li class='image'><a rel='gallery' title='" . $sCaption . "' href='" . $sUrl . "'><img src='" . $sThumb . "' class='fade'/></a></li>";
			
				}
			
			}
				
		} catch (Exception $e) {
			return '<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Cette galerie ne peut etre affiche pour le moment : </strong>' . $e->getMessage() . '</p></div>';
			
		}
		
		return $sHtml;
	}
	function displaySortGallery($galleryName) {
	
		$sHtml = '';
		try {
			$displayDoc = new GalleryContent($galleryName);
			$imagesNodeList = $displayDoc->getImages()->getElementsByTagName('image');
			
			foreach ($imagesNodeList as $imageNode) {
			
				if($imageNode->getAttribute('display') == '1') {
			
					$sFilename = $imageNode->getAttribute('filename');
					$sUrl = $imageNode->getAttribute('url');
					$sOrder = $imageNode->getAttribute('order');
					$sThumb = '';
					$sCaption = '';
			
					$thumbNodeList = $imageNode->getElementsByTagName('thumb');
			
					foreach ($thumbNodeList as $thumbNode) {
						$sThumb = $thumbNode->getAttribute('thumburl');
					}
			
					$captionNodeList = $imageNode->getElementsByTagName('caption');
			
					foreach ($captionNodeList as $captionNode) {
						$sCaption = $captionNode->nodeValue;
					}
			
					$sHtml = $sHtml . "<li class='image dragbox'><img src='" . $sThumb . "' class='fade' rel='" . $sFilename . "'/></li>";
			
				}
			
			}
				
		} catch (Exception $e) {
			
			
		}
		return $sHtml;
	}
	
}

?>