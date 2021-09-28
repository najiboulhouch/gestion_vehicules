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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix', IntegerType::class, [
                'label'      => 'forms.voiture.prix'
            ])
            ->add('km', IntegerType::class, [
                'label' => 'forms.voiture.km'
            ])
            ->add('dateConstruction', DateType::class, [
                'label'     => 'forms.voiture.dateCon',
                'widget' => 'single_text',
            ])
            ->add('etat', ChoiceType::class, [
                'choices'  => [
                    'forms.voiture.etat' => '',
                    'Neuve' => 'Neuve',
                    'Ocasion' => 'Ocasion',
                ],
                'label'     => 'forms.voiture.label.etat'
            ])
            ->add('dateMiseEnVente', DateType::class, [
                'label'     => 'forms.voiture.dateMise',
                'widget' => 'single_text'
            ])
            ->add('disponibilite', CheckboxType::class, [
                'label' => 'forms.voiture.dispo'
            ])
            ->add('promotion', IntegerType::class, [
                'label' => 'forms.voiture.promo'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'forms.voiture.description'
            ])
            ->add('Couleur', EntityType::class, [
                'class' => Couleur::class,
                'choice_label' => 'nomCouleur',
                'label' => 'forms.voiture.color'
            ])
            ->add('Carburant', EntityType::class, [
                'class' => Carburant::class,
                'choice_label' => 'nomCarburant',
                'label' => 'forms.voiture.carburant'
            ])
            ->add('Modele', EntityType::class, [
                'class' => Modele::class,
                'choice_label' => 'nomModele',
                'label' => 'forms.voiture.modele'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
