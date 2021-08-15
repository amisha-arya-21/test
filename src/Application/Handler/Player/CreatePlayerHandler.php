<?php

namespace Test\Application\Handler\Player;

use Exception;
use Test\Domain\Player\Player;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Test\Domain\Player\PlayerRepositoryInterface;

class CreatePlayerHandler
{

    private $playerRepository, $encoder;

    public function __construct(PlayerRepositoryInterface $playerRepository, UserPasswordHasherInterface $encoder)
    {
        $this->playerRepository = $playerRepository;
        $this->encoder = $encoder;
    }
    /**
     * @param array $playerArray
     * @throws Exception
     */
    public function handle(array $playerArray)
    {
        $player = new Player();
        $player->setUsername($playerArray['username']);
        $player->setEmail($playerArray['email']);
        $player->setAvatar($playerArray['avatar']);
        $player->setPassword(
            $this->encoder->hashPassword($player, $playerArray['password'])
        );

        try {
            $this->playerRepository->save($player);
        } catch (Exception $exception) {
            throw new Exception ('User can not be saved');
        }

    }

}