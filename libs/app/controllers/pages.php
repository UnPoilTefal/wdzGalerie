<?php

class Pages extends CI_Controller {

	public function view($galleryName)
	{
		$this->load->helper('html');
		$this->load->library('displaycontent');
		$this->load->helper('url');
		
		$params = array('galleryname' => $galleryName, 'initmode' => FALSE);
		
		$this->load->library('gallerycontent', $params);
		
		$data['title'] = ucfirst($galleryName); // Capitalize the first letter
		$data['galleryname'] = $galleryName;
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/screen', $data);
		$this->load->view('templates/footer', $data);
		
	}
	
	public function accueil() {
		
		$this->load->helper('html');
		$this->load->helper('url');
		
		$this->load->library('displaycontent');
		
		$data['title'] = ucfirst('accueil'); // Capitalize the first letter
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/accueil', $data);
		$this->load->view('templates/footer', $data);
		
	}
}
