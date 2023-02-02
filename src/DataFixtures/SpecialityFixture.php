<?php

namespace App\DataFixtures;

use App\Entity\Speciality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SpecialityFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        for ($i=0; $i<10; $i++) {
            $object = (new Speciality())
                ->setName($faker->sentence(1))
                ->setDescription($faker->paragraph(2))
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}