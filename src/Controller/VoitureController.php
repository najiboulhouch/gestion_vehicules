<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("{_locale}/voiture" , requirements={"_locale": "en|fr"})
 */
class VoitureController extends AbstractController
{

    private $logger  ;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger  = $logger;
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="voiture_index", methods={"GET"})
     */
    public function index(Request $request , VoitureRepository $voitureRepository , PaginatorInterface $paginator): Response
    {
        $voitures = $voitureRepository->findAll();
        $pagination = $paginator->paginate(
            $voitures,
            $request->query->getInt('page', 1),
            4
        );
        return $this->render('voiture/index.html.twig', [
            'voitures' => $pagination,
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
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($voiture);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->logger->error('An error occurred(Inerting Couleur) :' . $e->getMessage());
                    $this->addFlash(
                        'error',
                        'An error occurred on adding, Please contact administrator'
                    );
            }

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
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                $this->logger->error('An error occurred(Updating Voiture) :' . $e->getMessage());
                    $this->addFlash(
                        'error',
                        'An error occurred on updating, Please contact administrator'
                    );
            }

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
            try {
                $entityManager->remove($voiture);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->logger->error('An error occurred(Deleting  Voiture) :' . $e->getMessage());
                    $this->addFlash(
                        'error',
                        'An error occurred on deleting, Please contact administrator'
                    );
            }
            
        }

        return $this->redirectToRoute('voiture_index', [], Response::HTTP_SEE_OTHER);
    }
}
