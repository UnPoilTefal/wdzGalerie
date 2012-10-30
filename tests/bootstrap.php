<?php
function __autoload($className) {
	$pathLib = __DIR__ . '/../application/classes/';
    $file = $className . '.php';    
    require_once $pathLib . $file;
 
}
function loader($class)
{
	$pathLib = __DIR__ . '/../application/classes/';
    $file = $class . '.php';
    if (file_exists($pathLib. $file)) {
        require $pathLib . $file;
    } 
}

spl_autoload_register('loader');