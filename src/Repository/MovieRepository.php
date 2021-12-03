<?php

declare(strict_types=1);

use App\Mapper\MovieMapper;
use App\Movie;

class MovieRepository
{
    public MovieMapper $mapper;
    public function __construct()
    {
        $this->mapper = new MovieMapper();
    }

    public function save(Movie $movie) {
        $this->mapper->insert($movie);
    }

    public function find(int $id):?Movie {
    }

    public function findAll():array {
    }

    public function delete(Movie $movie) {

    }
}