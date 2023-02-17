<?php

namespace App\DataFixtures;

use App\Entity\NecessaryDocument;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class NecessaryDocumentFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $object = (new NecessaryDocument())
            ->setName("Carte d'identité")
            ->setDescription("Carte d'identité en cours de validité")
        ;
        $manager->persist($object);

        $object = (new NecessaryDocument())
            ->setName("Diplôme")
            ->setDescription("Diplôme attestant de la formation du praticien")
        ;
        $manager->persist($object);

        $manager->flush();
    }
}