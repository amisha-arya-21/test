<?php

namespace Test\Application\Handler\Game;

use DateTimeImmutable;
use Exception;
use Test\Application\Filter\Game\FilterByLeagueNameSluggedTrait;
use Test\Domain\Game\GameRepositoryInterface;
use Test\Domain\League\League;
use Test\Domain\League\LeagueRepositoryInterface;
use Test\Infrastructure\Doctrine\GameRepository;

class ListGameHandler
{
    use FilterByLeagueNameSluggedTrait;

    private $gameRepository;
    private $leagueRepository;

    public function __construct(
        GameRepositoryInterface $gameRepository,
        LeagueRepositoryInterface $leagueRepository
    )
    {
        $this->gameRepository = $gameRepository;
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @param string $week
     * @param string $leagueNameSlugged
     * @return array
     * @throws Exception
     */
    public function handle(string $week, string $leagueNameSlugged): array
    {
        /** @var League $league */
        $league = $this->leagueRepository->findOneBy([
            'leagueNameSlugged' => $leagueNameSlugged
        ]);

        if (!$league) {
            throw new Exception('Which league matches you want to see?');
        }

        $gamesForGivenWeek = $this->gameRepository->findGamesForGivenWeek(
            new DateTimeImmutable(
                $week ? $week." week" : "now"
            )
        );

        return $this->filter($gamesForGivenWeek, $league->getLeagueNameSlugged());
    }
}
