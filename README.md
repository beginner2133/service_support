# Projet Symfony - Suivi de Tickets pour une Agence Web

Système de Tickets avec support Clients pour une agence web 
il s'agit ici d'un exercice avec le **framework Symfony**

L'objectif est de développer une application web (en interne) pour une agence & ses salariés, permettant le suivi des tickets soumis par les clients (en front pour les clients). 

le **contexte** est le suivi & la gestion du support clients, par le biais " des tickets que peuvent créer des clients".
la **nature des Tickets** : les catégories prédéfinies & leur utilité : (il s'agit d'exemples que l'on peut trouver couramment)

- "Incident" / "Panne" : un client signale que quelque chose ne fonctionne pas (ex: "mon site est inaccessible", "Le formulaire de contact ne s'affiche plus").
- "Anomalie" : un bug, un comportement inattendu (ex: "l'affichage se fait mal sur mon mobile", "un calcul semble incorrect sur mon espace de suivi").
- "Évolution" : une demande de modification (ex: améliorer l'ergonomie du site pour une meilleure navigation, "serait-il possible d'optimiser l'affichage des images pour un chargement plus rapide ?").
- "Information" : une simple demande de renseignement (ex: "comment mettre à jour mon article ?", "quels sont vos tarifs pour... ?").
il s'agit donc ici, des demandes via le support que les clients de l'agence web peuvent soumettre, & l'application permet à l'agence de centraliser ces demandes, de les assigner à un responsable, de suivre leur résolution, & de garder un historique, par exemple.
C'est un outil de gestion de la relation client & de suivi de projets/tâches très courant.

## Développement

La mise en place du projet de configuration a présenté des problèmes techniques au début, & c'est pourquoi les premiers commits regroupent plusieurs étapes fondamentales pour le début de l'exercice.

J'ai rencontré des difficultés dont voici un exemple : **Composer**, en particulier avec la syntaxe exacte du paquet **doctrine/doctrine-fixtures-bundle** (il fallait utiliser ce nom complet et non **doctrine/fixtures**), ce qui m'empêchait d'avancer.

Suite à cette étape, le fichier README sera mis à jour régulièrement en même temps que les commits pour détailler  les étapes à venir.
L'objectif est de proposer ici une visibilité sur la progression (logique) de ce projet
Les commentaires ds le code se veulent simples & explicatifs, ds l'idée de partager mon expérience d'apprentissage.

## ce qu'il faut faire

* Création du projet Symfony version 6.4 (en suivant le cours "Les bases de Symfony")
* Configuration BDD
* Création entités Categorie, Statut, Utilisateur, Ticket
* Migrations pour schéma BDD
* Installation doctrine/doctrine-fixtures-bundle
* Ajout fixtures pour catégories & statuts
* Création & première mise à jour du fichier README.md
* Chargement des fixtures (catégories& statuts) en bd

### fixture utilisateur administrateur
* ajout de l'utilisateur administrateur (`admin@agence.correcteur.fr`) ds `AppFixtures.php`
* utilisation de `UserPasswordHasherInterface` pour sécuriser le mp
* chargement des fixtures (incluant l'admin) en bdd
* mise à jour du `README.md`

### Système d'Authentification
* mise en place du système d'authentification avec `make:auth`
* configuration de la redirection après connexion ds `AppAuthenticator.php` vers `app_home`
* création de `HomeController` & du template `home/index.html.twig` pour `app_home`
* configuration de la redirection après déconnexion ds `security.yaml` vers `app_login`
* tests connexion/déconnexion ok 

### Page Public & Soumission du Ticket "client et/ou visiteur"
* création de la route `/` (nom `app_public_home`) & de la méthode `publicHome` ds `HomeController`
* création du template `public_home/index.html.twig` pour l'accueil visiteur
* ajout d'un bouton de connexion & du formulaire de saisie de ticket (sur cette page)
* création de la classe de formulaire `TicketType.php` (champs: `auteurEmail`, `description`, `categorie`)
* gestion de la soumission du formulaire ds `publicHome` pour enregistrer un new ticket
* correction du "type" de date pour `setDateOuverture` (`DateTime` au lieu de `DateTimeImmutable`)
* tests de soumission de ticket ok avec message de succès sur la page concernée






