<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Marque;
use App\Entity\Modele;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ModeleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomModele' , TextType::class , [
                'label' => 'forms.modele.name'
            ])
            ->add('Marque' , EntityType::class , [
                'class' => Marque::class,
                'label' => 'forms.marque.type'
            ])
            ->add('picture' , FileType::class , [
                 'mapped' => false,
                 'multiple' => true,
                 'required' => false,
                 'label'    => 'forms.modele.image'    
                 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Modele::class,
        ]);
    }
}
