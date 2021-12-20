<?php
declare(strict_types=1);


namespace App;


class Response
{
    private int $status;
    private string $mimeType;
    private string $view;
    private string $layout = "default";
    private array $data;

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return Response
     */
    public function setData(array $data): Response
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @param string $view
     */
    public function setView(string $view): self
    {
        $this->view = $view;

        return $this;
    }

    public function __construct(int $status = 200, string $mimeType = "text/html")
    {
        $this->status = $status;
        $this->mimeType = $mimeType;
    }

    public function writeHeaders(): void
    {
        switch ($this->status) {
            case 200:
                $statusMsg = "200 OK";
                break;
            case 404:
                $statusMsg = "404 Not found";
                break;
        }
        header($_SERVER["SERVER_PROTOCOL"] . " " . $statusMsg);
        header("Content-Type: {$this->mimeType}");
    }

    public function render(): string {

        extract($this->data);

        ob_start();
        require __DIR__ . "/../views/{$this->view}.view.php";
        return ob_get_clean();
        /*$content = ob_get_clean();*/

        ob_start();
        require __DIR__ . "/../layouts/{$this->layout}.layout.php";

        return ob_get_clean();
    }

    /**
     * @param mixed $element
     * @param int $httpStatus
     * @return string
     */
    public function jsonResponse(array $element, int $httpStatus = 200): string
    {
        header($_SERVER["SERVER_PROTOCOL"] . ' ' . $httpStatus);
        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($element);
    }
}