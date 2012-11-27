<?php
class Gallery_model_xml extends CI_Model {

	private $CI;

	private $allowed_types = array('png','jpg','jpeg','gif');

	public function __construct()
	{
		parent::__construct();
	}
	public function get_pagined_existing_gallery($p_dir_name, $p_num_row = 4, $p_num_by_row = 6) {
		
		$pagined_galerie = array();
		
		$galerie = $this->get_existing_gallery($p_dir_name);
		
		$num_images_by_page = $p_num_row * $p_num_by_row;
		
		$page_number = 1;
		//$image_number = 1;
		$row = 1;
		$col = 1;
		$pagined_galerie['num_row'] = $p_num_row;
		$pagined_galerie['num_by_row'] = $p_num_by_row;
		$pagined_galerie['gallery_name'] = $galerie->get_gallery_name();
		
		foreach ($galerie->get_lst_images() as $image) {

			$pagined_galerie['pages'][$page_number]['num_min'] = (($page_number - 1) * $num_images_by_page) + 1;
			$pagined_galerie['pages'][$page_number]['num_max'] = $page_number * $num_images_by_page;
				
			$pagined_galerie['pages'][$page_number]['row_'.$row]['col_'.$col] = $image;
			$col++;
			if($col > $p_num_row ) {
				$col = 1;
				$row++;
			}
			if($row > $p_num_row) {
				$row = 1;
				$page_number++;
			}
			
		}
		
		$pagined_galerie['max_page'] = $page_number;
		
	}
	public function get_existing_gallery($dir_name) {
		$galerie = new Galerie($dir_name);

		if($this->is_gallery_ok($dir_name)) {

			$galerie->set_available(TRUE);

			$galerie_dao = new Galerie_xml_dao($dir_name);

			$galerie->set_hl_pic($galerie_dao->get_hl_pic());

			$galerie->set_gallery_name($galerie_dao->get_gallery_name());

			$galerie->set_remote_gallery($galerie_dao->get_remote() === 'TRUE');

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

	public function get_list_not_available_local_galeries() {
	
		$lst_not_avail = array();
	
		$lst_galeries = $this->get_list_galeries();
	
		foreach ($lst_galeries as $galerie) {
			if(!$galerie->is_available() && !$galerie->is_remote_gallery()) {
				array_push($lst_not_avail, $galerie);
			}
		}
	
		return $lst_not_avail;
	}
	public function get_list_local_galeries() {
	
		$lst_local = array();
	
		$lst_galeries = $this->get_list_galeries();
	
		foreach ($lst_galeries as $galerie) {
			if($galerie->is_available() && !$galerie->is_remote_gallery()) {
				array_push($lst_local, $galerie);
			}
		}
	
		return $lst_local;
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
			$dtd = $imp->createDocumentType('root', '', base_url().'/wdzGalleryContent.dtd');
			
			 // Cr�ation d'une instance DOMDocument
			$document = $imp->createDocument("", "", $dtd);
			$root = $document->createElement('root');
			$root = $document->appendChild($root);
				
			// D�finition des autres propri�t�s
			$existingxml->encoding = 'UTF-8';
			$existingxml->standalone = false;
			//$existingxml->implementation = $dtd;
			$node = $existingxml->getElementsByTagName("gallery")->item(0);
			//TODO Ajouter controle avec dtd
			
			$node = $document->importNode($node, true);
			// Et on l'ajoute dans le le noeud racine "<root>"
			$document->documentElement->appendChild($node);
			/*
			// nous voulons un bel affichage
			$document->formatOutput = true;
				
			$child = $document->importNode($existingxml->documentElement, TRUE);
			$document->documentElement->appendChild($child, true);
				*/
			$document->saveHTMLFile("d:\ctrlxml.xml");
			
			//$existingxml->replaceChild($dtd, $existingxml->doctype);
				
			if(@$document->validate()) {
			$value['status'] = TRUE;
			}

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
		
		$dir_images_exists = $this->is_images_dir_exists($p_dir_name);
		
		if($dir_images_exists['status'] === FALSE) {
			echo 'Create dir images';
			$this->create_images_dir($p_dir_name);
		} 

		$gallery_xml = new Galerie_xml_dao($p_dir_name);
		
		$imagesList = $gallery_xml->get_lst_images();
		$last_image_nb = $gallery_xml->get_nb_existing_images();

		$filename = '';
		$order = '';
		$display = '';
		$caption = '';

		$lst_imgfromdir = $this->getListImageFromDir($p_dir_name);

		$nb_imgfromdir = count($lst_imgfromdir);  //The total count of all the images
		
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
	private function create_images_dir($p_dir_name) {
		
		return @mkdir('./galeries/' . $p_dir_name . '/images');
		
	}
	private function create_thumbs_dir($p_dir_name) {
		
		return @mkdir('./galeries/' . $p_dir_name . '/thumbs');
		
	}
	
	private function imagethumb($p_dir_name, $image_src , $image_dest = NULL , $max_size = 100, $expand = FALSE, $square = FALSE ) {
		$image_dest = './galeries/' . $p_dir_name . '/thumbs/' . $image_src;
		$image_src = './galeries/' . $p_dir_name . '/images/' . $image_src;
	
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
	
	public function get_lst_miniatures($p_dir_name) {
		
		$result['lst_miniatures'] = array();
		
		$dir_thumbs_exists = $this->is_thumbs_dir_exists($p_dir_name);
		
		$galerie = $this->get_existing_gallery($p_dir_name);
		
		if(!$dir_thumbs_exists['status']) {
			
			$this->create_thumbs_dir($p_dir_name);
		}	
			
		foreach ($galerie->get_lst_images() as $image) {
				
			if(!file_exists($image->get_thumb_url())) {
				$result['lst_miniatures'][] = $image->get_filename();
				
			}	
				
		}
			
		return $result;
		
	}
	
	public function create_thumb($galerie_name, $filename) {
		
		return $this->imagethumb(urldecode($galerie_name), urldecode($filename),'',220);
	}
}