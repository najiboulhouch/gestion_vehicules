<?php

namespace App\Repository;

use App\Entity\Voiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Voiture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voiture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voiture[]    findAll()
 * @method Voiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voiture::class);
    }

    public function findByBudget($budgetMin , $budgetMax): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'select v from App\Entity\Voiture v
             where v.prix BETWEEN :min AND :max'
        )->setParameter('min' , $budgetMin)
        ->setParameter('max' , $budgetMax);

        return $query->getResult();
    }

    public function advancedSearch($idModele , $etat , $idCarb , $idCol, $budgetMin , $budgetMax): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'select v from App\Entity\Voiture v
             where v.prix BETWEEN :min AND :max
             AND v.Modele = :modele AND v.etat = :etat 
             AND v.Carburant = :car AND v.Couleur = :col' 
        )->setParameter('min' , $budgetMin)
        ->setParameter('max' , $budgetMax)
        ->setParameter('modele' , $idModele)
        ->setParameter('etat' , $etat)
        ->setParameter('car' , $idCarb)
        ->setParameter('col' , $idCol);

        return $query->getResult();
    }

    public function findByPromotion(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'select v from App\Entity\Voiture v
             where v.promotion > 0' 
        );

        return $query->getResult();
    }
    
}
