<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Bibliotheque;

final class BibliothequeController extends AbstractController
{
    #[Route('/', name: 'bibliotheque_list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $bibliotheques = $entityManager->getRepository(Bibliotheque::class)->findAll();
        $htmlpage = "<!DOCTYPE html>
<html>
  <body>Liste des bibliothèques de tous les membres :
    <ul>";
        foreach ($bibliotheques as $bibliotheque) {
            $htmlpage .= "<a href=" . $this->generateUrl("bibliotheque_show", ['id' => $bibliotheque->getId()]) . "><li>" . $bibliotheque->getNom() . " (id : " . $bibliotheque->getId() . ") </li></a>";
		};
        $htmlpage .= "
    </ul>
  </body>
</html>
";
		return new Response(
			$htmlpage,
			Response::HTTP_OK,
			array('content-type' => 'text/html')
		);
    }
    
    /**
     * Show a Bibliotheque entity.
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('/bibliotheque/{id}', name: 'bibliotheque_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id) : Response
    {
        $bibliothequeRepo = $doctrine->getRepository(Bibliotheque::class);
        $bibliotheque = $bibliothequeRepo->find($id);
        return $this->render('bibliotheque/show.html.twig',
            [ 'bibliotheque' => $bibliotheque]
            );
    }
}

