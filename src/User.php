<?php
class User
{
    private int $id;
    private string $username;
    private string $password;

    /**
     * User constructor.
     * @param int $id
     * @param string $username
     * @param string $password
     * @param Plan $plan
     */
    public function __construct(int $id, string $username, string $password, Plan $plan)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->plan = $plan;
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return Plan
     */
    public function getPlan(): Plan
    {
        return $this->plan;
    }

    /**
     * @param Plan $plan
     */
    public function setPlan(Plan $plan): void
    {
        $this->plan = $plan;
    }
    private Plan $plan;

}