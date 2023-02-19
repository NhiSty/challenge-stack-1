<?php

namespace App\Form;

use App\Entity\DocumentStorage;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
        // displayed for user and admin
        if(!in_array('ROLE_PRATICIEN', $this->token->getToken()->getUser()->getRoles())){
            $builder
                ->add('description');
        }

        // if i am admin
        if(in_array('ROLE_ADMIN', $this->token->getToken()->getUser()->getRoles())){
            $builder->add('user_id', EntityType::class, [
                'label' => 'User',
                'choice_label' => 'email',
                'class' => User::class,
                'required' => false,
                'choice_value' => 'id',
            ]);
        }
        // only practicien
        if(in_array('ROLE_PRATICIEN', $this->token->getToken()->getUser()->getRoles())) {
            if ($options['isForDemand']){
                for($i = 0; $i < count($options['necessaryDocs']); $i++){
                    $builder->add('docFile'.$i, FileType::class, [
                        "label" => $options['necessaryDocs'][$i]->getName(),
                        'required' => true,
                        'mapped' => false,
                    ]);
                }
            }
            else{
                $builder->add('docFile', FileType::class, [
                    "label" => "Documents",
                    'required' => false,
                ]);
            }
        }

        // every user
        else{
            $builder->add('docFile', FileType::class, [
                "label" => "Documents",
                'required' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentStorage::class,
            'necessaryDocs' => [],
            'isForDemand'=> false,
        ]);
    }
}
