<?php

class Admin extends CI_Controller {

	public function edit_gallery($p_dir_name) {
		
		$this->load->helper(array('html','url'));
		
		$this->load->model('gallery_model_xml');
		$data['gallery'] = $this->gallery_model_xml->get_existing_gallery($p_dir_name);
		$data['title'] = ucfirst('edition'); // Capitalize the first letter
		
		$this->load->view('templates/global/header', $data);
		$this->load->view('admin/global/edit_gallery', $data);
		$this->load->view('templates/global/footer', $data);
		$this->load->view('templates/global/script', $data);
		$this->load->view('templates/global/bottom', $data);
		
	}
	public function edit_images($p_dir_name) {
	
		$this->load->library('user_agent');
		$this->load->helper(array('html','url'));
	
		$this->load->model('gallery_model_xml');
		$data['gallery'] = $this->gallery_model_xml->get_existing_gallery($p_dir_name);
		$data['title'] = ucfirst('edition'); // Capitalize the first letter
	
		$this->load->view('templates/global/header', $data);
		$this->load->view('admin/global/edit_images', $data);
		$this->load->view('templates/global/footer', $data);
		$this->load->view('templates/global/script', $data);
		$this->load->view('templates/global/bottom', $data);
	
	}
	
	public function sort($gallery_name = '')
	{
		
		if($gallery_name === '') {
			show_404();
		}
		
		$this->load->library('user_agent');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->model('gallery_model_xml');
			
		$data['gallery'] = $this->gallery_model_xml->get_existing_gallery($gallery_name);

		$data['title'] = ucfirst($gallery_name); // Capitalize the first letter

		$this->load->view('templates/global/header', $data);
		$this->load->view('admin/global/sort', $data);
		$this->load->view('templates/global/footer', $data);

	}
	public function init($gallery_name = '') {

		if($gallery_name === '') {
			show_404();
		}
		
		$this->load->library('user_agent');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->model('gallery_model_xml');

		$data['title'] = ucfirst($gallery_name); // Capitalize the first letter
		$data['galleryname'] = $gallery_name;
		$data['result'] = $this->gallery_model_xml->init_gallery_xml($gallery_name);

		$this->load->view('templates/global/header', $data);
		$this->load->view('admin/global/init', $data);
		$this->load->view('templates/global/footer', $data);
		$this->load->view('templates/global/script', $data);
		$this->load->view('templates/global/bottom', $data);
		

	}

	public function sort_galerie() {

		$this->load->helper('url');
		$this->load->model('gallery_model_xml');

		try {
			$data = $_POST['images'];
			$gallery_name = $_POST['galleryname'];

			$galerie = $this->gallery_model_xml->get_existing_gallery($gallery_name);
				
			$this->gallery_model_xml->sort_gallery_and_save($galerie, $data);
				
			echo '<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					<strong>Gallery status :</strong> Updated.</p>
					</div>';


		} catch (Exception $e) {
			echo '<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Gallery status :</strong> Error during sort action.' . $e->getPrevious()->getMessage() . '</p></div>';
		}

	}
	public function genminiature($galerie, $filename = '') {

		$this->load->helper('url');
		$this->load->model('gallery_model_xml');

		$return_value = $this->gallery_model_xml->create_thumb(urldecode($galerie), urldecode($filename));
		if($return_value) {
			echo 'TRUE';
		} else {
			echo 'FALSE';
		}

	}
	public function accueil() {

		$this->load->helper(array('html','url'));
		$this->load->library('user_agent');
		
		$this->load->model('gallery_model_xml');
		$data['lst_galeries'] = $this->gallery_model_xml->get_list_galeries();
		$data['lst_avail_galeries'] = $this->gallery_model_xml->get_list_available_galeries();
		$data['lst_not_avail_galeries'] = $this->gallery_model_xml->get_list_not_available_galeries();
		$data['lst_local_galeries'] = $this->gallery_model_xml->get_list_local_galeries();
		$data['title'] = ucfirst('accueil'); // Capitalize the first letter

		$this->load->view('templates/global/header', $data);
		$this->load->view('admin/global/accueil', $data);
		$this->load->view('templates/global/footer', $data);
		$this->load->view('templates/global/script', $data);
		$this->load->view('templates/global/bottom', $data);
			
	}

	public function  miniature($p_dir_name = '') {
		
		if($p_dir_name === '') {
			show_404();
		}
		$this->load->library('user_agent');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->model('gallery_model_xml');
		$galerie = $this->gallery_model_xml->get_existing_gallery($p_dir_name);

		$data['title'] = ucfirst('miniatures'); // Capitalize the first letter
		$data['galerie'] = $galerie;

		$data['lst_filename'] = $this->gallery_model_xml->get_lst_miniatures($p_dir_name);

		$this->load->view('templates/global/header', $data);
		$this->load->view('admin/global/miniatures', $data);
		$this->load->view('templates/global/footer', $data);
		$this->load->view('templates/global/script', $data);
		$this->load->view('admin/global/miniature_script', $data);
		$this->load->view('templates/global/bottom', $data);

	}
	public function status($p_dir_name = '') {

		if($p_dir_name === '') {
			show_404();
		}
		
		$this->load->helper('html');
		$this->load->helper('url');

		$this->load->model('gallery_model_xml');

		$data['title'] = ucfirst('status'); // Capitalize the first letter
		$data['gallery'] = $this->gallery_model_xml->get_existing_gallery($p_dir_name);
		$check_lst = $this->gallery_model_xml->check_status_gallery($p_dir_name);

		$table_lst = array();
		$table_lst[] = $this->check_lst_disp_values('Repertoire de la galerie', $check_lst['gallery_dir']);
		$table_lst[] = $this->check_lst_disp_values('Repertoire des images', $check_lst['images_dir']);
		$table_lst[] = $this->check_lst_disp_values('Repertoire des miniatures', $check_lst['thumbs_dir']);
		$table_lst[] = $this->check_lst_disp_values('Fichier XML present', $check_lst['gallery_xml_file_exists']);
		$table_lst[] = $this->check_lst_disp_values('Fichier XML valide', $check_lst['gallery_xml_file_valid']);
		$table_lst[] = $this->check_lst_disp_values('Fichiers de miniatures', $check_lst['thumb_files_ok']);

		$data['check_lst'] = $table_lst;
		$this->load->view('templates/global/header', $data);
		$this->load->view('admin/global/status', $data);
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

	public function generateadf() {
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->model('gallery_model_xml');
		$gallery_name = 'adf';

		$data['title'] = ucfirst($gallery_name); // Capitalize the first letter
		$data['galleryname'] = $gallery_name;
		$data['result'] = $this->gallery_model_xml->generate_adf(); //$this->xmlgallery->generate_adf();

		$this->load->view('templates/global/header', $data);
		$this->load->view('admin/global/init', $data);
		$this->load->view('templates/global/footer', $data);

	}
}