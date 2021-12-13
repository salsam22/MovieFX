<?php

namespace Tests\Dojo;

use App\Mapper\MovieMapper;
use App\Movie;
use App\Repository\MovieRepository;
use PHPUnit\Framework\TestCase;

class MovieRepositoryTest extends TestCase
{
    public function testFindMethodShouldReturnMovieObject():void {
        $mr = new MovieRepository();
        $movie = $mr->find(1);
        $this->assertInstanceOf(Movie::class, $movie);
    }
}