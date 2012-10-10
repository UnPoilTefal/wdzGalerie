<?php

function __autoload ($class)
{
	$path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
		require_once($path . '.php');
    
}
$configEnv = new application\classes\ConfigEnv();
$dispContent = new application\classes\DisplayContent();

?>