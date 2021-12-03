<?php

namespace App\Mapper;

use App\Movie;
use App\Registry;
use PDO;

class MovieMapper
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Registry::get("PDO");
    }

    public function find(int $id): ?Movie
    {
    }

    public function findAll(): array {
    }

    public function insert(Movie $obj)
    {
        $data = $obj->toArray();
        unset($data["id"]);
        $stmt = $this->pdo->prepare("INSERT INTO movie(title, overview, release_date, rating, poster) 
        VALUES (:title, :overview, :release_date, :rating, :poster)");
        $stmt->execute($data);
        $obj->setId($this->pdo->lastInsertId());
    }

    public function update(Movie $object)
    {
    }
}