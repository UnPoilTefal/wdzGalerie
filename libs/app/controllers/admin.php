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
	public function init($galleryName) {

		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('xmlgallery');
		
		$params = array('galleryname' => $galleryName, 'initmode' => TRUE);
		try {
			$this->load->library('gallerycontent', $params);
		} catch (Exception $e) {
			show_error($e->getMessage());
		}
		
		$data['title'] = ucfirst($galleryName); // Capitalize the first letter
		$data['galleryname'] = $galleryName;
		$data['result'] = $this->xmlgallery->generateXml($galleryName);
		
		$this->load->view('templates/header', $data);
		$this->load->view('admin/init', $data);
		$this->load->view('templates/footer', $data);
		
		
	}
	
	public function sort_galerie() {
		//restore the error_handler to default php
		restore_error_handler();
		
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
		
		//set it back to CI error_handler
		set_error_handler('_exception_handler');
	}
	
	
}