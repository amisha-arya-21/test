<?php

namespace Test\Application\Handler\Team;

use Exception;
use Test\Domain\Team\Team;
use Test\Domain\Team\TeamRepositoryInterface;

class CreateTeamHandler
{
    private $teamRepository;
    private $logoUploader;

    public function __construct(
        TeamRepositoryInterface $teamRepository,
    )
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * @param array $team
     * @throws Exception
     */
    public function handle(array $team): void
    {
        if ($this->teamRepository->findOneBy(['name' => $team['name']])) {
            throw new Exception('Team already saved');
        }

        $team = new Team();
        $team->setName($team['name']);
        $team->setLogo($team['logo']);

        $this->teamRepository->save($team);
    }
}
