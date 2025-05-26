<?php

namespace App\Controller;

use App\Entity\Ticket; // import entité ticket
use App\Form\TicketType; // import formulaire tickettype
use Doctrine\ORM\EntityManagerInterface; // pour sauvegarder dans bdd
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // gestion requête du formulaire
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // page d'accueil pour les utilisateurs connectés
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'message' => 'Bienvenue sur votre espace !',
        ]);
    }

    // page d'accueil public pour les visiteurs
    #[Route('/', name: 'app_public_home')]
    public function publicHome(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket(); // création d'un nouveau ticket
        $form = $this->createForm(TicketType::class, $ticket); // création du formulaire lié au ticket

        $form->handleRequest($request); // le formulaire "écoute" la requête pour voir s'il a été soumis

        if ($form->isSubmitted() && $form->isValid()) {
            // forumulaire soumis & valide :
            // date d'ouverture
            $ticket->setDateOuverture(new \DateTime()); // j'ai changé pour DateTime
            // $statutNouveau = $entityManager->getRepository(Statut::class)->findOneBy(['nom' => 'Nouveau']);
            // if ($statutNouveau) {
            //     $ticket->setStatut($statutNouveau);
            // }

            $entityManager->persist($ticket); // prépare la sauvegarde du ticket
            $entityManager->flush(); // exécute la sauvegarde dans bdd

            $this->addFlash('success', 'Votre ticket a bien été soumis ! Nous vous contacterons bientôt.');

            // redirection pour éviter de resoumettre le formulaire si l'utilisateur rafraîchit la page
            return $this->redirectToRoute('app_public_home');
        }

        // affiche le template de la page d'accueil publique
        // lui passe le formulaire pour qu'il puisse être affiché
        return $this->render('public_home/index.html.twig', [
            'ticket_form' => $form->createView(),
        ]);
    }
}
