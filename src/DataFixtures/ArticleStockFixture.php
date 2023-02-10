<?php

namespace App\DataFixtures;

use App\Entity\ArticleStock;
use App\Entity\Categorie;
use App\Entity\Genre;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleStockFixture extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        $type = $manager->getRepository(Type::class)->findAll();
        for ($i=0;$i<100;$i++)
        {
            $categorie = new ArticleStock();
            $categorie->setIntitule($faker->word);
            $categorie->setPrix($faker->numberBetween(1,10000));
            $categorie->setDescription($faker->realText);

            $categorie->setIdType($faker->randomElement($type));
            $manager->persist($categorie);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [TypeFixture::class];
    }

}