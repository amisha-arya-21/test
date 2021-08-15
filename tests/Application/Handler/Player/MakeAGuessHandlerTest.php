<?php

namespace Test\Tests\Application\Handler\Player;

use DateTimeImmutable;
use Exception;
use Test\Application\Handler\Player\MakeAGuessHandler;
use Test\Domain\Game\Game;
use Test\Domain\Player\Player;
use Test\Domain\Team\Team;
use Test\Memory\Repository\GameRepository;
use Test\Memory\Repository\PlayerRepository;
use PHPUnit\Framework\TestCase;

class MakeAGuessHandlerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testMakeAGuess()
    {
        $this->expectException(Exception::class);

        $player = new Player();
        $player->setUsername('fmo');

        $homeTeam = new Team();
        $homeTeam->setName('Liverpool');

        $awayTeam = new Team();
        $awayTeam->setName('Arsenal');

        $game = new Game();
        $game->setId(333);
        $game->setGameTime(new DateTimeImmutable('tomorrow'));
        $game->setHomeTeam($homeTeam->getName());
        $game->setAwayTeam($awayTeam->getName());

        $playerRepository = new PlayerRepository();
        $playerRepository->save($player);

        $gameRepository = new GameRepository();
        $gameRepository->save($game);

        $makeAGuess = new MakeAGuessHandler($playerRepository, $gameRepository);
        $makeAGuess->handle([
            'username' => 'fmo',
            'gameId' => 333,
            'guess' => '4-4'
        ]);

        $makeAGuess->handle([
            'username' => 'fmo',
            'gameId' => 323,
            'guess' => '4-4'
        ]);

        $this->assertEquals('4-4', $player->getGuess($game)->getGuess());
    }
}