<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Genre;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TypeFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        $categorie = $manager->getRepository(Categorie::class)->findAll();
        for($i=0;$i<36;$i++)
        {
            $type = new Type();
            $type->setIntitule($faker->word);
            $type->setIdCategorie($faker->randomElement($categorie));
            $manager->persist($type);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [CategorieFixture::class];
    }

}