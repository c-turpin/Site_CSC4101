<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Jeu;

final class JeuController extends AbstractController
{
    /**
     * Show a Jeu entity.
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('/jeu/{id}', name: 'jeu_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id) : Response
    {
        $jeuRepo = $doctrine->getRepository(Jeu::class);
        $jeu = $jeuRepo->find($id);
        return $this->render('jeu/show.html.twig',
            [ 'jeu' => $jeu]
            );
    }
}
