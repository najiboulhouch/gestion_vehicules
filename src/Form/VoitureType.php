<?php

namespace App\Form;

use App\Entity\Couleur;
use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix' , TextType::class,[
                'label'      => 'Prix'
            ])
            ->add('km' , IntegerType::class , [
                'label' => 'Kélométrage'
            ])
            ->add('dateConstruction' , DateType::class , [
                'label'     => 'Date de construction',
                'widget' => 'single_text'
            ])
            ->add('etat' , ChoiceType::class , [
                'choices'  => [
                    'Choisir votre état' => '',
                    'Neuve' => 'Nuve',
                    'Occasion' => 'Occasion',
                ],
                'label'     => 'Etat'
            ])
            ->add('dateMiseEnVente' , DateType::class , [
                'label'     => 'Date de mise en vente',
                'widget' => 'single_text'
            ])
            ->add('disponibilite' , CheckboxType::class, [
                'label' => 'Disponibilité'
            ] )
            ->add('promotion' , PercentType::class , [
                'label' => 'Promotion(%)'
            ])
            ->add('Couleur' , CollectionType::class, [
                // each entry in the array will be an "email" field
                'entry_type' => CouleurType::class ,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('Carburant')
            ->add('Modele');
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
