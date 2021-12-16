<?php
declare(strict_types=1);
class MovieController {
    public function list() {
        $mapper = new App\Mapper\MovieMapper();
        $movieRepository = new \App\Repository\MovieRepository($mapper);
        $movies = $movieRepository->find()
    }
    public function edit(int $id) {
        echo "Editant la pelicula #{$id}";
    }
}