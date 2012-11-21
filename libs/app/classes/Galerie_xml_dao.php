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

	function __construct($p_dir_name) {

		$this->gallery_path = FCPATH.'galeries/' . $p_dir_name;
		$this->xml_url = $this->gallery_path . '/' . $p_dir_name.'GalleryContent.xml';

		$this->initDocument();

	}
	private function initDocument() {

		// Création d'une instance de la classe DOMImplementation
		$imp = new DOMImplementation;

		// Création d'une instance DOMDocumentType
		$dtd = $imp->createDocumentType('gallery', '', '../../wdzGalleryContent.dtd');

		// Création d'une instance DOMDocument
		$this->document = $imp->createDocument("", "", $dtd);

		// Définition des autres propriétés
		$this->document->encoding = 'UTF-8';
		$this->document->standalone = false;
		// nous voulons un bel affichage
		$this->document->formatOutput = true;

	}
	public function initExistingDoc() {

		$existingxml = new DOMDocument();
		$existingxml->load($this->xml_url);

		$existingimages = $existingxml->getElementsByTagName('image');

		if($existingimages->length > 0) {
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
			$imagecontent['caption'] = $caption->nodeValue;
			$thumb = $n->getElementsByTagName('thumb')->item(0);
			$imagecontent['thumb'] = $thumb->getAttribute('thumb_url');
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

		$imageElem = $this->images->appendChild($imageElem);

		$captionElem = $this->document->createElement('caption', $caption);
		$captionElem = $imageElem->appendChild($captionElem);

		$thumbElem = $this->document->createElement('thumb');
		$thumUrlAttr = $this->document->createAttribute('thumburl');
		$thumUrlAttr->value = $url_thumb;
		$thumbElem->appendChild($thumUrlAttr);
		$captionElem = $imageElem->appendChild($thumbElem);

		$this->nb_existing_images ++;

	}

}