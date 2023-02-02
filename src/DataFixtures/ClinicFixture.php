<?php

namespace App\DataFixtures;

use App\Entity\Clinic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClinicFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        for ($i=0; $i<10; $i++) {
            $object = (new Clinic())
                ->setName($faker->company)
                ->setCountry($faker->country)
                ->setCity($faker->city)
                ->setAddress($faker->address)

            ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}
