<?php

class ConfigEnv{
	
	private $web_url;
	private $file_url;
	
	function __construct(){
		$server_root = __DIR__ . '/../..';/*$_SERVER['DOCUMENT_ROOT'];*/
		$gallery_root = $server_root . '/galeries';
		
		$this->web_url='galeries';
		$this->file_url= $gallery_root;
		
	}
	
	function getWebUrl() {
		return $this->web_url;
	}
	
	function getFileUrl() {
		return $this->file_url;
	}
	
}



?>