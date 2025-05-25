<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route; // pour Symfony 6.4+
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // si l'utilisateur est déjà connecté, on le redirige vers la page d'accueil
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('app_home'); // ou une autre page "cible"
        // }

        // erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        // renvoi le template du formulaire de connexion
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // peut être vide & sera interceptée par la config
        // pare-feu (firewall) ds security.yaml
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
