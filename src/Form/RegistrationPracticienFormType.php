<?php

namespace App\Form;

use App\Entity\Clinic;
use App\Entity\Speciality;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RegistrationPracticienFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
            ])
            -> add('plainPassword', RepeatedType::class, [
                'required' => true,
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les mots de passe ne correspondent pas',
            ])
            ->add('firstname', TextType::class, [
                'required' => true,

            ])
            ->add('lastname', TextType::class, [
                'required' => true,

            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'h',
                    'Femme' => 'f',
                ],
                'required' => true,
            ])
            ->add('speciality', EntityType::class, [
                'required' => true,
                'class' => Speciality::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Choisissez une spécialité',
                'attr' => [
                    'label' => 'Spécialité',
                ],
            ])
            ->add('clinicId', EntityType::class, [
                'required' => true,
                'class' => Clinic::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Choisissez une clinique',
                'attr' => [
                    'label' => 'Clinique',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
