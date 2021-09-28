<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\Voiture;
use App\Repository\CommandeRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("{_locale}/commande" , requirements={"_locale": "en|fr"})
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="commande_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="commande_new", methods={"GET","POST"})
     */
    public function new(Request $request , int $id): Response
    {
        $commande = new Commande();
        $commande->setDateRdv(new DateTime());

        if (!empty($id)) {
            $voiture = $this->getDoctrine()->getRepository(Voiture::class)->find($id);
        }
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $commande->setVoiure($voiture);
            $entityManager->persist($commande);            
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Votre commande a été enregistrée avec succès, vous recevez un appel 
                téléphonique le plutôt possible'
            );
            return $this->redirectToRoute('commande_new', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="commande_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Commande $commande): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="commande_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
