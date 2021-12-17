<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\FileUploadException;
use App\Exceptions\InvalidTypeFileException;
use App\Exceptions\NoUploadedFileException;
use App\Exceptions\TooBigFileException;
use App\FlashMessage;
use App\Movie;
use App\Registry;
use App\Repository\MovieRepository;
use App\UploadedFileHandler;

class MovieController {
    const MAX_SIZE = 1024*1000;
    private MovieRepository $movieRepository;

    public function __construct() {
        $this->movieRepository = new MovieRepository();
    }

    public function list() {
        $message = FlashMessage::get("message");
        $movies = $this->movieRepository->findAll();
        $logger = Registry::get(Registry::LOGGER);
        $logger->info("S'ha executat una consulta");
        require __DIR__ . "/../../views/index.view.php";
    }

    public function edit(int $id) {
        $movie = $this->movieRepository->find();
        $data = $movie->toArray();
        if (empty($data)) {
            throw new \Exception("La pel·lícula seleccionada no existeix");
        }
        $validTypes = ["image/jpeg", "image/jpg"];
        $errors = [];
        if (isPost()) {
            $data["title"] = clean($_POST["title"]);
            $data["overview"] = clean($_POST["overview"]);
            $data["release_date"] = $_POST["release_date"];
            try {
                $uploadFileHandler = new UploadedFileHandler("poster", ["image/jpeg"], self::MAX_SIZE);
                $data["poster"] = $uploadFileHandler->handle("poster");
            } catch (NoUploadedFileException $e) {
                //No es fa res perque es valid
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
        require __DIR__ . "/../../views/movies-edit.view.php";
    }
}