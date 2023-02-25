<?php

namespace App\DataFixtures;

use App\Entity\Appointment;
use App\Entity\Consultation;
use App\Entity\Drug;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class AppointmentFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $users = $manager->getRepository(User::class)->findAll();
        $consultations = $manager->getRepository(Consultation::class)->findAll();
        $drugs = $manager->getRepository(Drug::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $appointment = (new Appointment())
                ->setDate($faker->dateTime())
                ->setPatientId($users[$i]->getId())
                ->setConsultationId($faker->randomElement($consultations))
                ->setDrugId($faker->randomElement($drugs))
                ->setSlot($faker->dateTime()->format('H:i'))
            ;
            $manager->persist($appointment);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixture::class,
            ConsultationFixture::class,
            DrugFixture::class
        ];
    }
}
