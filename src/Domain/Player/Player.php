<?php

namespace Test\Domain\Player;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Test\Domain\Game\Game;
use Test\Domain\Player\Guess;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method string getUserIdentifier()
 */
class Player implements UserInterface
{
    const RIGHT_GUESS_POINT = 3;

    private $id;
    private $username;
    private $password;
    private $email;
    private $createdAt;
    private $updatedAt;
    private $point;
    private $avatar;
    private $isActive;
    private $guesses;

    public function __construct()
    {
        $this->avatar = 1;
        $this->point = 0;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->isActive = true;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeImmutable $updatedAt
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getPoint(): int
    {
        return $this->point;
    }

    /**
     * @param int $point
     */
    public function setPoint(int $point): void
    {
        $this->point = $point;
    }

    /**
     * @return int
     */
    public function getAvatar(): int
    {
        return $this->avatar;
    }

    /**
     * @param int $avatar
     */
    public function setAvatar(int $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
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

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    /**
     * @param Game $game
     * @param int $homeTeamGuess
     * @param int $awayTeamGuess
     * @throws Exception
     */
    public function makeGuesses(Game $game, int $homeTeamGuess, int $awayTeamGuess)
    {
        if ((new DateTimeImmutable()) > $game->getGameTime()) {
            throw new Exception("Starting time passed for this game, cant make a guess");
        }

        $guess = new Guess();
        $guess->setPlayer($this);
        $guess->setGame($game);
        $guess->setCreatedAt(new DateTimeImmutable());
        $guess->setGuess($homeTeamGuess.'-'.$awayTeamGuess);

        $this->guesses->add($guess);
        $game->addGuess($guess);
    }

    public function pointUp(): void
    {
        $this->point += self::RIGHT_GUESS_POINT;
    }
}