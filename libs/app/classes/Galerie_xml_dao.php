<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Galerie_xml_dao {

	private $gallery_node;
	private $images_node;
	private $document;

	//Paths
	private $gallery_path;
	private $xml_url;

	private $nb_existing_images;

	function __construct($p_dir_name, $gallery_file_exists = TRUE) {

		$this->gallery_path = FCPATH.'galeries/' . $p_dir_name;
		$this->xml_url = $this->gallery_path . '/' . $p_dir_name.'GalleryContent.xml';

		$this->initDocument($p_dir_name);
		if($gallery_file_exists) {
			$this->initExistingDoc();
		}
		$this->is_dtd_valid();
	}

	public function is_dtd_valid() {

		return @$this->document->validate();

	}
	private function initDocument($p_default_gallery_name) {

		// Cr�ation d'une instance de la classe DOMImplementation
		$imp = new DOMImplementation;

		// Cr�ation d'une instance DOMDocumentType
		$dtd = $imp->createDocumentType('gallery', '', base_url().'/wdzGalleryContent.dtd');

		// Cr�ation d'une instance DOMDocument
		$this->document = $imp->createDocument("", "", $dtd);

		// D�finition des autres propri�t�s
		$this->document->encoding = 'UTF-8';
		$this->document->standalone = false;
		// nous voulons un bel affichage
		$this->document->formatOutput = true;

		//Init Entete par defaut
		$this->gallery_node = $this->document->createElement('gallery');
		$this->gallery_node = $this->document->appendChild($this->gallery_node);
		$galleryAttr = $this->document->createAttribute('galleryname');
		$galleryAttr->value = $p_default_gallery_name;
		$this->gallery_node->appendChild($galleryAttr);
		$galleryAttr2 = $this->document->createAttribute('hl');
		$galleryAttr2->value = 'init';
		$this->gallery_node->appendChild($galleryAttr2);
		$galleryAttr3 = $this->document->createAttribute('remote');
		$galleryAttr3->value = '';
		$this->gallery_node->appendChild($galleryAttr3);
		$this->images_node = $this->document->createElement('images');
		$this->images_node = $this->gallery_node->appendChild($this->images_node);

	}
	private function initExistingDoc() {

		$existingxml = new DOMDocument();

		if(@$existingxml->load($this->xml_url)) {

			$existing_gallery_element = $existingxml->documentElement;

			//init entete with existing infos
			if($existing_gallery_element->hasAttribute('galleryname')) {
				$this->set_gallery_name($existing_gallery_element->getAttribute('galleryname'));
			}

			if($existing_gallery_element->hasAttribute('hl')) {
				$this->set_hl_pic($existing_gallery_element->getAttribute('hl'));
			}

			if($existing_gallery_element->hasAttribute('remote')) {
				$this->set_remote($existing_gallery_element->getAttribute('remote'));
			}

			//import images
			$existingimages = $existingxml->getElementsByTagName('image');
			$tableauimages = $this->getImageArrayFromImageNode($existingimages);

			usort($tableauimages, array($this, 'sort_by_order_attr'));
			$nb_order = 0;
			foreach ($tableauimages as $existingimage) {
				$nb_order++;

				$filename = $existingimage['image']->getAttribute('filename');
				$url = $existingimage['image']->getAttribute('url');
				$order = $nb_order;
				$display = $existingimage['image']->getAttribute('display');
				$caption = $existingimage['caption'];
				$thumb_url = $existingimage['thumb'];

				$this->addImage($filename, $order, $display, $caption, $url, $thumb_url);
			}
		} else {
			log_message('error', "Le fichier " . $this->xml_url . " n'est pas valide!");
		}
	}

	function save() {
		return $this->document->save($this->xml_url);
	}

	private function getImageArrayFromImageNode($imageNode) {

		$lst_images = array();
		foreach ($imageNode as $n) {

			$imagecontent = array();
			$imagecontent['image'] = $n;
			$caption = $n->getElementsByTagName('caption')->item(0);
			if(!is_null($caption)) {
				$imagecontent['caption'] = $caption->nodeValue;
			} else {
				continue;
			}
			$thumb = $n->getElementsByTagName('thumb')->item(0);
			if(!is_null($thumb)) {
				$imagecontent['thumb'] = $thumb->getAttribute('thumburl');
			} else {
				continue;
			}
			$lst_images[] = $imagecontent;
		}
		return $lst_images;
	}

	private function sort_by_order_attr($a, $b)	{
		return (int) $a['image']->getAttribute('order') - (int) $b['image']->getAttribute('order');
	}

	function addImage($filename, $order, $display, $caption, $url='', $url_thumb) {

		$imageElem = $this->document->createElement('image');

		$filenameAttr = $this->document->createAttribute('filename');
		$urlAttr = $this->document->createAttribute('url');
		$orderAttr = $this->document->createAttribute('order');
		$displayAttr = $this->document->createAttribute('display');

		// Value for the created attribute
		$filenameAttr->value = $filename;
		$urlAttr->value = $url;
		$orderAttr->value = $order;
		$displayAttr->value = $display;

		// Don't forget to append it to the element
		$imageElem->appendChild($filenameAttr);
		$imageElem->appendChild($orderAttr);
		$imageElem->appendChild($displayAttr);
		$imageElem->appendChild($urlAttr);

		$imageElem = $this->images_node->appendChild($imageElem);

		$captionElem = $this->document->createElement('caption', $caption);
		$captionElem = $imageElem->appendChild($captionElem);

		$thumbElem = $this->document->createElement('thumb');
		$thumUrlAttr = $this->document->createAttribute('thumburl');
		$thumUrlAttr->value = $url_thumb;
		$thumbElem->appendChild($thumUrlAttr);
		$captionElem = $imageElem->appendChild($thumbElem);

		$this->nb_existing_images ++;

	}

	//Getters
	public function get_gallery_name() {
		return $this->document->documentElement->getAttribute('galleryname');
	}
	public function get_hl_pic() {
		return $this->document->documentElement->getAttribute('hl');
	}
	public function get_remote() {
		return $this->document->documentElement->getAttribute('remote');
	}
	
	public function get_nb_existing_images() {
		return $this->nb_existing_images;
	}
	
	public function get_lst_images() {

		$lst_images = array();

		$images_nodelist = $this->images_node->getElementsByTagName('image');
		foreach ($images_nodelist as $image_node) {
			$filename = $image_node->getAttribute('filename');
			$image = new Image($filename);
			$image->set_order($image_node->getAttribute('order'));
			$image->set_display($image_node->getAttribute('display'));
			$image->set_url($image_node->getAttribute('url'));

			$caption_node = $image_node->getElementsByTagName('caption')->item(0);
			$image->set_caption($caption_node->nodeValue);

			$thumb_node = $image_node->getElementsByTagName('thumb')->item(0);

			$image->set_thumb_url($thumb_node->getAttribute('thumburl'));

			array_push($lst_images, $image);
		}

		return $lst_images;
	}


	//Setters
	public function set_gallery_name($p_gallery_name) {
		$this->document->documentElement->setAttribute('galleryname', $p_gallery_name);
	}

	public function set_hl_pic($p_hl_pic) {
		$this->document->documentElement->setAttribute('hl', $p_hl_pic);
	}

	public function set_remote($p_remote) {
		$this->document->documentElement->setAttribute('remote', $p_remote);
	}
	public function set_lst_images($p_lst_images){
	
		$this->clearImagesList();

		foreach ($p_lst_images as $image) {
			
			$filename = $image->get_filename();
			$order = $image->get_order();
			$display = $image->get_display();
			$caption = $image->get_caption();
			$url = $image->get_url();
			$url_thumb = $image->get_thumb_url();
			
			$this->addImage($filename, $order, $display, $caption, $url, $url_thumb);
		}


	}
	public function updateFromGalerie(Galerie $p_gallery) {

		//Mise � jour de l'entete
		$this->set_gallery_name($p_gallery->get_gallery_name());
		$hl_pic = '';
		if(!is_null($p_gallery->get_hl_pic())) {
			$hl_pic = $p_gallery->get_hl_pic();
		}
		$this->set_hl_pic($hl_pic);
		$this->set_remote($p_gallery->is_remote_gallery());

		//Mise � jour des images
		$this->set_lst_images($p_gallery->get_lst_images());

	}
	function clearImagesList() {
		while($this->images_node->hasChildNodes()) {
			$this->images_node->removeChild($this->images_node->childNodes->item(0));
		}
	}
}