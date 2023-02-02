<?php

namespace App\DataFixtures;

use App\Entity\Clinic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Clinics extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $object = (new Clinic())
            ->setName("Clinique du coin")
            ->setCountry("France")
            ->setCity("Paris")
            ->setAddress("1 Rue De La Mer Noire")
        ;
        $manager->persist($object);


        $object = (new Clinic())
            ->setName("Clinique médicale")
            ->setCountry("France")
            ->setCity("Paris")
            ->setAddress("2 Avenue Des Souhaits")
        ;

        $manager->persist($object);


        $object = (new Clinic())
            ->setName("Clinique ViTaVie")
            ->setCountry("France")
            ->setCity("Paris")
            ->setAddress("3 Route De La Marne")
        ;

        $manager->persist($object);

        $manager->flush();
    }
}
