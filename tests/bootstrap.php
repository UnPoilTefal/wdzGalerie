<?php

function loader($class)
{
	$pathLib = __DIR__ . '/../application/classes/';
    $file = $class . '.php';
    if (file_exists($pathLib. $file)) {
        require $pathLib . $file;
    } 
}

spl_autoload_register('loader');