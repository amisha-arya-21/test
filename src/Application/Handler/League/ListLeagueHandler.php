<?php

namespace Test\Application\Handler\League;

use Test\Domain\League\LeagueRepositoryInterface;

class ListLeagueHandler
{
    private $leagueRepository;

    public function __construct(LeagueRepositoryInterface $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->leagueRepository->findAll();
    }
}
