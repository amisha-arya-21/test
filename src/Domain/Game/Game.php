<?php

namespace Test\Domain\Game;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Test\Domain\Player\Guess;

class Game
{
    private $id;
    private $score;
    private $homeTeam;
    private $awayTeam;
    private $gameTime;
    private $guesses;
    private $league;

    public function __construct()
    {
        $this->guesses = new ArrayCollection();
    }
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
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score): void
    {
        $this->score = $score;
    }

    /**
     * @return mixed
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * @param mixed $homeTeam
     */
    public function setHomeTeam($homeTeam): void
    {
        $this->homeTeam = $homeTeam;
    }

    /**
     * @return mixed
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    /**
     * @param mixed $awayTeam
     */
    public function setAwayTeam($awayTeam): void
    {
        $this->awayTeam = $awayTeam;
    }

    /**
     * @return mixed
     */
    public function getGameTime()
    {
        return $this->gameTime;
    }

    /**
     * @param mixed $gameTime
     */
    public function setGameTime($gameTime): void
    {
        $this->gameTime = $gameTime;
    }

    /**
     * @return mixed
     */
    public function getGuesses()
    {
        return $this->guesses;
    }

    /**
     * @param mixed $guesses
     */
    public function setGuesses($guesses): void
    {
        $this->guesses = $guesses;
    }

    /**
     * @return mixed
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * @param mixed $league
     */
    public function setLeague($league): void
    {
        $this->league = $league;
    }

    /**
     * @param string $score
     * @throws Exception
     */
    public function completed(string $score)
    {
        if (new DateTimeImmutable() < $this->getGameTime()) {
            throw new Exception('This game has not started yet');
        }

        $this->setScore($score);

        /** @var Guess $guess */
        foreach ($this->guesses as $guess) {
            if ($guess->getGuess() == $score) {
                $guess->getPlayer()->pointUp();
            }
        }
    }

    public function addGuess(Guess $guess) {
        $this->guesses->add($guess);
    }


}