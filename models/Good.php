<?php
namespace App\models;

class Good extends Model
{

    protected $id;
    protected $nameGood;
    protected $info;
    protected $price;

    protected $tableName = 'goods';
    protected $className = 'Good';

    protected static function getTableName():string
    {
        return 'goods';
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNameGood()
    {
        return $this->nameGood;
    }

    /**
     * @param mixed $name
     */
    public function setNameGood($name)
    {
        $this->nameGood = $name;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param mixed $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


}