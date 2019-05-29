<?php

namespace App;

use App\Exceptions\DatabaseException;

class Db
{

    public $pdo;

    public function __construct()
    {
        $settings = $this->getPDOSettings();
        $this->pdo = new \PDO($settings['dsn'], $settings['user'], $settings['pass'], null);
    }

    protected function getPDOSettings()
    {
        $config = include ROOT_PATH . '/Config/db.php';
        $result['dsn'] = "{$config['type']}:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        $result['user'] = $config['user'];
        $result['pass'] = $config['pass'];
        return $result;
    }

    /**
     * @param String $query
     * @param array $params
     * @return array
     * @throws DatabaseException
     */
    public function execute(String $query, array $params = [])
    {
        $stmt = null;
        $result = true;
        if (!is_array($params) || !$params) {
            $stmt = $this->pdo->query($query);
        } else {
            $stmt = $this->pdo->prepare($query);
            foreach ($params as $key => $value) {
                if (is_integer($value)) {
                    $stmt->bindValue($key, $value, \PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($key, $value);
                }
            }
            $result = $stmt->execute();
        }

        if (is_null($stmt) || $result === false) {
            throw new DatabaseException($this->pdo->errorInfo());
        }
        return $stmt->fetchAll();
    }

    /**
     * @return int
     */
    public function getLastInsertId(): int
    {
        return (int)$this->pdo->lastInsertId();
    }

}