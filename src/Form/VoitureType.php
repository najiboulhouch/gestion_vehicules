<?php

namespace App\Form;

use App\Entity\Carburant;
use App\Entity\Couleur;
use App\Entity\Modele;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('prix', TextType::class, [
                'label'      => 'Prix'
            ])
            ->add('km', IntegerType::class, [
                'label' => 'Kélométrage'
            ])
            ->add('dateConstruction', DateType::class, [
                'label'     => 'Date de construction',
                'widget' => 'single_text'
            ])
            ->add('etat', ChoiceType::class, [
                'choices'  => [
                    'Choisir votre état' => '',
                    'Neuve' => 'Neuve',
                    'Ocasion' => 'Ocasion',
                ],
                'label'     => 'Etat'
            ])
            ->add('dateMiseEnVente', DateType::class, [
                'label'     => 'Date de mise en vente',
                'widget' => 'single_text'
            ])
            ->add('disponibilite', CheckboxType::class, [
                'label' => 'Disponibilité'
            ])
            ->add('promotion', IntegerType::class, [
                'label' => 'Promotion(%)'
            ])
            ->add('Couleur', EntityType::class, [
                'class' => Couleur::class,
                'choice_label' => 'nomCouleur'
            ])
            ->add('Carburant', EntityType::class, [
                'class' => Carburant::class,
                'choice_label' => 'nomCarburant',
                'label' => 'Type de carburant'
            ])
            ->add('Modele', EntityType::class, [
                'class' => Modele::class,
                'choice_label' => 'nomModele',
                'label' => 'Type de modéle'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
