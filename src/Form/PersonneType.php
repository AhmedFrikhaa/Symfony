<?php

namespace App\Form;
use Doctrine\ORM\PersistentCollection;
use App\Entity\Hobby;
use App\Entity\Personne;
use App\Entity\Profile;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('name')
            ->add('age')
            ->add('hobbies',EntityType::class ,
            [     "expanded"=>false ,
                'class'=>Hobby::class,
                "multiple"=>true,
                'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('h')->orderBy('h.designation','ASC');
                },
                'choice_label'=>'designation' // c'est l'equivalant a la fonction tostring define au niveau de l'entité

            ])
            ->add('photo', FileType::class, [
                'label' => 'votre image de profile (image File uniquement)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid  image',
                    ])
                ],
            ])
            ->add('job')
            ->add('profile', EntityType::class,[
                "expanded"=>true ,
                'class'=>Profile::class,
                'required'=>false,
                "multiple"=>false
            ])
            ->add('editer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
