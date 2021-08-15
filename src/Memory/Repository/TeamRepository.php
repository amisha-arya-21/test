<?php

namespace Test\Memory\Repository;

use Test\Domain\Team\Team;
use Test\Domain\Team\TeamRepositoryInterface;


class TeamRepository implements TeamRepositoryInterface
{
    private $teams;

    public function __construct()
    {
        $this->teams = [];
    }

    public function findOneBy(array $criteria): ?Team
    {
        foreach ($this->teams as $team) {
            if ($team->getName() == $criteria['name']) {
                return $team;
            }
        }

        return null;
    }

    public function getAll(): array
    {
        return $this->teams;
    }

    public function save(Team $team)
    {
        $this->teams[] = $team;
    }
}
