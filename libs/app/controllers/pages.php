<?php

class Pages extends CI_Controller {

	public function view($gallery_name)
	{
		$this->load->helper('html');
		//$this->load->library('displaycontent');
		$this->load->helper('url');
		$this->load->model('gallery_model_xml');

		$data['title'] = ucfirst($gallery_name); // Capitalize the first letter
		$data['gallery'] = $this->gallery_model_xml->get_existing_gallery($gallery_name);
		$data['lst_galeries'] = new ArrayObject($this->gallery_model_xml->get_list_galeries());
		$this->load->view('templates/global/header', $data);
		if($data['gallery']['available'] === TRUE) {
			$this->load->view('pages/view', $data);
		} else {
			$data['gallery']['name'] = $gallery_name; 
			$this->load->view('pages/gallery_not_available', $data);
		}
		$this->load->view('templates/global/footer', $data);
		$this->load->view('templates/global/script', $data);
		$this->load->view('pages/screen_script', $data);
		$this->load->view('templates/global/bottom', $data);
				
	}
	
	public function accueil() {
		
		$this->load->helper('html');
		$this->load->helper('url');
		
		//$this->load->library('displaycontent');
		$this->load->model('gallery_model_xml');
		
		//$data['lst_galeries'] = $this->gallery_model_xml->get_list_galeries();
		$lst_galeries = new ArrayObject($this->gallery_model_xml->get_list_galeries());
		$gal_infos = array();
		foreach ($lst_galeries as $galkey => $s ) {
			//echo 'cle-->'.$galkey . ' - valeur-->' . unserialize($s).'<\br>';
			
			//$gal_object = unserialize($gal); 
			//$gal_id = $gal_object->get_dir_name();
			//$gal_infos[];
		}
		
		
		
		$data['title'] = ucfirst('accueil'); // Capitalize the first letter
		
		$this->load->view('templates/global/header', $data);
		$this->load->view('pages/accueil', $data);
		$this->load->view('templates/global/footer', $data);
		$this->load->view('templates/global/script', $data);
		$this->load->view('templates/global/bottom', $data);
		
	}
}
