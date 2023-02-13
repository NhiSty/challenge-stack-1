<?php

namespace App\Form;

use App\Entity\DocumentStorage;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class DocumentStorageType extends AbstractType
{
    private readonly TokenStorageInterface $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description');

            if(in_array('ROLE_ADMIN', $this->token->getToken()->getUser()->getRoles())){
                $builder->add('user_id', EntityType::class, [
                    'label' => 'User',
                    'choice_label' => 'email',
                    'class' => User::class,
                    'required' => true,
                    'choice_value' => 'id',
                ]);
            }
            $builder->add('docFile', FileType::class, [
                "label" => "Documents",
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentStorage::class,
        ]);
    }
}
