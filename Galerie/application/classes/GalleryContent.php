<?php
class GalleryContent {
	
	private $file_images_directory;
	private $web_images_directory;
	private $xml_url;
	private $document;
	private $root;
	private $images;
	
	function __construct($galleryName){
		
		$configEnv = new ConfigEnv();
		$this->file_images_directory = $configEnv->getFileUrl() . '/' . $galleryName . '/images/';
		$this->web_images_directory = $configEnv->getWebUrl() . '/' . $galleryName . '/images/';
		$this->xml_url = $configEnv->getFileUrl() . '/' . $galleryName . '/' . $galleryName.'GalleryContent.xml';
		
		$this->initDocument();
		
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
		
	}
	
	function save() {
		return $this->document->save($this->xml_url);
	}
	
}

?>