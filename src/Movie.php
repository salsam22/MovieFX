<?php
declare(strict_types=1);

namespace App;
use Webmozart\Assert\Assert;

class Movie
{
    const POSTER_PATH = "posters";
    public ?int $id;
    private string $title;
    private string $overview;
    private string $releaseDate;
    private float $rating;
    private int $voters;
    private string $poster;

    /**
     * @param int $id
     * @param string $title
     * @param string $overview
     * @param string $releaseDate
     * @param float $rating
     * @param string $poster
     */
    public function __construct(?int $id, string $title, string $overview, string $releaseDate, float $rating, string $poster)
    {
        $this->id = $id;
        $this->title = $title;
        $this->overview = $overview;
        $this->releaseDate = $releaseDate;
        $this->rating = $rating;
        $this->poster = $poster;
    }


    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param ?int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        Assert::lengthBetween($title, 1, 100);
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     */
    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return string
     */
    public function getPoster(): string
    {
        return $this->poster;
    }

    /**
     * @param string $poster
     */
    public function setPoster(string $poster): void
    {
        $this->poster = $poster;
    }

    /**
     * @return int
     */
    public function getVoters(): int
    {
        return $this->voters;
    }

    /**
     * @param int $voters
     */
    public function setVoters(int $voters): void
    {
        $this->voters = $voters;
    }

    public static function fromArray(array $raw)
    {

        return new Movie(
            (int)$raw["id"],
            $raw["title"],
            $raw["overview"],
            $raw["release_date"],
            (float)$raw["rating"],
            $raw["poster"]
        );
    }

}