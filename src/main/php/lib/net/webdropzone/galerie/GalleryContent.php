<?php
class GalleryContent {
	
	private $gallery_name;
	private $file_images_directory;
	private $file_thumbs_directory;
	private $web_images_directory;
	private $web_thumbs_directory;
	private $xml_url;
	private $document;
	private $root;
	private $images;
	private $nb_existing_images;
	
	function __construct($galleryName){
		if($galleryName == '') {
			throw new Exception("Le nom d'une galerie ne peut �tre vide!");
		}
		$configEnv = new ConfigEnv();
		$this->gallery_name = $galleryName;
		$this->file_images_directory = $configEnv->getFileUrl() . '/' . $galleryName . '/images/';
		$this->file_thumbs_directory = $configEnv->getFileUrl() . '/' . $galleryName . '/thumbs/';
		$this->web_images_directory = $configEnv->getWebUrl() . '/' . $galleryName . '/images/';
		$this->web_thumbs_directory = $configEnv->getWebUrl() . '/' . $galleryName . '/thumbs/';
		$this->xml_url = $configEnv->getFileUrl() . '/' . $galleryName . '/' . $galleryName.'GalleryContent.xml';
		
		$this->nb_existing_images = 0;
		
		$this->initDocument();
		if (!file_exists($this->getFileThumbsDirectory())) {
			mkdir($this->getFileThumbsDirectory());
		}
		if (file_exists($this->xml_url)) {
			$this->initExistingDoc();
		}
		
	}
	function getNbExistingImages() {
		return $this->nb_existing_images;
	}
	
	function getGalleryName() {
		return $this->gallery_name;
	}
	
	function getFileImagesDirectory() {
		return $this->file_images_directory;
	}
	
	function getFileThumbsDirectory() {
		return $this->file_thumbs_directory;
	}
	
	function getWebImagesDirectory() {
		return $this->web_images_directory;
	}
	function getWebThumbsDirectory() {
		return $this->web_thumbs_directory;
	}
	
	function getXmlUrl() {
		return $this->xml_url;
	}
	
	function getRoot() {
		return $this->root;
	}
	
	function getImages() {
		return $this->images;		
	}
	
	private function initDocument() {
		$this->document = new DOMDocument('1.0');
		
		// nous voulons un bel affichage
		$this->document->formatOutput = true;
		
		$this->root = $this->document->createElement('gallery');
		$this->root = $this->document->appendChild($this->root);
		$this->images = $this->document->createElement('images');
		$imagesAttr = $this->document->createAttribute('galleryname');
		$imagesAttr->value = $this->gallery_name;
		$this->images->appendChild($imagesAttr);
		$this->images = $this->root->appendChild($this->images);
		
	}
	
	function addImage($filename, $order, $display, $caption) {
		
		if(file_exists($this->getFileImagesDirectory() . $filename)) {
			
			$imageElem = $this->document->createElement('image');
			
			$filenameAttr = $this->document->createAttribute('filename');
			$urlAttr = $this->document->createAttribute('url');
			$orderAttr = $this->document->createAttribute('order');
			$displayAttr = $this->document->createAttribute('display');
			
			// Value for the created attribute
			$filenameAttr->value = $filename;
			$urlAttr->value = $this->getWebImagesDirectory() . $filename;
			$orderAttr->value = $order;
			$displayAttr->value = $display;
			
			// Don't forget to append it to the element
			$imageElem->appendChild($filenameAttr);
			$imageElem->appendChild($orderAttr);
			$imageElem->appendChild($displayAttr);
			$imageElem->appendChild($urlAttr);
			
			$imageElem = $this->images->appendChild($imageElem);
				
			$captionElem = $this->document->createElement('caption', $caption);
			$captionElem = $imageElem->appendChild($captionElem);
			
			$thumbElem = $this->document->createElement('thumb');
			$thumUrlAttr = $this->document->createAttribute('thumburl');
			$thumUrlAttr->value = $this->getWebThumbsDirectory() . $filename;
			$thumbElem->appendChild($thumUrlAttr);
			$captionElem = $imageElem->appendChild($thumbElem);
			
			if(!file_exists($this->getFileThumbsDirectory() . $filename)) {
				/*$this->imagethumb($filename,'',150);*/
				throw new Exception("Les miniatures doivent être initialisées.");
			}
			
			$this->nb_existing_images ++;
		
		} else {
			if(file_exists($this->getFileThumbsDirectory() . $filename)) {
				if(@unlink($this->getFileThumbsDirectory() . $filename) === false) {
					echo "Echec Suppression " . $filename . "<br/>";
				}
			}
		}
	}
	
