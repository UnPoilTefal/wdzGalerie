<?php

class Galerie {
	
	private $dir_name;
	private $gallery_name;
	public $hl_pic;
	private $remote_gallery;
	private $lst_images;
	private $available;
	
	function __construct($p_dir_name) {
		
		$this->available = FALSE;
		$this->dir_name = $p_dir_name;
		$this->gallery_name = $p_dir_name . 'InitClass';
		$this->hl_pic = '';
		$this->remote_gallery = FALSE;
		$this->lst_images = array(); 
		
	}
	
	//Getters
	
	public function get_gallery_name() {
		return $this->gallery_name;
	}
	
	public function get_hl_pic() {
		
		$current_hl_pic = NULL;
		
		foreach ($this->get_lst_images() as $curr_image) {
			
			if ($curr_image->get_filename() === $this->hl_pic) {
				
				$current_hl_pic = $curr_image;
				break;
			} elseif ($curr_image->get_thumb_url() === $this->hl_pic){
				
				$current_hl_pic = $curr_image;
				break;

			}
		}
		
		return $current_hl_pic;
	}
	
	public function is_remote_gallery() {
		return $this->remote_gallery;
	}
	
	public function get_lst_images() {
		return $this->lst_images;		
	}

	public function is_available() {
		return $this->available;
	}
	
	public function get_dir_name() {
		return $this->dir_name;
	}
	
	//Setters
	
	public function set_gallery_name($p_gallery_name) {
		$this->gallery_name = $p_gallery_name;
	}
	
	public function set_hl_pic($p_hl_pic) {
		$this->hl_pic = $p_hl_pic;
	}
	
	public function set_remote_gallery($p_remote_gallery) {
		$this->remote_gallery = $p_remote_gallery;
	}
	
	public function set_lst_images($p_lst_images) {
		$this->lst_images = $p_lst_images;		
	}

	public function set_available($p_available) {
		$this->available = $p_available;
	}
	
	public function add_image(Image $p_image) {
		$p_image->set_parent_galerie($this);
		array_push($this->lst_images, $p_image);
		
	}
	
	public function set_dir_name($p_dir_name) {
		$this->dir_name = $p_dir_name; 
	}
}