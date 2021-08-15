<?php

namespace Test\Application\Handler\League;

use Exception;
use Test\Domain\League\League;
use Test\Domain\League\LeagueRepositoryInterface;

class CreateLeagueHandler
{
    private $leagueRepository;

    public function __construct(
        LeagueRepositoryInterface $leagueRepository,
    )
    {
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @param array $leagueArray
     * @throws Exception
     */
    public function handle(array $leagueArray): void
    {
        if ($this->leagueRepository->findOneBy(['name' => $leagueArray['name']])) {
            throw new Exception('League already saved');
        }

        $league = new League();
        $league->setName($leagueArray['name']);
        $league->setLeagueNameSlugged($leagueArray['leagueNameSlugged']);
        $league->setLeagueApiId($leagueArray['leagueApiId']);
        $league->setLogo($leagueArray['logo']);

        $this->leagueRepository->save($league);
    }
}
