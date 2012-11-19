<?php
class Gallery_model_xml extends CI_Model {
	
	private $CI;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_existing_gallery($dir_name) {
		$gallery = array();
		$galerie = new Galerie($dir_name);
		
		if($this->is_gallery_ok($dir_name)) {
			
			$gallery['available'] = TRUE;
			$galerie->set_available(TRUE);
			
			$gallery_path = FCPATH.'galeries/' . $dir_name;
			$xml_url = $gallery_path . '/' . $dir_name.'GalleryContent.xml';
			
			$existingxml = new DOMDocument();
			
			$existingxml->load($xml_url);
			$gallery_root = $existingxml->firstChild;
			
			$galerie->set_hl_pic($gallery_root->getAttribute('hl'));
			$galerie->set_gallery_name($gallery_root->getAttribute('galleryname'));
			$gallery['name'] = $gallery_root->getAttribute('galleryname');
			
			$gallery['dir_name'] = $dir_name;
			$gallery['lst_images'] = array();
			
			$existingimages = $existingxml->getElementsByTagName('image');
			
			if($existingimages->length > 0) {
				$tableauimages = $this->getImageArrayFromImageNode($existingimages);
			
				usort($tableauimages, array($this, 'sort_by_order_attr'));
			
				$nb_existingimg = count($tableauimages);
			
				$nb_order = 0;
				if($nb_existingimg > 0) {
					foreach ($tableauimages as $existingimage) {
						$nb_order++;
						$current_image = new Image($existingimage['image']->getAttribute('filename'));
						$image = array();							
						$image['filename'] = $existingimage['image']->getAttribute('filename');
						
						$current_image->set_url($existingimage['image']->getAttribute('url'));
						$image['src'] = $existingimage['image']->getAttribute('url');
						
						$current_image->set_order($nb_order);
						$image['order'] = $nb_order;
						
						$current_image->set_display($existingimage['image']->getAttribute('display'));
						$image['display'] = $existingimage['image']->getAttribute('display');
						
						$current_image->set_caption($existingimage['caption']);
						$image['caption'] = $existingimage['caption'];
						
						$current_image->set_thumb_url($existingimage['thumb']);
						$image['thumb'] = $existingimage['thumb'];
						//$this->addImage($filename, $order, $display, $caption);
						$galerie->add_image($current_image);
						$gallery['lst_images'][]= $image;
					}
				}
			}
				
		} else {
			$gallery['available'] = FALSE;
			$galerie->set_available(FALSE);
		}
		return $gallery;
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
				$imagecontent['thumb'] = $thumb->getAttribute('thumburl');
			}
			$lst_images[] = $imagecontent;
		}
		return $lst_images;
	}
	
	public function check_status_gallery($gallery_name) {
		
		$check_lst = array('gallery_dir' => FALSE, 'images_dir' => FALSE, 'thumbs_dir' => FALSE, 'gallery_xml_file_exists' => FALSE, 'thumb_files_ok' => FALSE);
		
		$check_lst['gallery_dir'] = $this->is_gallery_dir_exists($gallery_name);
		$check_lst['images_dir'] = $this->is_images_dir_exists($gallery_name);
		$check_lst['thumbs_dir'] = $this->is_thumbs_dir_exists($gallery_name);
		$check_lst['gallery_xml_file_exists'] = $this->is_gallery_xml_file_exists($gallery_name);
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
	
	private function sort_by_order_attr($a, $b)	{
		return (int) $a['image']->getAttribute('order') - (int) $b['image']->getAttribute('order');
	}
	
	public function get_list_galeries() {
		$lst_galeries = new ArrayObject();
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
		
		foreach ($dir_galeries as $dir_name) {
			
			$test_xml_file = $this->is_gallery_xml_file_exists($dir_name);
			$current_galerie = new Galerie($dir_name);
			
			if($test_xml_file['status']) {
				$current_galerie = $this->get_existing_gallery($dir_name); 
				/*
				$gallery_path = './galeries/' . $dir_name;
				$xml_url = $gallery_path . '/' . $dir_name.'GalleryContent.xml';
					
				$current_xml = new DOMDocument();
				$current_xml->load($xml_url);
				
				$gallery_nodes_lst = $current_xml->getElementsByTagName('gallery');
				foreach ($gallery_nodes_lst as $gallery) {
					$lst_galeries[$dir_name]['gallery_name'] = $gallery->getAttribute('galleryname');
					$lst_galeries[$dir_name]['hl'] = $gallery->getAttribute('hl');
					$lst_galeries[$dir_name]['dir_name'] = $dir_name;
				}
				*/
				
				
			} else {
				/*				
				$lst_galeries[$dir_name]['gallery_name'] = $dir_name.'KO';
				$lst_galeries[$dir_name]['hl'] = '';
				$lst_galeries[$dir_name]['dir_name'] = $dir_name;
				*/
			}
			$lst_galeries->append(serialize($current_galerie));
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
}