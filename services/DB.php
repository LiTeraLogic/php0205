<?php
namespace App\services;

//class DB implements  IDB
use App\models\Good;
use PDO;

/**
 * Class DB
 * @package App\services
 */
class DB
{
   use TSingleton;

    protected $connection;

    private $config = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'shop',
        'charset' => 'UTF8',
        'port' => '3307',
        'username' => 'root',
        'password' => ''
    ];

    /**
     * @return PDO
     */
    protected function getConnection()
    {
            if (empty($this->connection)){
                $this->connection =  new PDO(
                    $this->getDsn(),
                    $this->config['username'],
                    $this->config['password']
                );
                $this->connection->setAttribute(
                    PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC
                );
            }

        return $this->connection;
    }

    private function getDsn()
    {
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s;port=%s',
                $this->config['driver'],
                $this->config['host'],
                $this->config['dbname'],
                $this->config['charset'],
                $this->config['port']

        );
    }

    //для классов
    protected function query(string $sql, array $params = [])
    {
        $PDOStatement = $this->getConnection()->prepare($sql);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

//    public function find($sql, $className, array $params = [] )
//    {
//        return  $this->query($sql, $params)->fetchObject($className);
//    }
    public function find($sql, array $params = [] )
    {
        return $this->query($sql, $params)->fetch();
    }

    public function find2($sql, $className, array $params = [] )
    {
        $this->query($sql, $params);
        return $this->connection->lastInsertId();

    }

    //    создать метод безответных запросов
    public function execute($sql, array $params = [])//обновление  в бд
    {
        $this->query($sql, $params);
    }

    public function executeInsertId($sql, array $params = [] )
    {
        $this->query($sql, $params);
        return $this->connection->lastInsertId();

    }

    public function findAll($sql, array $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function queryObject($sql, $class, array $params = [] )
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, $class);
        return $PDOStatement->fetch();

    }

    public function queryObjects($sql, $class, array $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, $class);
        return $PDOStatement->fetchAll();

        // return $this->query($sql, $params)->fetchAll(\PDO::FETCH_CLASS, $className);
    }



}