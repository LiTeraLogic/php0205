<?php
namespace App\models;

use App\services\DB;

/**
 * Class Model
 * @package App\models
 */
abstract class Model
{
    /**
     * @var DB
     */
    protected $db;

    abstract protected static function getTableName(): string;


    /*
     * Good constructor.
     *  IDB $db
     */
    /**
     * Good constructor.
     * @param DB $db
     */
    function __construct()
    {
        $this->db = static::getDB();
    }

    protected static function getDB(): DB
    {
        return DB::getInstance();
    }


    public static function getOne($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return static::getDB()->queryObject($sql, static::class, [':id' => $id]);
    }

    public static function getAll()
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return static::getDB()->queryObjects($sql, static::class);
    }

    protected function insert()//сохранение в бд
    {
        $className = get_class($this);

        foreach ($this as $key => $property) {
            if ($key == 'id')
            {
                continue;
            }

            $methodName = "set" . ucfirst($key);

            $patterns = '/([a-z])([A-Z])/';
            $replacements = '${1}_${2}';
            $nameColumn = preg_replace($patterns, $replacements, $key);
            $nameColumn = mb_strtolower($nameColumn);

            if (method_exists($className, $methodName)) {
                $this->$methodName($property);

                $keys[] = $nameColumn;

                $sendValues[":{$key}"] = $property;

            }
        }

        $columns = implode(', ', $keys);
        $values = implode(', ', array_keys($sendValues));

        $tableName = static::getTableName();
        $sql = "INSERT INTO {$tableName} ($columns) VALUES ({$values})";

        $result = $this->db->executeInsertId($sql, $sendValues);
        $this->setId($result);
    }


    protected function update()//обновление  в бд
    {
        $values = array();
        $className = get_class($this);

        foreach ($this as $key => $property){
            $methodName = "set" . ucfirst($key);

            $patterns = '/([a-z])([A-Z])/';
            $replacements =  '${1}_${2}';
            $nameColumn = preg_replace($patterns, $replacements, $key);
            $nameColumn = mb_strtolower($nameColumn);

            if (method_exists($className, $methodName)) {
                $this->$methodName($property);

                $values[] = $nameColumn . '=:' . $key;
                $sendValues[":{$key}"] = $property;
            }
        }
        $values = implode(', ', $values);

        $tableName = static::getTableName();
        $sql = "UPDATE {$tableName} SET {$values} WHERE id = :id";
        $this->db->execute($sql, $sendValues);
    }

    public function delete()//обновление  в бд
    {
        $tableName = static::getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id = :id";
        $this->db->execute($sql, [':id' => $this->id]);
    }

    public function save()//обновление  в бд
    {
        if (!($this->id)){
            $this->insert();
            echo "Вызвана функция insert<br>";
            return;
        }
        $this->update();
        echo "Вызвана функция update<br>";
    }


}