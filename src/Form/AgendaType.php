<?php

namespace App\Form;

use App\Entity\Agenda;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AgendaType extends AbstractType
{
    private readonly TokenStorageInterface $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('availabilityDays', ChoiceType::class, [
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
            ->add('slotsDuration', NumberType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 60,
                ],
                'mapped' => false,
                'required' => true,
            ])
            ->add('slotsStart', TimeType::class, [
                'mapped' => false,
            ])
            ->add('slotsEnd', TimeType::class, [
                'mapped' => false,
            ])
            ->add('slots', TextType::class, [
                'mapped' => true,
            ])
        ;

        if (in_array('ROLE_ADMIN', $this->token->getToken()->getUser()->getRoles())) {
            $builder->add('owner', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'multiple' => false,
                'expanded' => false,
            ]);
        }

        $builder->get('slots')
            ->addModelTransformer(new CallbackTransformer(
                function ($slotsAsArray) {
                    // transform the array to a string
                    return implode(',', $slotsAsArray);
                },
                function ($slotsAsString) {
                    // transform the string back to an array
                    return explode(',', $slotsAsString);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agenda::class,
        ]);
    }
}
