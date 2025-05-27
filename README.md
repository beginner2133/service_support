# Projet Symfony - Suivi de Tickets pour une Agence Web

(IMPORTANT : lire le readme en mode "anglais" sur le dépôt GitHub)

Système de Tickets avec support Clients pour une agence web.
Il s'agit ici d'un exercice avec le **framework Symfony**, réalisé en suivant les recommandations du support du cours "Les bases de Symfony" pour la création du projet

L'objectif est de développer une application web interne pour une agence & ses salariés, permettant le suivi de tickets soumis par les clients (partie front-office pour les clients)

## Accès à l'Application

### 1. Accès Public (pour les Clients/Visiteurs)
* **URL Principale :** `https://127.0.0.1:8000/` (en environnement de développement local avec le serveur Symfony)
* **Objectif :** permettre aux clients de soumettre un nouveau ticket de support via le formulaire via la page d'accueil
* Un bouton "Connexion Espace Agence" est également disponible, redirigeant vers l'interface de connexion réservée au personnel de l'agence

### 2. Accès Interne (pour le Personnel de l'Agence et l'Administrateur)
* **URL de Connexion :** `https://127.0.0.1:8000/login`
* **Identifiants pour le Correcteur (l'administrateur) :**
    * mail : `admin@agence.correcteur.fr`
    * Mp : `correcteur`
* une fois connecté, l'utilisateur est redirigé vers l'accueil interne (`/home`) où un menu de navigation permet d'accéder aux différentes fonctionnalités


Le **contexte** est le suivi & la gestion du support clients, par le biais de tickets que peuvent créer les clients
La **nature des Tickets** :
* "Incident" / "Panne" : signalement de dysfonctionnement (ex: "mon site est inaccessible", "Le formulaire de contact ne s'affiche plus")
* "Anomalie" : bug ou comportement inattendu (ex: "l'affichage se fait mal sur mon mobile", "une information semble incorrect sur mon espace de suivi")
* "Évolution" : demande d'amélioration (ex: "améliorer l'ergonomie du site pour une meilleure navigation")
* "Information" : simple demande de renseignement
L'application permet à l'agence de centraliser ces demandes, de les assigner, de suivre leur résolution & de garder un historique. C'est un outil courant de gestion & de suivi de la relation client

## Développement

La phase initiale de mise en place du projet a présenté des défis techniques, notamment avec **Composer** pour l'installation de `doctrine/doctrine-fixtures-bundle` (la syntaxe exacte du nom du paquet était cruciale), & de ce fait, les premiers commits regroupent plusieurs étapes

Ce fichier README sera mis à jour régulièrement en parallèle des commits pour détailler les étapes de développement. Les commentaires ds le code se veulent simples & explicatifs, ds l'idée de partager mon expérience d'apprentissage

## Étapes Réalisées

### Initialisation & Structure de Base
* création du projet symfony 6.4 `--webapp` pour une version complète 
* configuration de la connexion à la bdd (mariadb), port 3307
* création des entités : `Categorie`, `Statut`, `Utilisateur`, `Ticket` avec leurs propriétés
* création & application des migrations pour créer le schéma de la bdd

### Fixtures & Données Initiales
* installation du paquet `doctrine/doctrine-fixtures-bundle` (après résolution des problèmes composer)
* création de `AppFixtures.php` pour les données initiales
* ajout des fixtures pour les `Categorie` ("Incident", "Panne", etc.) & les `Statut` ("Nouveau", "Ouvert", etc.). 
* ajout de l'utilisateur `Administrateur` (mail:`admin@agence.correcteur.fr`, Mp: `correcteur`) avec Mp hashé
* chargement de ttes les fixtures en bdd
* création & mises à jour de ce `README.md`

### Authentification & Accès Sécurisé
* mise en place du système d'authentification (`make:auth`)
* configuration des redirections après connexion (`AppAuthenticator.php`) & déconnexion (`security.yaml`)
* création de `HomeController`& du template d'accueil interne (`home/index.html.twig`)
* configuration du contrôle d'accès (`access_control` ds `security.yaml`) pour `/login`, `/home`

### Fonctionnalités Public : création de Ticket
* création de la page d'accueil public (`/`) pour les visiteurs
* mise en place du formulaire de saisie de ticket (`TicketType.php`) avec les champs : `auteurEmail`, `description`, `categorie`
* gestion de la soumission du formulaire & enregistrement des nouveaux tickets
* assignation automatique du statut "Nouveau" & de la `dateOuverture` aux tickets créés

### Fonctionnalités internes : visualisation & gestion Tickets
* création du `TicketController` pour lister (`index`) & afficher les détails (`show`) des tickets
* création des templates correspondants (`ticket/index.html.twig`, `ticket/show.html.twig`)
* sécurisation de la section `/ticket` (accessible aux utilisateurs connectés)
* implémentation de la modification du statut d'un ticket par le personnel depuis la page qui affiche toutes les informations sur un ticket (`TicketStatusType.php`, méthode `editStatus` ds `TicketController`)
* correction des erreurs & validation du fonctionnement

### Interface Utilisateur (Bootstrap) & CRUD Catégories (Admin)
* **amélioration de l'interface utilisateur :**
    * ajout de bootstrap 5 via cdn ds `templates/base.html.twig`
    * amélioration de la barre de navigation principale (style, police, couleur, liens "voir site public", "gérer catégories" pour admin)
    * ajout d'un lien "retour à l'accueil public" sur la page de connexion
    * harmonisation du style des pages existantes avec bootstrap
* **crud gestion des catégories (admin) :** 
    * création du crud pour `Categorie` (`make:crud`)
    * création `CategorieController.php`, `CategorieForm.php` & templates associés
    * sécurisation des routes `/categorie` pour `ROLE_ADMIN`
    * fonctionnalité crud catégories (créer, voir, modifier, supprimer) testée et opérationnelle

    Auteur
    NP.
