<?php

namespace Test\Infrastructure\Services;

class FetchGames implements FetchGamesInterface
{
    private $provider;

    public function __construct(
        ProviderInterface $provider
    )
    {
        $this->provider = $provider;
    }

    public function fetch(array $input = []): array
    {
        $games = $this->provider->getContent($input);

        $gameList = [];

        foreach ($games['api']['fixtures'] as $game) {
            $gameList[] = [
                'homeTeam' => $game['homeTeam']['team_name'],
                'awayTeam' => $game['awayTeam']['team_name'],
                'gameTime' => $game['event_date'],
                'leagueApiId' => $game['league_id'] ?? null,
                'score' => $game['score']['fulltime']
            ];
        }

        return $gameList;
    }


}
