<?php

class Pages extends CI_Controller {

	public function view($gallery_name = '') {
		
		$num_by_row = 6;
		$num_row = 4;
		
		if ($gallery_name == '')
		{
			show_404(); //TODO personaliser la page
		} else {

			$this->load->helper('html');
			//$this->load->library('displaycontent');
			$this->load->helper('url');
			$this->load->model('gallery_model_xml');

			$data['title'] = ucfirst($gallery_name); // Capitalize the first letter
			$data['pagined_galerie'] = $this->gallery_model_xml->get_pagined_existing_gallery($gallery_name, $num_row, $num_by_row);
			$data['lst_galeries'] = $this->gallery_model_xml->get_list_galeries();
			$galerie = $data['pagined_galerie']['galerie'];
			$this->load->view('templates/global/header', $data);
			if($galerie->is_available()) {
				$this->load->view('pages/view', $data);
			} else {
				$this->load->view('pages/gallery_not_available', $data);
			}
		}
		$this->load->view('templates/global/footer', $data);
		$this->load->view('templates/global/script', $data);
		$this->load->view('pages/screen_script', $data);
		$this->load->view('templates/global/bottom', $data);

	}

	public function accueil() {

		$num_by_row = 4;
		
		$this->load->helper(array('html', 'url'));
		$this->load->model('gallery_model_xml');
		
		$lst_avail_galeries = $this->gallery_model_xml->get_list_available_galeries();
		$row_galeries = array();
		
		$row = 1;
		$col = 1;
		foreach ($lst_avail_galeries as $curr_galerie) {
			$row_galeries[$row][] = $curr_galerie;
			$col++;
			if($col > $num_by_row) {
				$col = 1;
				$row++;
			}
		}
		
		
		$data['lst_galeries'] = $row_galeries;

		$data['title'] = ucfirst('accueil'); // Capitalize the first letter

		$this->load->view('templates/global/header', $data);
		$this->load->view('pages/accueil', $data);
		$this->load->view('templates/global/footer', $data);
		$this->load->view('templates/global/script', $data);
		$this->load->view('templates/global/bottom', $data);

	}
	
	public function lst_galeries_names() {
		$this->load->helper(array('html', 'url'));
		$this->load->model('gallery_model_xml');
		$lst_avail_galeries_names = $this->gallery_model_xml->get_list_galeries_names();
		
		echo json_encode($lst_avail_galeries_names);
		
	}
	
	public function get_galerie_url_by_name($p_gallery_name) {
		
		log_message('debug','get_galerie_url_by_name : ' . $p_gallery_name);
		$this->load->helper(array('html', 'url'));
		$this->load->model('gallery_model_xml');
				
		echo base_url(index_page().'/pages/view/' . $this->gallery_model_xml->search_galerie_by_name(urldecode($p_gallery_name))); 
	
	}
	
}
