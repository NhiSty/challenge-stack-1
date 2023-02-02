<?php

namespace App\DataFixtures;

use App\Entity\Speciality;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Users extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // PWD = test123!
        $pwd = '$2y$13$Fs05Q7OWSMIj6ZwxXitCiu9m5fmqp35aSrMNmlV0xND1rY6DnPWUO';

        $specialitys = $manager->getRepository(Speciality::class)->findAll();

        $spec1 = $specialitys[0];
        $spec2 = $specialitys[1];
        $spec3 = $specialitys[2];

        $object = (new User())
            ->setEmail('nico.bar2012@gmail.com')
            ->setRoles(['ROLE_USER'])
            ->setPassword($pwd)
            ->setIsVerified(true)
            ->setClinicId(null)
            ->setSpeciality($spec1)
            ->setFirstname("Nicolas")
            ->setLastname("Barbarisi")
            ->setGender("h")
        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('thomas.jallu@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($pwd)
            ->setIsVerified(true)
            ->setClinicId(null)
            ->setSpeciality($spec2)
            ->setFirstname("Thomas")
            ->setLastname("Jallu")
            ->setGender("h")
        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('serkan.dev67@gmail.com')
            ->setRoles(['ROLE_PRACTICIEN'])
            ->setPassword($pwd)
            ->setIsVerified(true)
            ->setClinicId(null)
            ->setSpeciality($spec3)
            ->setFirstname("Serkan")
            ->setLastname("Deveci")
            ->setGender("h")

        ;
        $manager->persist($object);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            Speciality::class
        ];
    }
}