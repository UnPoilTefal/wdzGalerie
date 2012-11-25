<?php
class Gallery_model_xml extends CI_Model {

	private $CI;

	private $allowed_types = array('png','jpg','jpeg','gif');

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

			// Cr�ation d'une instance de la classe DOMImplementation
			$imp = new DOMImplementation;

			// Cr�ation d'une instance DOMDocumentType
			$dtd = $imp->createDocumentType('gallery', '', base_url().'/wdzGalleryContent.dtd');
			/*
			 // Cr�ation d'une instance DOMDocument
			$document = $imp->createDocument("", "", $dtd);

			// D�finition des autres propri�t�s*/
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

			$galerie_dao->save();

		} else {

			throw new Exception("Echec de sauvegarde de la galerie " . $p_gallery->get_gallery_name() . "Elle doit �tre initialis�e.");

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

		$imagesList = $gallery_xml->get_lst_images();
		$last_image_nb = $gallery_xml->get_nb_existing_images();

		$filename = '';
		$order = '';
		$display = '';
		$caption = '';

		$lst_imgfromdir = $this->getListImageFromDir($p_dir_name);

		$nb_imgfromdir = count($lst_imgfromdir);  //The total count of all the images
		echo $nb_imgfromdir;
		for($x=0; $x < $nb_imgfromdir; $x++){
				
			$alreadyexist = FALSE;
				
			foreach ($imagesList as $currentimage) {
				if ($currentimage->get_filename() === $lst_imgfromdir[$x]) {
					$alreadyexist = TRUE;
					break;
				}
			}
				
			if($alreadyexist == FALSE) {
				$last_image_nb++;

				$filename = $lst_imgfromdir[$x];
				$order = $last_image_nb;
				$display = '1';
				$caption = $gallery_xml->get_gallery_name();
				$url = base_url("/galeries/".$p_dir_name."/images/".$filename);
				$url_thumb = base_url("/galeries/".$p_dir_name."/thumbs/".$filename);

				$gallery_xml->addImage($filename, $order, $display, $caption, $url, $url_thumb);

			}
				
		}

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

	function getListImageFromDir($directory) {

		$lst_imgfromdir = array();

		$dimg = opendir('./galeries/'.$directory.'/images');//Open directory

		while($imgfile = readdir($dimg))
		{
			if( in_array(strtolower(substr($imgfile,-3)),$this->allowed_types) OR
					in_array(strtolower(substr($imgfile,-4)),$this->allowed_types) )
				/*If the file is an image add it to the array*/
			{$lst_imgfromdir[] = $imgfile;
			}
		}

		return $lst_imgfromdir;

	}

}