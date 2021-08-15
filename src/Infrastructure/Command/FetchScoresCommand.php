<?php

namespace Test\Infrastructure\Command;

use Exception;
use Test\Application\Handler\Game\GameOverHandler;
use Test\Domain\Game\Game;
use Test\Infrastructure\Services\FetchGamesInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchScoresCommand extends Command
{
    protected static $defaultName = 'app:fetch-scores';
    private $fetchGames;
    private $gameOverHandler;

    public function __construct(
        FetchGamesInterface $fetchGames,
        GameOverHandler $gameOverHandler
    )
    {
        $this->fetchGames = $fetchGames;
        $this->gameOverHandler = $gameOverHandler;

        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $games = $this->fetchGames->fetch(
            ['days' => $input->getArgument('days')]
        );

        /** @var Game $game */
        foreach ($games as $game) {
            try {

                $this->gameOverHandler->handle((array)$game);

                $output->writeln(
                    "Score is saved: " .
                    $game['score'] .
                    " for " .
                    $game['homeTeam'].
                    " - " .
                    $game['awayTeam']
                );

            } catch (Exception $e) {
                $output->writeln($e->getMessage());
            }
        }

        $output->writeln('Games are created');

        return Command::SUCCESS;
    }

    protected function configure()
    {
        parent::configure();

        $this->addArgument('days', InputArgument::REQUIRED);
    }
}
