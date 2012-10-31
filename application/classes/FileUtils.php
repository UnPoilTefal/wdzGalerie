<?php
class FileUtils {
	function create_dir($path) {
		if (!@mkdir($path,0777,true)) {
			$error = error_get_last();
			throw new Exception("Echec de creation du repertoire " . $path . " : " . $error['message']);
		}
	}
	
	function remove_dir($path) {
		;
	}
	
	function grant_all_acces($path) {
		
		if(file_exists($path)) {
			chmod($path, 0777);
		}
		
	}
	
}