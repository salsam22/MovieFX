<?php

namespace App\Controller;

use App\Mapper\MovieMapper;
use App\Response;
use App\Exceptions\FileUploadException;
use App\Exceptions\NoUploadedFileException;
use App\FlashMessage;
use App\Movie;
use App\Registry;
use App\Repository\MovieRepository;
use App\UploadedFileHandler;

class MovieController
{
    const MAX_SIZE = 1024 * 1000;
    private MovieRepository $movieRepository;

    public function __construct()
    {
        $mapper = new MovieMapper();
        $this->movieRepository = new MovieRepository($mapper);
    }

    public function list(): Response
    {
        $message = FlashMessage::get("message");

        $movies = $this->movieRepository->findAll();

        $logger = Registry::get(Registry::LOGGER);
        $logger->info("s'ha executat una consulta");

        $response = new Response();
        $response->setView("index")->setData(compact("message", "movies", "logger"));
        return $response;

    }

    public function edit(int $id)
    {
        //die("editant la pel·licula $id");

        // $id = $_POST["id"]?? $_GET["id"] ?? null;

        //if (empty($id))
        //    throw new Exception("Id Invalid");
        //else
        //    $id = (int)$id;

        $message = "";
        $movie = $this->movieRepository->find($id);
        $data = $movie->toArray();

        //var_dump($data);
        if (empty($data))
            throw new \Exception("La pel·lícula seleccionada no existeix");


        $validTypes = ["image/jpeg", "image/jpg"];

        $errors = [];

        // per a la vista necessitem saber si s'ha processat el formulari
        if (isPost()) {
            $data["title"] = clean($_POST["title"]);
            $data["overview"] = clean($_POST["overview"]);
            $data["release_date"] = $_POST["release_date"];
            try {
                $uploadedFileHandler = new UploadedFileHandler("poster", ["image/jpeg"], self::MAX_SIZE);
                $data["poster"] = $uploadedFileHandler->handle("posters");

            } catch (NoUploadedFileException $e) {
                // no faig res perquè és una opció vàlida en UPDATE.
            } catch (FileUploadException $e) {
                $errors[] = $e->getMessage();
            }

            if (empty($errors)) {
                try {
                    $movie = Movie::fromArray($data);
                    $this->movieRepository->save($movie);
                    $message = "S'ha actualitzat el registre amb l'ID ({$movie->getId()})";
                } catch (\Exception $e) {
                    $errors[] = $e->getMessage();
                }

            }
        }
        $response = new Response();
        $response->setView("movie-edit");
        $response->setData(compact("message", "errors", "data", "movie"));
        require __DIR__ ."/../../views/movies-edit.view.php";

    }
}