<?php

namespace Test\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Test\Domain\League\League;
use Test\Domain\Player\Player;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $league = new League();
        $league->setId(1);
        $league->setName("Premier");
        $league->setLeagueNameSlugged("premier");
        $league->setLeagueApiId(123);
        $league->setLogo("premier.png");

        $manager->persist($league);

        $player = new Player();
        $player->setUsername("A");
        $player->setEmail("a@gmail.com");
        $player->setPassword($this->encoder->hashPassword($player,"123456789"));

        $manager->persist($player);

        $manager->flush();
    }
}
