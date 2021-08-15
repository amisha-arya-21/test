<?php

namespace Test\Infrastructure\Command;

use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Test\Application\Handler\League\CreateLeagueHandler;
use Test\Infrastructure\Services\FetchLeaguesInterface;
use Symfony\Component\Console\Command\Command;

class FetchLeaguesCommand extends Command
{
    protected static $defaultName = 'app:fetch-leagues';
    private $createLeagueHandler;
    private $fetcherService;

    public function __construct(CreateLeagueHandler $createLeagueHandler, FetchLeaguesInterface $fetcherService, string $name = null)
    {
        $this->createLeagueHandler = $createLeagueHandler;
        $this->fetcherService = $fetcherService;
        parent::__construct($name);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $leagues = $this->fetcherService->fetch([]);

        foreach ($leagues as $league) {
            try {
                $this->createLeagueHandler->handle($league);
                $output->writeln($league['name']." saved");
            } catch (Exception $e) {
                $output->writeln($e->getMessage());
            }
        }

        $output->writeln('Leagues are created');

        return Command::SUCCESS;
    }
}