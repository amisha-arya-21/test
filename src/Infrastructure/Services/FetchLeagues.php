<?php

namespace Test\Infrastructure\Services;

use Symfony\Component\String\Slugger\AsciiSlugger;

class FetchLeagues implements FetchLeaguesInterface
{
    private $provider;

    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function fetch(array $input = []): array
    {
        $leagues = $this->provider->getContent($input);

        $leagueArr = [];

        foreach ($leagues['api']['leagues'] as $league) {
            $leagueArr[] = [
                'leagueApiId' => $league['league_id'],
                'name' => $league['name'],
                'logo' => $league['logo'],
                'leagueNameSlugged' => strtolower((new AsciiSlugger())->slug($league['name'])->toString())
            ];
        }

        return $leagueArr;
    }
}
