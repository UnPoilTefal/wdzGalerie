<?php
function __autoload($className) {
	require_once $className.'.php';
}

/*function __autoload ($class)
{
	$path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
		require_once($path . '.php');
    
}*/
$configEnv = new ConfigEnv();
$dispContent = new DisplayContent();

?>