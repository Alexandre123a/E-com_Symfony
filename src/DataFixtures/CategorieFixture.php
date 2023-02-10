<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Genre;
use Faker\Factory;

class CategorieFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        $genre = $manager->getRepository(Genre::class)->findAll();
        for ($i=0;$i<12;$i++)
        {
            $categorie = new Categorie();
            $categorie->setIntitule($faker->word);
            $categorie->setIdGenre($faker->randomElement($genre));
            $manager->persist($categorie);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [GenreFixture::class];
    }
}