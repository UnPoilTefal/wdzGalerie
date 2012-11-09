<?php
class Xmlgallery {

	private $allowed_types;
	private $CI;
	
	function __construct(){
		
		$this->allowed_types = array('png','jpg','jpeg','gif'); //Allowed types of files
		$this->CI =& get_instance();
	}
	
	function generateXml($galleryName) {
		
		try {
			
			$exportDoc = $this->CI->gallerycontent;
			
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
			
			return 'Ecrit : ' . $exportDoc->save() . ' bytes';
			
		} catch (Exception $e) {
			return "Erreur lors de l'initialisation de la galerie : " . $e->getMessage();
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
	
	function sortGallery($galleryname, $data) {
		
		try {
			$exportDoc = $this->CI->gallerycontent;
			$imagesNodeList = $exportDoc->getImages()->getElementsByTagName('image');
			
			foreach ($imagesNodeList as $existingImage) {
			
				foreach($data as $image){
					$filename = $image['id'];
					$order = $image['order'];
			
					if ($existingImage->getAttribute('filename') == $filename) {
						$existingImage->setAttribute('order', $order);
					}
			
				}
			
			}
			$exportDoc->save();
				
		} catch (Exception $e) {
			throw new Exception('Erreur lors du traitement : Xmlgallery->sortGallery');
		}
		
	}
	public function generate_adf() {
		
		$exportDoc = $this->CI->gallerycontent;
		
		
		$gallery_path = FCPATH.'galeries/adf';
		$xml_url = $gallery_path . '/config_complet.xml';
			
		$source_xml = new DOMDocument();
			
		$source_xml->load($xml_url);
		$source_images = $source_xml->getElementsByTagName('item');
		
		/**/
		$filename = '';
		$thumb_url = '';
		$order = 0;
		$display = '';
		$caption = '';
		$url='http://album-de-famille.com/new/Albums_reunions/';
		/**/
		
		foreach ($source_images as $item) {
			$order++;
			$media_path_lst = $item->getElementsByTagName('media_path');
			foreach ($media_path_lst as $media_path) {
				$filename = $url.$media_path->nodeValue;
			}
			
			$thumb_path_lst = $item->getElementsByTagName('thumb_path');
			foreach ($thumb_path_lst as $thumb_path) {
				$thumb_url = $url.$thumb_path->nodeValue;
			}
				
			$desc_lst = $item->getElementsByTagName('description');
			foreach ($desc_lst as $desc) {
				$caption = $desc->nodeValue;
			}
				
			$exportDoc->addImage($filename, $order, '1', $caption, $filename, $thumb_url, TRUE);
		}
	
		return 'Ecrit : ' . $exportDoc->save() . ' bytes';
	
	}
	
}

?>