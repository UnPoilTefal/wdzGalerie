<?php

class Pages extends CI_Controller {

	public function view($gallery_name = '') {
		
		if ($gallery_name == '')
		{
			show_404(); //TODO personaliser la page
		} else {
			
			$this->load->library('user_agent');
			$this->load->helper(array('html','url'));
			$this->load->model('gallery_model_xml');
			
			//Chargement des valeurs par defaut
			$num_by_row = 6;
			$num_row = 4;

			$template_type = 'global';
			$data['lst_galeries'] = $this->gallery_model_xml->get_list_galeries();
				
			//Override
			if ($this->agent->is_mobile()) {
					
				
				if ($this->agent->is_mobile('iphone'))
				{
					$template_type = 'mobile';
					$num_by_row = 2;
					$num_row = 0;
								
				}
				
			}

			$data['pagined_galerie'] = $this->gallery_model_xml->get_pagined_existing_gallery($gallery_name, $num_row, $num_by_row);
			$galerie = $data['pagined_galerie']['galerie'];
				
			$data['title'] = ucfirst($galerie->get_gallery_name()); // Capitalize the first letter
			
			$this->load->view('templates/'. $template_type . '/header', $data);
			if($galerie->is_available()) {
				$this->load->view('pages/'. $template_type . '/view', $data);
			} else {
				$this->load->view('pages/'. $template_type . '/gallery_not_available', $data);
			}
			
			$this->load->view('templates/'. $template_type . '/footer', $data);
			$this->load->view('templates/'. $template_type . '/script', $data);
			$this->load->view('pages/'. $template_type . '/screen_script', $data);
			$this->load->view('templates/'. $template_type . '/bottom', $data);
				
		}

	}

	public function accueil() {
		
		$this->load->library('user_agent');
		$this->load->helper(array('html', 'url'));
		$this->load->model('gallery_model_xml');

		$template_type = 'global';
		$lst_avail_galeries = $this->gallery_model_xml->get_list_available_galeries();
		$row_galeries = array();
		$num_by_row = 4;
		
		//Override
		if ($this->agent->is_mobile()) {
		
			if ($this->agent->is_mobile('iphone'))
			{
				$template_type = 'mobile';
				$num_by_row = 2;
				
			}
		
		}

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
		
		$this->load->view('templates/'. $template_type . '/header', $data);
		$this->load->view('pages/'. $template_type . '/accueil', $data);
		$this->load->view('templates/'. $template_type . '/footer', $data);
		$this->load->view('templates/'. $template_type . '/script', $data);
		$this->load->view('templates/'. $template_type . '/bottom', $data);

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
