<?php

class galerie {
	
	private $gallery_name;
	private $hl_pic;
	private $remote_gallery;
	private $lst_images;
	
	function __construct($p_gallery_name) {
		
		$this->gallery_name = $p_gallery_name;
		$this->hl_pic = null;
		$this->remote_gallery = false;
		$this->lst_images = array(); 
		
	}
	
}