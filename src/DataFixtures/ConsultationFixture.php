<?php

namespace App\DataFixtures;

use App\Entity\Consultation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ConsultationFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        for ($i=0; $i<10; $i++) {
            $object = (new Consultation())
                ->setName($faker->sentence(3))
                ->setDescription($faker->paragraph(3))
            ;
            $manager->persist($object);
        }
        $manager->flush();
    }
}