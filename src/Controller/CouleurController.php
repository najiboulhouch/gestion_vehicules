<?php

namespace App\Controller;

use App\Entity\Couleur;
use App\Form\CouleurType;
use App\Repository\CouleurRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("{_locale}/couleur" , requirements={"_locale": "en|fr"})
 */
class CouleurController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger  = $logger;
    }
    /**
     * @Route("/", name="couleur_index", methods={"GET"})
     */
    public function index(CouleurRepository $couleurRepository): Response
    {
        return $this->render('couleur/index.html.twig', [
            'couleurs' => $couleurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="couleur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $couleur = new Couleur();
        $form = $this->createForm(CouleurType::class, $couleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($couleur);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->logger->error('An error occurred(Inerting Couleur) :' . $e->getMessage());
                    $this->addFlash(
                        'error',
                        'An error occurred on adding, Please contact administrator'
                    );
            }

            return $this->redirectToRoute('couleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('couleur/new.html.twig', [
            'couleur' => $couleur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="couleur_show", methods={"GET"})
     */
    public function show(Couleur $couleur): Response
    {
        return $this->render('couleur/show.html.twig', [
            'couleur' => $couleur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="couleur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Couleur $couleur): Response
    {
        $form = $this->createForm(CouleurType::class, $couleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                $this->logger->error('An error occurred(Updating Couleur) :' . $e->getMessage());
                    $this->addFlash(
                        'error',
                        'An error occurred on updating, Please contact administrator'
                    );
            }

            return $this->redirectToRoute('couleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('couleur/edit.html.twig', [
            'couleur' => $couleur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="couleur_delete", methods={"POST"})
     */
    public function delete(Request $request, Couleur $couleur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$couleur->getId(), $request->request->get('_token'))) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($couleur);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->logger->error('An error occurred(Deleting Couleur) :' . $e->getMessage());
                    $this->addFlash(
                        'error',
                        'An error occurred on deleting, Please contact administrator'
                    );
            }
        }

        return $this->redirectToRoute('couleur_index', [], Response::HTTP_SEE_OTHER);
    }
}
