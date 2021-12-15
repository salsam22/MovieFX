<?php

namespace Tests\Dojo;

use App\Mapper\MovieMapper;
use App\Movie;
use App\Repositry\MovieRepository;
use PHPUnit\Framework\TestCase;

class MovieRepositoryTest extends TestCase
{
    public function testFindMethodShouldReturnNullWhenNotFound():void {

        $mapperStub = $this->createMock(MovieMapper::class);
        $mapperStub->method("find")->willReturn(null);
        $mr = new MovieRepository($mapperStub);
        $movie = $mr->find(1);
        $this->assertInstanceOf(null, $movie);
    }
    public function testFindMethodShouldReturnMovieWhenNotFound():void {
        $movieDummy = $this->createPartialMock(MovieMapper::class,[]);
        $mapperStub = $this->createMock(MovieMapper::class);
        $mapperStub->method("find")->willReturn($movieDummy);
        $mr = new MovieRepository($mapperDummy);
        $movie = $mr->find(1);
        $this->assertInstanceOf(Movie::class, $movie);
    }
}