<?php

namespace App\DataFixtures;

use App\Entity\Speciality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Specialitys extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $object = (new Speciality())
            ->setName("Médecin généraliste")
            ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.")
        ;
        $manager->persist($object);


        $object = (new Speciality())
            ->setName("Vaccinateur")
            ->setDescription("Nulla aliquet enim tortor at auctor urna. Pharetra massa massa ultricies mi quis hendrerit dolor magna eget. Amet venenatis urna cursus eget nunc scelerisque viverra mauris in. Purus sit amet volutpat consequat. Lacinia at quis risus sed. Turpis massa sed elementum tempus. At varius vel pharetra vel turpis nunc. Tincidunt vitae semper quis lectus nulla at volutpat diam ut. Elementum curabitur vitae nunc sed velit dignissim sodales. Viverra accumsan in nisl nisi scelerisque eu. In vitae turpis massa sed elementum tempus.")
        ;

        $manager->persist($object);


        $object = (new Speciality())
            ->setName("Psychologue")
            ->setDescription("Aliquam eleifend mi in nulla. Montes nascetur ridiculus mus mauris. Nunc consequat interdum varius sit amet. Ipsum nunc aliquet bibendum enim facilisis. Ultricies mi quis hendrerit dolor magna. Pellentesque elit eget gravida cum sociis natoque penatibus et magnis. Habitasse platea dictumst quisque sagittis. Eget mi proin sed libero enim. Nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum. Massa tincidunt dui ut ornare lectus sit amet est.")

        ;

        $manager->persist($object);

        $manager->flush();
    }
}