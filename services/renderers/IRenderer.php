<?php
namespace App\services\renderers;


interface IRenderer
{
    public function render($template, $params = []);
}