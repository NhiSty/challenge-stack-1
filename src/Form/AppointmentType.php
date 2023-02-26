<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\Consultation;
use App\Entity\Drug;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Choice;

class AppointmentType extends AbstractType
{
    private readonly TokenStorageInterface $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (in_array('ROLE_ADMIN', $this->token->getToken()->getUser()->getRoles())) {
            $builder
                ->add('date', DateType::class, [
                    'widget' => 'single_text',
                    'html5' => true,
                    'attr' => ['class' => 'js-datepicker'],
                ])
                ->add('slot', TimeType::class, [
                    'widget' => 'single_text',
                    'html5' => true,
                    'attr' => ['class' => 'js-timepicker'],
                ])
                ->add('patient_id', IntegerType::class)
                ->add('practitioner_id', EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'email',
                    'multiple' => true,
                    'expanded' => false,
                ])
                ->add('drug_id', EntityType::class, [
                    'class' => Drug::class,
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => false,
                ])
                ->add('consultation_id', EntityType::class, [
                    'class' => Consultation::class,
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => false,
                ])
            ;
        }

        if (in_array('ROLE_USER', $this->token->getToken()->getUser()->getRoles())) {
            $builder
                ->add('date', HiddenType::class, [
                    'empty_data' => '2021-01-01'
                ])
                ->add('slot', HiddenType::class)

                ->add('drug_id', EntityType::class, [
                    'class' => Drug::class,
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => false,
                ])
                ->add('consultation_id', EntityType::class, [
                    'class' => Consultation::class,
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => false,
                ])
            ;

            $builder
                ->get('date')
                ->addModelTransformer(new CallbackTransformer(
                    function ($dateToStr) {
                        // transform the array to a string
                        return $dateToStr;
                    },
                    function ($strToDate) {

                        // transform the string back to an array
                        return new DateTime($strToDate);
                    }
                ))
            ;
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
