<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Entity\Statut; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'message' => 'Bienvenue sur votre espace !',
        ]);
    }

    #[Route('/', name: 'app_public_home')]
    public function publicHome(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket(); // création d'un nouveau ticket
        $form = $this->createForm(TicketType::class, $ticket); // création du formulaire lié au ticket

        $form->handleRequest($request); // le formulaire "écoute" la requête pour voir s'il a été soumis

        if ($form->isSubmitted() && $form->isValid()) {
            // forumulaire soumis & valide 

            $statutNouveau = $entityManager->getRepository(Statut::class)->findOneBy(['nom' => 'Nouveau']);

            if (!$statutNouveau) {
                
                $this->addFlash('error', 'Erreur critique : Le statut initial "Nouveau" est introuvable. Impossible de créer le ticket. Veuillez contacter l\'administrateur.');
                // on redirige pour afficher le message d'erreur
                return $this->redirectToRoute('app_public_home');
            }

            // assigne les valeurs si le statut est trouvé
            $ticket->setDateOuverture(new \DateTime()); 
            $ticket->setStatut($statutNouveau); 

            $entityManager->persist($ticket); // prépare la sauvegarde du ticket
            $entityManager->flush(); // exécute la sauvegarde dans bdd

            $this->addFlash('success', 'Votre ticket a bien été soumis ! Nous vous répondrons sous 48 heures');

            // redirection pour éviter de resoumettre le formulaire si l'utilisateur rafraîchit la page
            return $this->redirectToRoute('app_public_home');
        }

        // affiche le template de la page d'accueil public
        // lui passe le formulaire pour qu'il puisse être affiché
        return $this->render('public_home/index.html.twig', [
            'ticket_form' => $form->createView(),
        ]);
    }
}
