<?php
class Gallery_model_xml extends CI_Model {

	private $CI;

	public function __construct()
	{
		parent::__construct();
	}

	public function get_existing_gallery($dir_name) {
		$galerie = new Galerie($dir_name);

		if($this->is_gallery_ok($dir_name)) {

			$galerie->set_available(TRUE);

			$galerie_dao = new Galerie_xml_dao($dir_name);

			$galerie->set_hl_pic($galerie_dao->get_hl_pic());

			$galerie->set_gallery_name($galerie_dao->get_gallery_name());

			$galerie->set_remote_gallery($galerie_dao->get_remote());

			$existingimages = $galerie_dao->get_lst_images();

			foreach ($existingimages as $current_image) {
				$galerie->add_image($current_image);
			}

		} else {
			$galerie->set_available(FALSE);
		}
		return $galerie;
	}

	public function check_status_gallery($gallery_name) {

		$check_lst = array('gallery_dir' => FALSE, 'images_dir' => FALSE, 'thumbs_dir' => FALSE, 'gallery_xml_file_exists' => FALSE, 'thumb_files_ok' => FALSE);

		$check_lst['gallery_dir'] = $this->is_gallery_dir_exists($gallery_name);
		$check_lst['images_dir'] = $this->is_images_dir_exists($gallery_name);
		$check_lst['thumbs_dir'] = $this->is_thumbs_dir_exists($gallery_name);
		$check_lst['gallery_xml_file_exists'] = $this->is_gallery_xml_file_exists($gallery_name);
		$check_lst['gallery_xml_file_valid'] = $this->is_gallery_xml_file_valid($gallery_name);
		$check_lst['thumb_files_ok'] = array('mandatory'=>FALSE,'status'=>FALSE); //TODO add check method

		return $check_lst;
	}

	public function is_gallery_ok($gallery_name) {

		$gallery_status = TRUE;
		$chk_lst = $this->check_status_gallery($gallery_name);
		foreach ($chk_lst as $k=>$current_status) {

			if($current_status['mandatory'] === TRUE && $current_status['status'] === FALSE) {
				$gallery_status = FALSE;
				break;
			}

		}

		return $gallery_status;
	}

	public function get_list_available_galeries() {

		$lst_avail = array();

		$lst_galeries = $this->get_list_galeries();

		foreach ($lst_galeries as $galerie) {
			if($galerie->is_available()) {
				array_push($lst_avail, $galerie);
			}
		}

		return $lst_avail;
	}

	public function get_list_not_available_galeries() {

		$lst_not_avail = array();

		$lst_galeries = $this->get_list_galeries();

		foreach ($lst_galeries as $galerie) {
			if(!$galerie->is_available()) {
				array_push($lst_not_avail, $galerie);
			}
		}

		return $lst_not_avail;
	}

	public function get_list_galeries() {
		$lst_galeries = array();

		$dir_galeries = $this->get_lst_gallery_dir();

		foreach ($dir_galeries as $dir_name) {

			//$test_xml_file = $this->is_gallery_xml_file_exists($dir_name);
			$current_galerie = $this->get_existing_gallery($dir_name);
			/*
			 if($test_xml_file['status']) {
			$current_galerie = $this->get_existing_gallery($dir_name);
			}
			*/
			$lst_galeries[] = $current_galerie;
		}

		return $lst_galeries;
	}
	private function is_gallery_dir_exists($gallery_name) {

		$value = array('mandatory'=>TRUE,'status'=>FALSE);

		if(file_exists('./galeries/' . $gallery_name)) {
			$value['status'] = TRUE;
		}

		return $value;

	}

	private function is_images_dir_exists($gallery_name) {

		$value = array('mandatory'=>FALSE,'status'=>FALSE);

		if(file_exists('./galeries/' . $gallery_name . '/images')) {
			$value['status'] = TRUE;
		}

		return $value;

	}

