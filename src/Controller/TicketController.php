<?php

namespace App\Controller;

use App\Repository\TicketRepository; // pour interagir avec la table des tickets
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ticket')] // préfixe de route pour ttes les méthodes du controller
class TicketController extends AbstractController
{
    #[Route('/', name: 'app_ticket_index', methods: ['GET'])] 
    public function index(TicketRepository $ticketRepository): Response
    {
        // récupère tous les tickets depuis la bd
        // triés par date d'ouverture la plus récente d'abord
        $tickets = $ticketRepository->findBy([], ['dateOuverture' => 'DESC']);

        // envoie les tickets au template pour affichage
        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }
}
