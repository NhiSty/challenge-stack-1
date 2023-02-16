<?php

namespace App\DataFixtures;

use App\Entity\Clinic;
use App\Entity\Demand;
use App\Entity\Speciality;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DemandFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $userSerk = $manager->getRepository(User::class)->findOneBy(['firstname' => 'Serkan']);


        $object = (new Demand())
            ->setApplicant($userSerk)
            ->setFileNames(['63ebfc3258ac2_cni.PNG', '63eqsc3038fo8_diplome.pdf'])
            ->setState(false)
        ;
        $manager->persist($object);
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            SpecialityFixture::class,
            ClinicFixture::class
        ];
    }
}