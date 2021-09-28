<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Modele;
use App\Form\ModeleType;
use App\Repository\ModeleRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("{_locale}/modele" , requirements={"_locale": "en|fr"})
 * @IsGranted("ROLE_ADMIN")
 */
class ModeleController extends AbstractController
{

    private $slugger ;
    private $logger  ;


    public function __construct( SluggerInterface $slugger , LoggerInterface $logger)
    {
        $this->slugger = $slugger;
        $this->logger  = $logger;
    }

    /**
     * @Route("/", name="modele_index", methods={"GET"})
     */
    public function index(ModeleRepository $modeleRepository): Response
    {
        return $this->render('modele/index.html.twig', [
            'modeles' => $modeleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="modele_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $modele = new Modele();
        $form = $this->createForm(ModeleType::class, $modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($modele);
            $entityManager->flush();

            $lastModele = $this->getDoctrine()->getRepository(Modele::class)->getLastId();
    
            $imageFile = $form->get('picture')->getData();        

            foreach ($imageFile as $value) {

                $originalFilename = pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME);
                    
                    $safeFilename = $this->slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $value->guessExtension();
                    try {
                        $value->move(
                            $this->getParameter('voitures_directory'),
                            $newFilename
                        );

                        $image = new Image();
                        $image->setNomImage($newFilename);
                        $image->setModele($lastModele);
                        $entityManager->persist($image);
                        $entityManager->flush();

                    } catch (FileException $e) {
                        $logger->error($e->getMessage());
                    }
            }

            return $this->redirectToRoute('modele_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('modele/new.html.twig', [
            'modele' => $modele,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="modele_show", methods={"GET"})
     */
    public function show(Modele $modele): Response
    {
        return $this->render('modele/show.html.twig', [
            'modele' => $modele,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="modele_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Modele $modele , LoggerInterface $logger): Response
    {
        $form = $this->createForm(ModeleType::class, $modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $imageFile = $form->get('picture')->getData();        

            foreach ($imageFile as $value) {

                $originalFilename = pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME);
                    
                    $safeFilename = $this->slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $value->guessExtension();
                    try {
                        $value->move(
                            $this->getParameter('voitures_directory'),
                            $newFilename
                        );

                        $image = new Image();
                        $image->setNomImage($newFilename);
                        $image->setModele($modele);
                        $entityManager->persist($image);
                        $entityManager->flush();
                        return $this->redirectToRoute('modele_index', [], Response::HTTP_SEE_OTHER);
                    } catch (FileException $e) {
                        $logger->error($e->getMessage());
                    }
            }
        }
           

        return $this->renderForm('modele/edit.html.twig', [
            'modele' => $modele,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="modele_delete", methods={"POST"})
     */
    public function delete(Request $request, Modele $modele): Response
    {
        if ($this->isCsrfTokenValid('delete' . $modele->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $filesystem = new Filesystem();

            foreach ($modele->getImages() as $image) {
                $filesystem->remove( $this->getParameter('voitures_directory') . '/'. $image->getNomImage());
            }

            $entityManager->remove($modele);

            $entityManager->flush();
        }

        return $this->redirectToRoute('modele_index', [], Response::HTTP_SEE_OTHER);
    }
}
