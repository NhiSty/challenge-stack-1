<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\Clinic;
use App\Entity\Demand;
use App\Entity\Speciality;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Practitioner' => 'ROLE_PRACTITIONER',
                    'Patient' => 'ROLE_PATIENT',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('password')
            ->add('isVerified')
            ->add('firstname')
            ->add('lastname')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'h',
                    'Femme' => 'f',
                ],
                'required' => true,
            ])
            ->add('appointments', EntityType::class, [
                'class' => Appointment::class,
                'choice_label' => 'id',
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('documentStorage')
            ->add('clinicId', EntityType::class, [
                'class' => Clinic::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('speciality', EntityType::class, [
                'class' => Speciality::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
          /*
            ->add('agenda', ChoiceType::class, [
                'choices' => [
                    'Lundi' => 'monday',
                    'Mardi' => 'tuesday',
                    'Mercredi' => 'wednesday',
                    'Jeudi' => 'thursday',
                    'Vendredi' => 'friday',
                    'Samedi' => 'saturday',
                    'Dimanche' => 'sunday',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
          */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
