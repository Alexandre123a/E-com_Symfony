<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GenreFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        for ($i=0;$i< 4;$i++)
        {
            $genre = new Genre();
            $genre->setIntitule($faker->word);
            $manager->persist($genre);

        }
        $manager->flush();
    }

}