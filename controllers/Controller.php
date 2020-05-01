<?php

namespace App\controllers;

use App\models\Good;
use App\models\User;
use App\services\renderers\IRenderer;
use App\services\renderers\TmplRenderer;

/**
 * Class Controller
 * @package App\controllers
 */
abstract class Controller
{
    protected $controllerName;
    protected $actionName;
    /**
     * @var TmplRenderer;
     */
    protected $renderer;

    // с помощью интерфейса избавляемся от жесткой зависимости
    function __construct(IRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    abstract protected function getDefaultAction(): string;

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function run($controllerName, $actionName = '')
    {
        $this->controllerName = $controllerName;
        $action = $this->getDefaultAction();
        if (!empty($actionName))
        {
            $action = $actionName;
            if (!method_exists($this, $action . 'Action'))
            {
                $action = $this->getDefaultAction();
            }
        }
        $action .= 'Action';

        return $this->$action();

    }


    protected function render($template, $params = [])
    {
        return $this->renderer->render($template, $params);
    }

    protected function rewriteFromSql($good)
    {
        foreach ($good as $key => $property) {
            if (preg_match('/_/', $key)) {
                $arr = preg_split('/_/', $key);
                $str = $arr[0];
                for ($i = 1; $i < count($arr); $i++) {
                    $str .= ucfirst($arr[$i]);
                }
                $methodName = "set" . $str;
                $good->$methodName($property);
            }
        }
    }
}