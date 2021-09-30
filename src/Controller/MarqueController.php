<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("{_locale}/marque" , requirements={"_locale": "en|fr"})
 */
class MarqueController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger  = $logger;
    }
    
    /**
     * @Route("/", name="marque_index", methods={"GET"})
     */
    public function index(MarqueRepository $marqueRepository): Response
    {
        return $this->render('marque/index.html.twig', [
            'marques' => $marqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="marque_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($marque);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->logger->error('An error occurred(Inerting Marque) :' . $e->getMessage());
                $this->addFlash(
                    'error',
                    'An error occurred on adding, Please contact administrator'
                );
            }

            return $this->redirectToRoute('marque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marque/new.html.twig', [
            'marque' => $marque,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="marque_show", methods={"GET"})
     */
    public function show(Marque $marque): Response
    {
        return $this->render('marque/show.html.twig', [
            'marque' => $marque,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="marque_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Marque $marque): Response
    {
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                $this->logger->error('An error occurred(Updating Marque) :' . $e->getMessage());
                    $this->addFlash(
                        'error',
                        'An error occurred on updating, Please contact administrator'
                    );
            }

            return $this->redirectToRoute('marque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marque/edit.html.twig', [
            'marque' => $marque,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="marque_delete", methods={"POST"})
     */
    public function delete(Request $request, Marque $marque): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marque->getId(), $request->request->get('_token'))) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($marque);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->logger->error('An error occurred(Deleting Marque) :' . $e->getMessage());
                    $this->addFlash(
                        'error',
                        'An error occurred on deleting, Please contact administrator'
                    );
            }
        }

        return $this->redirectToRoute('marque_index', [], Response::HTTP_SEE_OTHER);
    }
}
