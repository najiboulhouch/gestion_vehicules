<?php

namespace App\Controller;

use App\Entity\Carburant;
use App\Entity\Couleur;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Voiture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index" , methods ={"POST" , "GET"})
     */
    public function index(Request $request , PaginatorInterface $paginator): Response
    {   

        $idMarque = $request->query->get("marque");
        $idModele = $request->query->get("modele");
        $etat = $request->query->get("etat");
        $idCarburant = $request->query->get("carb");
        $idColeur = $request->query->get("col");
        $budgetMin = $request->query->get("bud_min");
        $budgetMax = $request->query->get("bud_max");
        
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();
        $carburants = $this->getDoctrine()->GetRepository(Carburant::class)->findAll();
        $couleurs = $this->getDoctrine()->getRepository(Couleur::class)->findAll();
        $marques = $this->getDoctrine()->getRepository(Marque::class)->findAll();


        
        if (!empty($idMarque)) {
            $modeles = $this->getDoctrine()->getRepository(Modele::class)->findBy(['Marque' => $idMarque]);
            $voitures = array();
            foreach ($modeles as $modele) {
                foreach ($modele->getVoitures() as $voiture) {
                    array_push($voitures , $voiture);
                }
            }
                           
        } else {          
            $modeles = $this->getDoctrine()->getRepository(Modele::class)->findAll();
        }

        if(!empty($idModele)){        
            $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(['Modele' => $idModele]);
        }

        if(!empty($etat)){
            $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(['etat' => $etat]);
        }
        
        if(!empty($idCarburant)){
           
            $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(['Carburant' => $idCarburant]);
        }

        if(!empty($idColeur)){
           
            $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(['Couleur' => $idColeur]);
        }

        if(!empty($budgetMin) && !empty($budgetMax)){
         
            $voitures = $this->getDoctrine()
            ->getRepository(Voiture::class)->findByBudget($budgetMin , $budgetMax);
        }

        if(!empty($idModele) && !empty($etat) && !empty($idCarburant) && 
        !empty($idColeur) && !empty($budgetMin) && !empty($budgetMax) ){
            $voitures = $this->getDoctrine()
            ->getRepository(Voiture::class)->advancedSearch($idModele , $etat , $idCarburant ,
             $idColeur, $budgetMin , $budgetMax);
        }

        $pagination = $paginator->paginate(
            $voitures, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );

        return $this->render('index/index.html.twig', [
            'marques' => $marques,
            'idMarque' => $idMarque,
            'idModele' => $idModele,
            'etat' => $etat,
            'idCarb' => $idCarburant,
            'idCol'  => $idColeur,
            'modeles' => $modeles,
            'budgetMin' => $budgetMin,
            'budgetMax' => $budgetMax,
            'carburants' => $carburants,
            'couleurs' => $couleurs,           
            'pagination' => $pagination,
                ]);
    }
}
