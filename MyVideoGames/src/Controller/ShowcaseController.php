<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Entity\Showcase;
use App\Form\ShowcaseType;
use App\Repository\ShowcaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/showcase')]
final class ShowcaseController extends AbstractController
{
    #[Route(name: 'app_showcase_index', methods: ['GET'])]
    public function index(ShowcaseRepository $showcaseRepository): Response
    {
        return $this->render('showcase/index.html.twig', [
            'showcases' => $showcaseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_showcase_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $showcase = new Showcase();
        $form = $this->createForm(ShowcaseType::class, $showcase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($showcase);
            $entityManager->flush();

            return $this->redirectToRoute('app_showcase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('showcase/new.html.twig', [
            'showcase' => $showcase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_showcase_show', methods: ['GET'])]
    public function show(Showcase $showcase): Response
    {
        return $this->render('showcase/show.html.twig', [
            'showcase' => $showcase,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_showcase_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Showcase $showcase, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ShowcaseType::class, $showcase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_showcase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('showcase/edit.html.twig', [
            'showcase' => $showcase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_showcase_delete', methods: ['POST'])]
    public function delete(Request $request, Showcase $showcase, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$showcase->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($showcase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_showcase_index', [], Response::HTTP_SEE_OTHER);
    }
    
    /**
     * Show a Jeu entity.
     *
     * @param Integer $jeu_id (note that the id must be an integer)
     * @param Integer $showcase_id (note that the id must be an integer)
     */  
    #[Route('/{showcase_id}/jeux/{jeu_id}',methods: ['GET'], name: 'app_showcase_jeu_show')]
    public function jeuShow(
            #[MapEntity(id: 'showcase_id')]
            Showcase $showcase,
            #[MapEntity(id: 'jeu_id')]
            Jeu $jeu
            ): Response
            {
                if(! $showcase->getJeux()->contains($jeu)) {
                    throw $this->createNotFoundException("Couldn't find such a jeu in this showcase!");
                }
                if(! $showcase->isPublished()) {
                   throw $this->createAccessDeniedException("You cannot access the requested ressource!");
                }
                return $this->render('showcase/jeushow.html.twig', [
                    'jeu' => $jeu,
                    'showcase' => $showcase
                ]);
        }
}
