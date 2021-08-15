<?php

namespace Test\Domain\League;

class League
{
    private $id;
    private $name;
    private $leagueNameSlugged;
    private $logo;
    private $leagueApiId;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLeagueNameSlugged()
    {
        return $this->leagueNameSlugged;
    }

    /**
     * @param mixed $leagueNameSlugged
     */
    public function setLeagueNameSlugged($leagueNameSlugged): void
    {
        $this->leagueNameSlugged = $leagueNameSlugged;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getLeagueApiId()
    {
        return $this->leagueApiId;
    }

    /**
     * @param mixed $leagueApiId
     */
    public function setLeagueApiId($leagueApiId): void
    {
        $this->leagueApiId = $leagueApiId;
    }
}