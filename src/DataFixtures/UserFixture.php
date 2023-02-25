<?php

namespace App\DataFixtures;

use App\Entity\Clinic;
use App\Entity\Speciality;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // PWD = test123!
        $pwd = '$2y$13$Fs05Q7OWSMIj6ZwxXitCiu9m5fmqp35aSrMNmlV0xND1rY6DnPWUO';

        $specialitys = $manager->getRepository(Speciality::class)->findAll();
        $clinics = $manager->getRepository(Clinic::class)->findAll();


        for ($i=0; $i<10; $i++) {
            $object = (new User())
                ->setEmail($faker->email)
                ->setRoles($faker->randomElement([['ROLE_USER'], ['ROLE_ADMIN'], ['ROLE_PRATICIEN']]))
                ->setPassword($pwd)
                ->setPlainPassword('test123!')
                ->setIsVerified($faker->boolean)
                ->setClinicId($faker->randomElement($clinics))
                ->setSpeciality($faker->randomElement($specialitys))
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setGender($faker->randomElement(['h', 'f']))
            ;
            $manager->persist($object);
        }

        $object = (new User())
            ->setEmail('nico.bar2012@gmail.com')
            ->setRoles(['ROLE_USER'])
            ->setPassword($pwd)
            ->setPlainPassword('test123!')
            ->setIsVerified(true)
            ->setClinicId($faker->randomElement($clinics))
            ->setSpeciality($faker->randomElement($specialitys))
            ->setFirstname("Nicolas")
            ->setLastname("Barbarisi")
            ->setGender("h")
        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('thomas.jallu@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($pwd)
            ->setPlainPassword('test123!')
            ->setIsVerified(true)
            ->setClinicId($faker->randomElement($clinics))
            ->setSpeciality($faker->randomElement($specialitys))
            ->setFirstname("Thomas")
            ->setLastname("Jallu")
            ->setGender("h")
        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('serkan.dev67@gmail.com')
            ->setRoles(['ROLE_PRATICIEN'])
            ->setPassword($pwd)
            ->setPlainPassword('test123!')
            ->setIsVerified(true)
            ->setClinicId($faker->randomElement($clinics))
            ->setSpeciality($faker->randomElement($specialitys))
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
            SpecialityFixture::class,
            ClinicFixture::class
        ];
    }
}