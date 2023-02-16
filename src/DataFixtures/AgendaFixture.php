<?php

namespace App\DataFixtures;

use App\Entity\Agenda;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AgendaFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $users = $manager->getRepository(User::class)->findAll();


        for ($i=0; $i<10; $i++) {
            $object = (new Agenda())
                ->setOwner($users[$i])
                ->setAvailability($faker->randomElements(["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"], $faker->numberBetween(1, 7)))
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}