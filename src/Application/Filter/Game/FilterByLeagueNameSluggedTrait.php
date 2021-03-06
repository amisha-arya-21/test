<?php

namespace Test\Application\Filter\Game;

use Test\Domain\Game\Game;

trait FilterByLeagueNameSluggedTrait
{
    public function filter(array $games, string $leagueNameSlugged): array
    {
        $filteredArr = [];

        /** @var Game $game */
        foreach ($games as $game) {
            if ($game->getLeague()->getLeagueNameSlugged() == $leagueNameSlugged) {
                $filteredArr[] = $game;
            }
        }

        return $filteredArr;
    }
}
