<?php

namespace App\DataFixtures;

use App\Entity\DocumentStorage;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DocumentStoragesFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        $users = $manager->getRepository(User::class)->findAll();

        for ($i=0; $i<10; $i++) {
            $object = (new DocumentStorage())
                ->setName($faker->sentence(2))
                ->setDescription($faker->paragraph(1))
                ->setUserId($users[$i])
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