	function save() {
		return $this->document->save($this->xml_url);
	}
	
	private function sort_by_order_attr($a, $b)	{
		return (int) $a['image']->getAttribute('order') - (int) $b['image']->getAttribute('order');
	}
	
	private function initExistingDoc() {
		
		$existingxml = new DOMDocument();
		$existingxml->load($this->xml_url);
		
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
		
					$this->addImage($filename, $order, $display, $caption);
				}
			}
		}
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
			$lst_thumb = $n->getElementsByTagName('thumb');
			foreach ($lst_thumb as $thumb) {
				$imagecontent['thumb'] = $thumb->nodeValue;
			}
			$lst_images[] = $imagecontent;
		}
		return $lst_images;
	}

	function imagethumb( $image_src , $image_dest = NULL , $max_size = 100, $expand = FALSE, $square = FALSE ) {
		$image_dest = $this->getFileThumbsDirectory(). $image_src;
		$image_src = $this->getFileImagesDirectory(). $image_src;
		
		if( !file_exists($image_src) ) return FALSE;
	
		// R�cup�re les infos de l'image
		$fileinfo = getimagesize($image_src);
		if( !$fileinfo ) return FALSE;
	
		$width     = $fileinfo[0];
		$height    = $fileinfo[1];
		$type_mime = $fileinfo['mime'];
		$type      = str_replace('image/', '', $type_mime);
	
		if( !$expand && max($width, $height)<=$max_size && (!$square || ($square && $width==$height) ) )
		{
			// L'image est plus petite que max_size
			if($image_dest)
			{
				return copy($image_src, $image_dest);
			}
			else
			{
				header('Content-Type: '. $type_mime);
				return (boolean) readfile($image_src);
			}
		}
	
		// Calcule les nouvelles dimensions
		$ratio = $width / $height;
	
		if( $square )
		{
			$new_width = $new_height = $max_size;
	
			if( $ratio > 1 )
			{
				// Paysage
				$src_y = 0;
				$src_x = round( ($width - $height) / 2 );
	
				$src_w = $src_h = $height;
			}
			else
			{
				// Portrait
				$src_x = 0;
				$src_y = round( ($height - $width) / 2 );
	
				$src_w = $src_h = $width;
			}
		}
		else
		{
			$src_x = $src_y = 0;
			$src_w = $width;
			$src_h = $height;
	
			if ( $ratio > 1 )
			{
				// Paysage
				$new_width  = 220;//$max_size;
				$new_height = round( 220 / $ratio );
			}
			else
			{
				// Portrait
				$new_height = 110;//$max_size;
				$new_width  = round( 110 * $ratio );
			}
		}
	
		// Ouvre l'image originale
		$func = 'imagecreatefrom' . $type;
		if( !function_exists($func) ) return FALSE;
	
		$image_src = $func($image_src);
		$new_image = imagecreatetruecolor($new_width,$new_height);
	
		// Gestion de la transparence pour les png
		if( $type=='png' )
		{
			imagealphablending($new_image,false);
			if( function_exists('imagesavealpha') )
				imagesavealpha($new_image,true);
		}
	
		// Gestion de la transparence pour les gif
		elseif( $type=='gif' && imagecolortransparent($image_src)>=0 )
		{
			$transparent_index = imagecolortransparent($image_src);
			$transparent_color = imagecolorsforindex($image_src, $transparent_index);
			$transparent_index = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
			imagefill($new_image, 0, 0, $transparent_index);
			imagecolortransparent($new_image, $transparent_index);
		}
	
		// Redimensionnement de l'image
		imagecopyresampled(
		$new_image, $image_src,
		0, 0, $src_x, $src_y,
		$new_width, $new_height, $src_w, $src_h
		);
	
		// Enregistrement de l'image
		$func = 'image'. $type;
		if($image_dest)
		{
			$func($new_image, $image_dest);
		}
		else
		{
			header('Content-Type: '. $type_mime);
			$func($new_image);
		}
	
		// Lib�ration de la m�moire
		imagedestroy($new_image);
	
		return TRUE;
	}
	
}

?>