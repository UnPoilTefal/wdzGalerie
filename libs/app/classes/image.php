<?php

class Image {
	
	private $parent_galerie;
	private $filename;
	private $order;
	private $display;
	private $url = '';
	private $thumb_url = '';
	private $caption = '';
	
	function __construct($p_filename) {
		
		$this->filename = $p_filename;
		$this->order = 1;
		$this->display = TRUE;
				
	}
	
	//Setters
	public function set_parent_galerie($p_parent_galerie) {
		$this->parent_galerie = $p_parent_galerie;
	}
	
	public function set_filename($p_filename) {
		$this->filename = $p_filename;
	}
	
	public function set_order($p_order) {
		$this->order = $p_order;
	}
	
	public function set_display($p_display) {
		$this->display = $p_display;
	}
	
	public function set_caption($p_caption) {
		$this->caption = $p_caption;
	}
	
	public function set_url($p_url) {
		$this->url = $p_url;
	}
	
	public function set_thumb_url($p_thumb_url) {
		$this->thumb_url = $p_thumb_url;	
	}
	
	//Getters
	public function get_parent_galerie() {
		return $this->parent_galerie;
	}
	
	public function get_filename() {
		return $this->filename;
	}
	
	public function get_order() {
		return $this->order;
	}
	
	public function get_display() {
		return $this->display;
	}
	
	public function get_caption() {
		return $this->caption;
	}
	
	public function get_url() {
		return $this->url;
	}
	
	public function get_thumb_url() {
		return $this->thumb_url;
	}
	
}