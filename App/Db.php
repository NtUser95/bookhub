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
     * @throws \Exception
     */
    public function execute(String $query, array $params = [])
    {
        $stmt = null;
        if (!is_array($params) || !$params) {
            $stmt = $this->pdo->query($query);
        } else {
            $i = 1;
            $stmt = $this->pdo->prepare($query);
            foreach ($params as $key => &$value) {
                $stmt->bindParam($i++, $value);
            }
            $stmt->execute();
        }

        if (is_null($stmt) || $this->pdo->errorInfo()[0] !== '00000') {
            throw new \Exception(json_encode($this->pdo->errorInfo()));
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
