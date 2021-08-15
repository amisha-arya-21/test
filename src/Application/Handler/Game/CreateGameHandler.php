<?php

namespace Test\Application\Handler\Game;

use DateTimeImmutable;
use Exception;
use Test\Domain\Game\Game;
use Test\Domain\Game\GameRepositoryInterface;
use Test\Domain\League\LeagueRepositoryInterface;
use Test\Domain\Team\TeamRepositoryInterface;

class CreateGameHandler
{

    private $gameRepository;
    private $teamRepository;
    private $leagueRepository;

    public function __construct(
        GameRepositoryInterface $gameRepository,
        TeamRepositoryInterface $teamRepository,
        LeagueRepositoryInterface $leagueRepository
    )
    {
        $this->gameRepository = $gameRepository;
        $this->teamRepository = $teamRepository;
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @param array $game
     * @throws Exception
     */
    public function handle(array $game): void
    {
        $homeTeam = $this->teamRepository->findOneBy(['name' => $game['homeTeam']]);
        $awayTeam = $this->teamRepository->findOneBy(['name' => $game['awayTeam']]);
        $league = $this->leagueRepository->findOneBy(['leagueApiId' => $game['leagueApiId']]);

        if (!$homeTeam) {
            throw new Exception($game['awayTeam']." is not the part of our database");
        }

        if (!$awayTeam) {
            throw new Exception($game['awayTeam']." is not the part of our database");
        }

        if (!$league) {
            throw new Exception($game['leagueApiId']." League is not the part of our database");
        }

        $gameTime = new DateTimeImmutable($game['gameTime']);

        $game = new Game();
        $game->setHomeTeam($homeTeam);
        $game->setLeague($league);
        $game->setAwayTeam($awayTeam);
        $game->setGameTime($gameTime);

        $this->gameRepository->save($game);
    }
}
