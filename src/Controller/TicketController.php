<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketStatusType; 
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ticket')] 
class TicketController extends AbstractController
{
    #[Route('/', name: 'app_ticket_index', methods: ['GET'])] 
    public function index(TicketRepository $ticketRepository): Response
    {
        $tickets = $ticketRepository->findBy([], ['dateOuverture' => 'DESC']);

        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    // méthode pour modifier le statut d'un ticket
    #[Route('/{id}/modifier-statut', name: 'app_ticket_edit_status', methods: ['GET', 'POST'])]
    public function editStatus(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        // création du formulaire lié au ticket existant
        $form = $this->createForm(TicketStatusType::class, $ticket);
        $form->handleRequest($request); // le formulaire analyse la requête

        if ($form->isSubmitted() && $form->isValid()) {
            // si le formulaire est soumis & valide, on enregistre
            $entityManager->flush(); // pas besoin de persist(), le ticket est déjà suivi par doctrine

            $this->addFlash('success', 'le ticket #' . $ticket->getId() . ' a bien été mis à jour.');

            // redirection vers la page de détail du ticket
            return $this->redirectToRoute('app_ticket_show', ['id' => $ticket->getId()], Response::HTTP_SEE_OTHER);
        }

        // si la méthode est GET ou si le formulaire n'est pas valide,
        // on redirige vers la page 'show' où le formulaire est affiché
        return $this->redirectToRoute('app_ticket_show', ['id' => $ticket->getId()]);
    }

    #[Route('/{id}', name: 'app_ticket_show', methods: ['GET'])] // page détail d'un ticket
    public function show(Ticket $ticket): Response 
    {
        // création du formulaire de modification de statut pour l'afficher ici
        // l'action du formulaire pointera vers la route 'app_ticket_edit_status'
        $statusForm = $this->createForm(TicketStatusType::class, $ticket, [
            'action' => $this->generateUrl('app_ticket_edit_status', ['id' => $ticket->getId()]),
            'method' => 'POST', // le formulaire soumis en POST
        ]);

        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
            'status_form' => $statusForm->createView(), 
        ]);
    }
}
