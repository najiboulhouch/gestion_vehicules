<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/voiture")
 */
class VoitureController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="voiture_index", methods={"GET"})
     */
    public function index(VoitureRepository $voitureRepository): Response
    {
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="voiture_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voiture/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/promotion", name="voiture_promotion", methods={"GET"})
     */
    public function showPromotion(Request $request, PaginatorInterface $paginator): Response
    {
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findByPromotion();


        $pagination = $paginator->paginate(
            $voitures,
            $request->query->getInt('page', 1),
            2
        );
        return $this->render('voiture/promotion.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/{id}", name="voiture_show", methods={"GET"})
     */
    public function show(Voiture $voiture): Response
    {
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="voiture_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Voiture $voiture): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="voiture_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Voiture $voiture): Response
    {
        if ($this->isCsrfTokenValid('delete' . $voiture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($voiture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('voiture_index', [], Response::HTTP_SEE_OTHER);
    }
}