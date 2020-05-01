<?php
namespace App\controllers;

use App\models\Good;
class GoodController extends Controller
{
    protected $defaultAction = 'all';

    protected function getDefaultAction():string
    {
        return $this->defaultAction;
    }

    public function oneAction()
    {
        $id = 0;
        if (!empty($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        $good = Good::getOne($id);

        $this->rewriteFromSql($good);
        $nameClass = $this->controllerName;
        return $this->render("{$nameClass}One", [$nameClass => $good]);
    }

    /**
     * @return string
     */
    public function allAction()
    {
        $goods =  Good::getAll();
        foreach ($goods as $good)
        {
            $this->rewriteFromSql($good);
        }
        $nameClass = $this->controllerName;
        return $this->render("{$nameClass}All", ["{$nameClass}s" => $goods]);
    }

}