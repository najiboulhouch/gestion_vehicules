<?php

namespace App\Controller;

use App\Entity\Carburant;
use App\Form\CarburantType;
use App\Repository\CarburantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/carburant")
 */
class CarburantController extends AbstractController
{
    /**
     * @Route("/", name="carburant_index", methods={"GET"})
     */
    public function index(CarburantRepository $carburantRepository): Response
    {
        return $this->render('carburant/index.html.twig', [
            'carburants' => $carburantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="carburant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $carburant = new Carburant();
        $form = $this->createForm(CarburantType::class, $carburant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($carburant);
            $entityManager->flush();

            return $this->redirectToRoute('carburant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carburant/new.html.twig', [
            'carburant' => $carburant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="carburant_show", methods={"GET"})
     */
    public function show(Carburant $carburant): Response
    {
        return $this->render('carburant/show.html.twig', [
            'carburant' => $carburant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="carburant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Carburant $carburant): Response
    {
        $form = $this->createForm(CarburantType::class, $carburant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('carburant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carburant/edit.html.twig', [
            'carburant' => $carburant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="carburant_delete", methods={"POST"})
     */
    public function delete(Request $request, Carburant $carburant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carburant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($carburant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('carburant_index', [], Response::HTTP_SEE_OTHER);
    }
}
