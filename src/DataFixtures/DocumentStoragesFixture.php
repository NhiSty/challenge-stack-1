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

        $userSerk = $manager->getRepository(User::class)->findOneBy(['firstname' => 'Serkan']);

        for ($i=0; $i<10; $i++) {
            $object = (new DocumentStorage())
                ->setName("12abcm1453fs0_hero.PNG")
                ->setDescription($faker->paragraph(1))
                ->setUserId($users[$i])
            ;
            $manager->persist($object);
        }

        $object = (new DocumentStorage())
            ->setName("63ebfc3258ac2_cni.PNG")
            ->setDescription("CNI")
            ->setUserId($userSerk)
        ;
        $manager->persist($object);

        $object = (new DocumentStorage())
            ->setName("63eqsc3038fo8_diplome.pdf")
            ->setDescription("Diplome")
            ->setUserId($userSerk)
        ;
        $manager->persist($object);
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}