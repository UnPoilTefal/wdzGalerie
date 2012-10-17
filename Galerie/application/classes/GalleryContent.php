<?php
class GalleryContent {
	
	private $file_images_directory;
	private $web_images_directory;
	private $xml_url;
	private $document;
	private $root;
	private $images;
	private $nb_existing_images;
	
	function __construct($galleryName){
		
		$configEnv = new ConfigEnv();
		$this->file_images_directory = $configEnv->getFileUrl() . '/' . $galleryName . '/images/';
		$this->web_images_directory = $configEnv->getWebUrl() . '/' . $galleryName . '/images/';
		$this->xml_url = $configEnv->getFileUrl() . '/' . $galleryName . '/' . $galleryName.'GalleryContent.xml';
		
		$this->nb_existing_images = 0;
		
		$this->initDocument();
		
		if (file_exists($this->xml_url)) {
			$this->initExistingDoc();
		}
		
	}
	
	function getNbExistingImages() {
		return $this->nb_existing_images;
	}
	
	function getFileImagesDirectory() {
		return $this->file_images_directory;
	}

	function getWebImagesDirectory() {
		return $this->web_images_directory;
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
		$this->images = $this->root->appendChild($this->images);
		
	}
	
	function addImage($filename, $order, $display, $caption) {

		$imageElem = $this->document->createElement('image');
		
		$filenameAttr = $this->document->createAttribute('filename');
		$orderAttr = $this->document->createAttribute('order');
		$displayAttr = $this->document->createAttribute('display');
		
		// Value for the created attribute
		$filenameAttr->value = $filename;
		$orderAttr->value = $order;
		$displayAttr->value = $display;
		
		// Don't forget to append it to the element
		$imageElem->appendChild($filenameAttr);
		$imageElem->appendChild($orderAttr);
		$imageElem->appendChild($displayAttr);
		
		$imageElem = $this->images->appendChild($imageElem);
			
		$captionElem = $this->document->createElement('caption', $caption);
		$captionElem = $imageElem->appendChild($captionElem);
		
		$this->nb_existing_images ++;
		
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
			$lst_images[] = $imagecontent;
		}
		return $lst_images;
	}
	
}

?>