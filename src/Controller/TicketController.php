<?php

namespace App\Controller;

use App\Entity\Ticket; // import entité Ticket pour la méthode "show"
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ticket')] // préfixe de route pour ttes les méthodes de controller
class TicketController extends AbstractController
{
    #[Route('/', name: 'app_ticket_index', methods: ['GET'])] // page ticket
    public function index(TicketRepository $ticketRepository): Response
    {
        // récupère tous les tickets depuis la base de données
        // triés par date d'ouverture la plus récente d'abord
        $tickets = $ticketRepository->findBy([], ['dateOuverture' => 'DESC']);

        // envoie les tickets au template pour affichage
        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    // méthode "show" pour afficher les détails d'un ticket
    #[Route('/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket): Response // Symfony cherchera le Ticket par l'id
    {
        // on envoie le ticket trouvé au template pour affichage
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }
}
