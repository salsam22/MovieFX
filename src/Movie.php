<?php
class Movie {
    private int $id;
    private string $title;
    private string $overview;
    private string $releaseDate;
    private float $starsRating;
    private string $poster;
    const POSTER_PATH = "images";

    /**
     * Movie constructor.
     * @param int $id
     * @param string $title
     * @param string $overview
     * @param string $releaseDate
     * @param float $starsRating
     * @param string $poster
     */
    public function __construct(int $id, string $title, string $overview, string $releaseDate, float $starsRating, string $poster)
    {
        $this->id = $id;
        $this->title = $title;
        $this->overview = $overview;
        $this->releaseDate = $releaseDate;
        $this->starsRating = $starsRating;
        $this->poster = $poster;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
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
    public function getStarsRating(): float
    {
        return $this->starsRating;
    }

    /**
     * @param float $starsRating
     */
    public function setStarsRating(float $starsRating): void
    {
        $this->starsRating = $starsRating;
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


}