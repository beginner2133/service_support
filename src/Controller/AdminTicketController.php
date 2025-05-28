<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketForm; 
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/ticket')] 
final class AdminTicketController extends AbstractController
{
    #[Route('/', name: 'app_admin_ticket_index', methods: ['GET'])] 
    public function index(TicketRepository $ticketRepository): Response
    {
        return $this->render('admin_ticket/index.html.twig', [
            'tickets' => $ticketRepository->findBy([], ['dateOuverture' => 'DESC']), 
        ]);
    }

    #[Route('/new', name: 'app_admin_ticket_new', methods: ['GET', 'POST'])] 
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketForm::class, $ticket, ['is_new_ticket_admin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            if ($ticket->getDateOuverture() === null) {
                $ticket->setDateOuverture(new \DateTime());
            }
            

            $entityManager->persist($ticket);
            $entityManager->flush();

            $this->addFlash('success', 'le nouveau ticket a bien été créé par l\'administrateur.');

            return $this->redirectToRoute('app_admin_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_ticket_show', methods: ['GET'])] 
    public function show(Ticket $ticket): Response
    {
        return $this->render('admin_ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_ticket_edit', methods: ['GET', 'POST'])] 
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketForm::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            if ($ticket->getStatut() && $ticket->getStatut()->getNom() === 'Fermé' && $ticket->getDateCloture() === null) {
                $ticket->setDateCloture(new \DateTime());
            }
            
            elseif ($ticket->getStatut() && $ticket->getStatut()->getNom() !== 'Fermé') {
                $ticket->setDateCloture(null);
            }

            $entityManager->flush();

            $this->addFlash('success', 'le ticket #' . $ticket->getId() . ' a bien été mis à jour.');

            return $this->redirectToRoute('app_admin_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_ticket_delete', methods: ['POST'])] 
    public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ticket);
            $entityManager->flush();
            $this->addFlash('success', 'le ticket a bien été supprimé.');
        }

        return $this->redirectToRoute('app_admin_ticket_index', [], Response::HTTP_SEE_OTHER);
    }
}