	private function is_thumbs_dir_exists($gallery_name) {

		$value = array('mandatory'=>FALSE,'status'=>FALSE);

		if(file_exists('./galeries/' . $gallery_name . '/thumbs')) {
			$value['status'] = TRUE;
		}

		return $value;

	}
	private function is_gallery_xml_file_exists($gallery_name) {

		$value = array('mandatory'=>TRUE,'status'=>FALSE);

		if(file_exists('./galeries/' . $gallery_name . '/' . $gallery_name.'GalleryContent.xml')) {
			$value['status'] = TRUE;
		}

		return $value;

	}

	private function is_gallery_xml_file_valid($gallery_name) {

		$value = array('mandatory'=>TRUE,'status'=>FALSE);
		$existingxml = new DOMDocument();

		if(@$existingxml->load('./galeries/' . $gallery_name . '/' . $gallery_name.'GalleryContent.xml')) {

			// Création d'une instance de la classe DOMImplementation
			$imp = new DOMImplementation;

			// Création d'une instance DOMDocumentType
			$dtd = $imp->createDocumentType('gallery', '', base_url().'/wdzGalleryContent.dtd');
			/*
			// Création d'une instance DOMDocument
			$document = $imp->createDocument("", "", $dtd);

			// Définition des autres propriétés*/
			$existingxml->encoding = 'UTF-8';
			$existingxml->standalone = false;
			//$existingxml->implementation = $dtd;
			
			//TODO Ajouter controle avec dtd
			/*
			// nous voulons un bel affichage
			$document->formatOutput = true;
			
			$child = $document->importNode($existingxml->documentElement, TRUE);
			$document->documentElement->appendChild($child, true);
			
			$document->saveHTMLFile("d:\ctrlxml.xml");
			*/
			//$existingxml->replaceChild($dtd, $existingxml->doctype);
			
			/*if($existingxml->validate()) {*/
				$value['status'] = TRUE;
			//}
				
		}

		return $value;

	}

