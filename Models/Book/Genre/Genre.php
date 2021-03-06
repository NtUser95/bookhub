<?php

namespace Models\Book\Genre;

use App\App;

class Genre
{
    /** @var int */
    private $_id;
    /** @var string */
    private $_name;

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->_name = $name;
    }

    /**
     * @param array $data
     * @return Genre
     * @throws \Exception
     */
    public static function create($data = [])
    {
        if (!isset($data['name'])) {
            throw new \Exception('Invalid params for create object:' . json_encode($data));
        }

        $genre = new Genre();
        $genre->setName($data['name']);

        if (isset($data['id']) && $data['id']) {
            $genre->_id = (int)$data['id'];
        } else {
            $sql = 'INSERT INTO genres (`name`) VALUES ( :name );';
            App::$db->execute($sql, [
                ':name' => $data['name'],
            ]);
            $genre->_id = (int)App::$db->getLastInsertId();
        }

        return $genre;
    }
}