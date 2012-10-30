<?php

function loader($class)
{
    $file = $class . '.php';
    if (file_exists('./application/classes/' . $file)) {
        require $file;
    }
}

spl_autoload_register('loader');