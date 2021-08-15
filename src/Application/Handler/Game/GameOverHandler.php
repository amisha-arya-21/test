<?php

namespace Test\Application\Handler\Game;

use DateTimeImmutable;
use Exception;
use Test\Domain\Game\Game;
use Test\Domain\Game\GameRepositoryInterface;
use Test\Domain\Team\TeamRepositoryInterface;

class GameOverHandler
{
    private $gameRepository;
    private $teamRepository;

    public function __construct(
        GameRepositoryInterface $gameRepository,
        TeamRepositoryInterface $teamRepository
    )
    {
        $this->gameRepository = $gameRepository;
        $this->teamRepository = $teamRepository;
    }

    /**
     * @param array $gameFromApi
     * @throws Exception
     */
    public function handle(array $gameFromApi)
    {
        if (!isset($gameFromApi['score'])) {
            throw new Exception('Need score to finish the game');
        }

        $homeTeam = $this->teamRepository->findOneBy(['name' => $gameFromApi['homeTeam']]);
        $awayTeam = $this->teamRepository->findOneBy(['name' => $gameFromApi['awayTeam']]);

        if (!$homeTeam) {
            throw new Exception($gameFromApi['homeTeam']. ' is not the part of our database');
        }

        if (!$awayTeam) {
            throw new Exception($gameFromApi['awayTeam']. ' is not the part of our database');
        }

        /** @var Game $game */
        $game = $this->gameRepository->findOneBy(
            [
                'homeTeam' => $homeTeam,
                'awayTeam' => $awayTeam,
                'gameTime' => new DateTimeImmutable($gameFromApi['gameTime'])
            ]
        );

        if (!$game) {
            throw new Exception('Game between ' . $homeTeam->getName() . ' - ' . $awayTeam->getName() . ' is not stored');
        }

        $game->completed($gameFromApi['score']);

        $this->gameRepository->save($game);
    }

}
