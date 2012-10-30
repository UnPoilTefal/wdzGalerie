<?php
class XmlGallery {

	private $allowed_types;
	
	function __construct(){
		
		$this->allowed_types = array('png','jpg','jpeg','gif'); //Allowed types of files
		
	}
	
	function generateXml($galleryName) {
		umask(0777);
		try {
			$configEnv = new ConfigEnv();
			$exportDoc = new GalleryContent($galleryName,TRUE);
			
			$imagesNodeList = $exportDoc->getImages()->getElementsByTagName('image');
			$newimageorder = $exportDoc->getNbExistingImages();
			
			$filename = '';
			$order = '';
			$display = '';
			$caption = '';
			
			$lst_imgfromdir = $this->getListImageFromDir($exportDoc->getFileImagesDirectory());
			
			$nb_imgfromdir = count($lst_imgfromdir);  //The total count of all the images
			
			for($x=0; $x < $nb_imgfromdir; $x++){
			
				$alreadyexist = '0';
					
				foreach ($imagesNodeList as $currentimage) {
					if ($currentimage->getAttribute('filename') == $lst_imgfromdir[$x]) {
						$alreadyexist = '1';
						break;
					}
				}
					
				if($alreadyexist == '0') {
					$newimageorder++;
			
					$filename = $lst_imgfromdir[$x];
					$order = $newimageorder;
					$display = '1';
					$caption = $exportDoc->getGalleryName();
			
					$exportDoc->addImage($filename, $order, $display, $caption);
			
				}
					
			}
			
			echo 'Ecrit : ' . $exportDoc->save() . ' bytes';
			
		} catch (Exception $e) {
			echo "<div>Erreur lors de l'initialisation de la galerie : " . $e->getMessage() ."</div>";
		}
		
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
	
}

?>