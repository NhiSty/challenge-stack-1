<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAccountType extends AbstractType
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
          'first_options' => [
            'label' => 'Mot de passe',
          ],
          'second_options' => [
            'label' => 'Confirmer le mot de passe',
          ],
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
