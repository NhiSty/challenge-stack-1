<?php

namespace App\DataFixtures;

use App\Entity\Drug;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DrugFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i<10; $i++) {
            $object = (new Drug())
                ->setName($faker->sentence(2))
                ->setDescription($faker->paragraph(1))
                ->setPrice($faker->numberBetween(1000, 2000))
                ->setStock($faker->numberBetween(1, 10))
            ;
            $manager->persist($object);
        }
        $manager->flush();
    }
}
