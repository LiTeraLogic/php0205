<?php
namespace App\services;

class Autoload
{
    private $dirs = [
        "models",
        "services"
    ];

    public function loadClass($className)
    {
        $file = str_replace("App\\", "/", $className);
        $file =  dirname(__DIR__) . "{$file}.php";
        $file = str_replace("\\", "/", $file);

        if (file_exists($file)) {
            include $file;
        }
    }
}