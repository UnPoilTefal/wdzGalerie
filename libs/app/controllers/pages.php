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
		$data['lst_galeries'] = $this->gallery_model_xml->get_list_galeries();
		$this->load->view('templates/global/header', $data);
		if($data['gallery']->is_available()) {
			$this->load->view('pages/view', $data);
		} else {
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
		
		$data['lst_galeries'] = $this->gallery_model_xml->get_list_galeries();
/*
		$lst_galeries = $this->gallery_model_xml->get_list_galeries();
		foreach ($lst_galeries as $galerie) {
			var_dump($galerie->get_hl_pic());
			var_dump($galerie->hl_pic);
		}*/
		
		$data['title'] = ucfirst('accueil'); // Capitalize the first letter
		
		$this->load->view('templates/global/header', $data);
		$this->load->view('pages/accueil', $data);
		$this->load->view('templates/global/footer', $data);
		$this->load->view('templates/global/script', $data);
		$this->load->view('templates/global/bottom', $data);
		
	}
}
