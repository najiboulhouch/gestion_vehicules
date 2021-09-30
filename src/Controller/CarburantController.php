<?php

namespace App\Controller;

use App\Entity\Carburant;
use App\Form\CarburantType;
use App\Repository\CarburantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}/carburant" , requirements={"_locale": "en|fr"})
 */
class CarburantController extends AbstractController
{
    private $entityManager ;
    private $logger;

    public function __construct(EntityManagerInterface $em , LoggerInterface $logger){
        $this->entityManager = $em;
        $this->logger  = $logger;
    }


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

            try {
                $this->entityManager->persist($carburant);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $this->logger->error('An error occurred(Inerting Carburant) :' . $e->getMessage());
                $this->addFlash(
                    'error',
                    'An error occurred on adding, Please contact administrator'
                );
            }

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
            try {
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $this->logger->error('An error occurred(Inerting Carburant) :' . $e->getMessage());
                $this->addFlash(
                    'error',
                    'An error occurred on adding, Please contact administrator'
                );
            }

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
            try {
                $this->entityManager->remove($carburant);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $this->logger->error('An error occurred(Deleting Carburant) :' . $e->getMessage());
                $this->addFlash(
                    'error',
                    'An error occurred on deleting, Please contact administrator'
                );            }
        }

        return $this->redirectToRoute('carburant_index', [], Response::HTTP_SEE_OTHER);
    }
}