	public function save_gallery(Galerie $p_gallery) {

		if($p_gallery->is_available()) {

			$galerie_dao = new Galerie_xml_dao($p_gallery->get_dir_name());

			$galerie_dao->updateFromGalerie($p_gallery);
			/*
			 $gallery_path = FCPATH.'galeries/' . $p_gallery->get_dir_name();

			$file_images_directory = $gallery_path . '/images/';
			$file_thumbs_directory = $gallery_path . '/thumbs/';
			$web_images_directory = base_url().'galeries/' . $p_gallery->get_dir_name() . '/images/';
			$web_thumbs_directory = base_url().'galeries/' . $p_gallery->get_dir_name() . '/thumbs/';
			$xml_url = $gallery_path . '/' . $p_gallery->get_dir_name() .'GalleryContent.xml';

			$nb_existing_images = 0;

			$document_xml = new DOMDocument('1.0');

			// nous voulons un bel affichage
			$document_xml->formatOutput = true;

			$doc_root = $document_xml->createElement('gallery');
			$doc_root = $document_xml->appendChild($doc_root);
			$rootAttr = $document_xml->createAttribute('galleryname');
			$rootAttr->value = $p_gallery->get_gallery_name();
			$doc_root->appendChild($rootAttr);
			$rootAttr2 = $document_xml->createAttribute('hl');
			$image_hl = $p_gallery->get_hl_pic();
			$url_hl = '';
			if(is_null($image_hl)) {
			$url_hl = "http://placehold.it/210x110";
			} else {
			$url_hl = $image_hl->get_thumb_url();
			}
			$rootAttr2->value = $url_hl;
			$doc_root->appendChild($rootAttr2);
			$rootAttr3 = $document_xml->createAttribute('remote');
			$rootAttr3->value = $p_gallery->is_remote_gallery();
			$doc_root->appendChild($rootAttr3);

			$doc_images = $document_xml->createElement('images');
			$doc_images = $doc_root->appendChild($doc_images);

			foreach ($p_gallery->get_lst_images() as $image) {

			$imageElem = $document_xml->createElement('image');

			$filenameAttr = $document_xml->createAttribute('filename');
			$urlAttr = $document_xml->createAttribute('url');
			$orderAttr = $document_xml->createAttribute('order');
			$displayAttr = $document_xml->createAttribute('display');

			// Value for the created attribute
			$filenameAttr->value = $image->get_filename();
			$urlAttr->value = $image->get_url();
			$orderAttr->value = $image->get_order();
			$displayAttr->value = $image->get_display();

			// Don't forget to append it to the element
			$imageElem->appendChild($filenameAttr);
			$imageElem->appendChild($orderAttr);
			$imageElem->appendChild($displayAttr);
			$imageElem->appendChild($urlAttr);

			$imageElem = $doc_images->appendChild($imageElem);

			$captionElem = $document_xml->createElement('caption', $image->get_caption());
			$captionElem = $imageElem->appendChild($captionElem);

			$thumbElem = $document_xml->createElement('thumb');
			$thumUrlAttr = $document_xml->createAttribute('thumburl');
			$thumUrlAttr->value = $image->get_thumb_url();
			$thumbElem->appendChild($thumUrlAttr);
			$thumbElem = $imageElem->appendChild($thumbElem);

			$nb_existing_images ++;

			}

			$document_xml->save($xml_url);
			chmod($xml_url, 0777);
			*/

			$galerie_dao->save();

		} else {

			throw new Exception("Echec de sauvegarde de la galerie " . $p_gallery->get_gallery_name() . "Elle doit être initialisée.");

		}

	}
	public function sort_gallery_and_save(Galerie $p_galerie, $p_data) {
		try {

			$lst_images = $p_galerie->get_lst_images();

			foreach ($lst_images as $existing_image) {
					
				foreach($p_data as $image){
					$filename = $image['id'];
					$order = $image['order'];

					if ($existing_image->get_filename() === $filename) {
						$existing_image->set_order($order);
					}

				}
					
			}

			$this->save_gallery($p_galerie);

		} catch (Exception $e) {
			throw new Exception('Erreur lors du traitement : sort_gallery_and_save');
		}

	}

	public function generate_adf() {

		$galerieObj = $this->get_existing_gallery("adf");

		//$exportDoc = $this->CI->gallerycontent;


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
			$image = new Image($filename);

			$thumb_path_lst = $item->getElementsByTagName('thumb_path');
			foreach ($thumb_path_lst as $thumb_path) {
				$thumb_url = $url.$thumb_path->nodeValue;
			}
			$image->set_thumb_url($thumb_url);

			$desc_lst = $item->getElementsByTagName('description');
			foreach ($desc_lst as $desc) {
				$caption = $desc->nodeValue;
			}
			$image->set_caption($caption);

			$image->set_order($order);
			$image->set_display('1');
			$image->set_url($filename);

			$galerieObj->add_image($image);
			//$exportDoc->addImage($filename, $order, '1', $caption, $filename, $thumb_url, TRUE);
		}
		$this->save_gallery($galerieObj);
		return 'OK';//'Ecrit : ' . $exportDoc->save() . ' bytes';

	}

	public function init_gallery_xml($p_dir_name) {

		$gallery_dir_exists = $this->is_gallery_dir_exists($p_dir_name);

		$gallery_xml = new Galerie_xml_dao($p_dir_name);

		return $gallery_xml->save();

	}
	private function get_lst_gallery_dir() {

		$dir_galeries = array();

		if ($handle = opendir('./galeries'))
		{

			$cpt=0;

			while (false !== ($file = readdir($handle)))
			{
				if($file != "." && $file != ".." ){
					if(is_dir('./galeries' . '/' .$file))
						$dir_galeries[$cpt]=$file;
				}
				$cpt++;
			}
			closedir($handle);

		}
		return $dir_galeries;
	}
}