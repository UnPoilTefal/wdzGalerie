<?php

class Admin extends CI_Controller {
	
	public function sort($galleryName)
	{
		$this->load->helper('html');
		$this->load->library('displaycontent');
		$this->load->helper('url');
	
		$params = array('galleryname' => $galleryName, 'initmode' => FALSE);
		try {
			$this->load->library('gallerycontent', $params);
		} catch (Exception $e) {
			show_error($e->getMessage());
		}
		
	
		$data['title'] = ucfirst($galleryName); // Capitalize the first letter
		$data['galleryname'] = $galleryName;
	
		$this->load->view('templates/header', $data);
		$this->load->view('admin/sort', $data);
		$this->load->view('templates/footer', $data);
	
	}
	public function init($gallery_name) {

		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('xmlgallery');
		
		$params = array('galleryname' => $gallery_name, 'initmode' => TRUE);
		try {
			$this->load->library('gallerycontent', $params);
		} catch (Exception $e) {
			show_error($e->getMessage());
		}
		
		$data['title'] = ucfirst($gallery_name); // Capitalize the first letter
		$data['galleryname'] = $gallery_name;
		$data['result'] = $this->xmlgallery->generateXml($gallery_name);
		
		$this->load->view('templates/header', $data);
		$this->load->view('admin/init', $data);
		$this->load->view('templates/footer', $data);
		
		
	}
	
	public function sort_galerie() {
		
		$this->load->helper('url');
		
		try {
		$data = $_POST['images'];
		$galleryname = $_POST['galleryname'];
		
		$this->load->library('xmlgallery');
		$params = array('galleryname' => $galleryname, 'initmode' => FALSE);
		
			$this->load->library('gallerycontent', $params);
		
		
		$this->xmlgallery->sortGallery($galleryname, $data);
		
		echo '<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		<strong>Gallery status :</strong> Updated.</p>
		</div>';
		
		
		} catch (Exception $e) {
			echo '<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Gallery status :</strong> Error during sort action.' . $e->getPrevious()->getMessage() . '</p></div>';
		}
		
	}
	
	public function accueil() {
	
		$this->load->helper('html');
		$this->load->helper('url');
	
		//$this->load->library('displaycontent');
		$this->load->model('gallery_model_xml');
		$data['lst_galeries'] = $this->gallery_model_xml->get_list_galeries();
		
		$data['title'] = ucfirst('accueil'); // Capitalize the first letter
	
		$this->load->view('templates/global/header', $data);
		$this->load->view('admin/accueil', $data);
		$this->load->view('templates/global/footer', $data);
		$this->load->view('templates/global/script', $data);
		$this->load->view('templates/global/bottom', $data);
			
	}
	public function status($gallery_name) {
		
		$this->load->helper('html');
		$this->load->helper('url');
		
		//$this->load->library('displaycontent');
		$this->load->model('gallery_model_xml');
		
		$data['title'] = ucfirst('status'); // Capitalize the first letter
		$data['gallery_name'] = $gallery_name;
		$check_lst = $this->gallery_model_xml->check_status_gallery($gallery_name);
		
		$table_lst = array();
		$table_lst[] = $this->check_lst_disp_values('Repertoire de la galerie', $check_lst['gallery_dir']);
		$table_lst[] = $this->check_lst_disp_values('Repertoire des images', $check_lst['images_dir']);
		$table_lst[] = $this->check_lst_disp_values('Repertoire des miniatures', $check_lst['thumbs_dir']);
		$table_lst[] = $this->check_lst_disp_values('Fichier XML de la galerie', $check_lst['gallery_xml_file_exists']);
		$table_lst[] = $this->check_lst_disp_values('Fichiers de miniatures', $check_lst['thumb_files_ok']);
		
		$data['check_lst'] = $table_lst;
		$this->load->view('templates/global/header', $data);
		$this->load->view('admin/status', $data);
		$this->load->view('templates/global/footer', $data);
		$this->load->view('templates/global/script', $data);
		$this->load->view('templates/global/bottom', $data);
		
	}

	private function check_lst_disp_values($libelle, $check_lst_item) {
		
		$return_value = array();
		$return_value['libelle'] = $libelle;
		
		if($check_lst_item['status'] === TRUE) {
			$return_value['class'] = "class='success'";
			$return_value['status'] = "OK";
		} else {
			if($check_lst_item['mandatory'] === TRUE) {
				$return_value['class'] = "class='error'";
				$return_value['status'] = "KO";
			} else {
				$return_value['class'] = "class='warning'";
				$return_value['status'] = "Warning";
			}
		}
		return $return_value;
	}
}