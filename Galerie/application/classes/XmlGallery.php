<?php
class XmlGallery {

	private $allowed_types;
	
	
	function __construct(){
		
		$this->allowed_types = array('png','jpg','jpeg','gif'); //Allowed types of files
		
	}

	private function sort_by_order_attr($a, $b)	{
		return (int) $a['image']->getAttribute('order') - (int) $b['image']->getAttribute('order');
	}
	
	function generateXml($galleryName) {
		
		$configEnv = new ConfigEnv();
		$exportDoc = new GalleryContent($galleryName);
		
		$galleryContentFile = $exportDoc->getXmlUrl();

		$nb_existingimg = 0;
		$tableauimages = array();
		if (file_exists($galleryContentFile)) {

			$existingxml = $this->getExistingXml($galleryContentFile);

			$existingimages = $existingxml->getElementsByTagName('image');
			if($existingimages->length > 0) {
				$tableauimages = $this->getImageArrayFromImageNode($existingimages);
	
				usort($tableauimages, array($this, 'sort_by_order_attr'));
				
				$nb_existingimg = count($tableauimages);
				
				$nb_order = 0;
				if($nb_existingimg > 0) {
					foreach ($tableauimages as $existingimage) {
						$nb_order++;
						
						$filename = $existingimage['image']->getAttribute('filename');
						$order = $nb_order;
						$display = $existingimage['image']->getAttribute('display');
						$caption = $existingimage['caption'];
						
						$exportDoc->addImage($filename, $order, $display, $caption);
				
				
					}
				}
			}
		}
		$newimageorder = $nb_existingimg;
		$filename = '';
		$order = '';
		$display = '';
		$caption = '';
		
		$lst_imgfromdir = $this->getListImageFromDir($exportDoc->getFileImagesDirectory());
		
		$nb_imgfromdir = count($lst_imgfromdir);  //The total count of all the images
		
		for($x=0; $x < $nb_imgfromdir; $x++){
		
			$alreadyexist = '0';
			
			foreach ($tableauimages as $currentimage) {
				if ($currentimage['image']->getAttribute('filename') == $exportDoc->getWebImagesDirectory(). $lst_imgfromdir[$x]) {
					$alreadyexist = '1';
					break;
				}
			}
			
			if($alreadyexist == '0') {
				$newimageorder++;

				$filename = $exportDoc->getWebImagesDirectory() . $lst_imgfromdir[$x];
				$order = $newimageorder;
				$display = '1';
				$caption = $lst_imgfromdir[$x];
				
				$exportDoc->addImage($filename, $order, $display, $caption);
		
			}
		}
		
		echo 'Ecrit : ' . $exportDoc->save() . ' bytes';		
		
	}
	
	function getListImageFromDir($directory) {
		
		$lst_imgfromdir = array();
		
		$dimg = opendir($directory);//Open directory
		
		while($imgfile = readdir($dimg))
		{
			if( in_array(strtolower(substr($imgfile,-3)),$this->allowed_types) OR
			  in_array(strtolower(substr($imgfile,-4)),$this->allowed_types) )
			  /*If the file is an image add it to the array*/
			{$lst_imgfromdir[] = $imgfile;}
		}
		
		return $lst_imgfromdir;
		
	}
	
	private function getExistingXml($url) {
		
		$doc = new DOMDocument();
		$doc->load($url);
		
		return $doc;
	}
	
	private function getImageArrayFromImageNode($imageNode) {
		
		$lst_images = array();
		foreach ($imageNode as $n) {
		
			$imagecontent = array();
			$imagecontent['image'] = $n;
			$lst_caption = $n->getElementsByTagName('caption');
			foreach ($lst_caption as $caption) {
				$imagecontent['caption'] = $caption->nodeValue;
			}
			$lst_images[] = $imagecontent;
		}
		return $lst_images;
	}
	
}

?>