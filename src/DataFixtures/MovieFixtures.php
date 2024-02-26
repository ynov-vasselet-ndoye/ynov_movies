<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 30; $i++) {
            $movie = new Movie();

            $movie->setNom($faker->realText($faker->numberBetween(10, 50)));
            $movie->setDescription($faker->realText($faker->numberBetween(128, 256)));
            $movie->setRate($faker->numberBetween(0, 5));
            $movie->setDateDeParution($faker->dateTime());
            $manager->persist($movie);
        }

        $manager->flush();
    }
}