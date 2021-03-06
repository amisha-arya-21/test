<?php

namespace Test\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Test\Domain\Player\Player;
use Test\Domain\Player\PlayerRepositoryInterface;

class PlayerRepository extends ServiceEntityRepository implements PlayerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    /**
     * @param Player $player
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Player $player)
    {
        $this->_em->persist($player);
        $this->_em->flush();
    }
}
