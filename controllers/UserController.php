<?php
namespace App\controllers;
use App\models\User;

class UserController extends Controller
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
        $user = User::getOne($id);
        return $this->render('userOne', ['user' => $user]);
    }

    public function allAction()
    {
        $users =  User::getAll();
        return $this->render('userAll', ['users' => $users]);
    }
}