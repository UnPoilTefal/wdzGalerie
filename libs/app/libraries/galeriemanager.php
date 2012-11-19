<?php

class galeriemanager {
	
	public function get_existing_galerie($p_dir_name) {
		
		$galerie = new galerie($p_dir_name);
		
		return $galerie;
		
	}
	
	
	
	
	
	
	
	
}