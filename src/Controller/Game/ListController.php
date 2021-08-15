<?php

namespace Test\Controller\Game;

use Exception;
use Test\Application\Handler\Game\ListGameHandler;
use Test\Domain\Game\Game;
use Test\Domain\League\League;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListController extends AbstractController
{

    private $listGameHandler;

    public function __construct(
        ListGameHandler $listGameHandler
    )
    {
        $this->listGameHandler = $listGameHandler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $games = $this->listGameHandler->handle(
            $request->get('week'),
            $request->get('league')
        );

        $allGames = [];

        /** @var Game $game */
        foreach ($games as $game) {
            $allGames[] = [
                'id' => $game->getId(),
                'homeTeam' => $game->getHomeTeam()->getName(),
                'awayTeam' => $game->getAwayTeam()->getName(),
                'homeTeamLogo' => $game->getHomeTeam()->getLogo(),
                'awayTeamLogo' => $game->getAwayTeam()->getLogo(),
                'gameTime' => $game->getGameTime()->format('H:i'),
                'score' => $game->getScore(),
                'day' => $game->getGameTime()->format('l'),
                'guess' => $game->hasPlayerGuessed($this->getUser() ?? null)
            ];
        }

        return new JsonResponse($allGames);
    }
}
