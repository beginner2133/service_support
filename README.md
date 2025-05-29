# Projet Symfony - Suivi de Tickets (Agence Web)

Application de suivi de tickets clients pour une agence web, réalisée avec le **framework Symfony 6.4**

L'objectif est de développer une application interne permettant au personnel de l'agence de gérer les demandes (tickets) soumises par les clients via un formulaire de service au client

## Accès à l'Application

### 1. Accès Public (Clients/Visiteurs)
* **URL Principale :** `https://127.0.0.1:8000/` (en développement local)
* **Fonctionnalité :** permet aux clients de soumettre un nouveau ticket de support
* un bouton "Connexion Espace Agence" redirige vers l'interface de connexion du personnel

### 2. Accès Interne (Personnel et Administrateur)
* **URL de Connexion :** `https://127.0.0.1:8000/login`
* **Identifiants Administrateur (pour évaluation) :**
    * Email : `admin@agence.correcteur.fr`
    * Mot de passe : `correcteur`
* Après connexion, redirection vers un accueil interne (`/home`) avec un menu de navigation

## Contexte et Objectifs

L'application centralise les demandes de support client (tickets) pour une gestion efficace

* **Incident / Panne :** signalement de dysfonctionnements
* **Anomalie :** bugs ou comportements inattendus
* **Évolution :** demandes de modifications 
* **Information :** imples demandes de renseignements

C'est un outil de gestion de la relation client et de suivi de tâches

## Journal de Développement et Commits

La mise en place initiale du projet a nécessité de résoudre certains défis techniques, notamment avec la configuration de l'environnement et l'utilisation de Composer pour des paquets spécifiques comme `doctrine/doctrine-fixtures-bundle`.
Ce README sera mis à jour en parallèle des commits Git pour documenter la progression et les fonctionnalités implémentées.

## Étapes Réalisées 

### 1. Initialisation du Projet et Base de Données
* création du projet avec symfony 6.4 (`--webapp`)
* configuration de la connexion à la bdd (mariadb sur port 3307, base `service_support_db`)
* création des entités : `Categorie`, `Statut`, `Utilisateur`, `Ticket` avec leurs propriétés et relations
* génération et application des migrations pour créer le schéma de la bdd

### 2. Données Initiales (Fixtures)
* installation du paquet `doctrine/doctrine-fixtures-bundle`
* création de `AppFixtures.php`
* ajout des fixtures pour les `Categorie` ("Incident", "Panne", etc.) et les `Statut` ("Nouveau", "Ouvert", etc.)
* ajout de l'utilisateur `Administrateur` (`admin@agence.correcteur.fr`) avec mot de passe hashé (`UserPasswordHasherInterface`)
* chargement des fixtures en bdd

### 3. Authentification et Accès
* mise en place du système de connexion/déconnexion (`make:auth`)
* configuration des redirections (`AppAuthenticator.php`, `security.yaml`)
* création `HomeController` et template d'accueil interne (`/home`)
* configuration du contrôle d'accès (`access_control` ds `security.yaml`) pour `/login` (public), `/home` (`ROLE_USER`)

### 4. Fonctionnalités (Création de Ticket)
* création de la page d'accueil publique (`/`) avec formulaire de saisie de ticket
* création du formulaire `TicketType.php` (champs : `auteurEmail`, `description`, `categorie`)
* gestion de la soumission du formulaire et enregistrement des nouveaux tickets
* assignation automatique du statut "Nouveau" et de la `dateOuverture`

### 5. Fonctionnalités Internes (Tickets : Liste, Détail, Modification Statut)
* création du `TicketController` pour lister (`/ticket`) et afficher les détails (`/ticket/{id}`)
* création des templates `ticket/index.html.twig` et `ticket/show.html.twig`
* sécurisation de la section `ticket` (accessible initialement en `PUBLIC_ACCESS` pour tests, puis ajusté à `ROLE_USER`)
* création du formulaire `TicketStatusType.php` pour la modification du statut
* implémentation de la logique de modification du statut dans `TicketController` et le template `show.html.twig`
* fonctionnalités testées et opérationnelles

### 6. Interface Utilisateur (Bootstrap) et Navigation
* intégration de bootstrap 5 via cdn ds `templates/base.html.twig`
* amélioration de la barre de navigation principale pour les utilisateurs connectés
* ajout d'un lien "retour à l'accueil public" sur la page de connexion
* harmonisation du style des pages existantes avec bootstrap

### 7. CRUD Gestion des Catégories (Admin)
* génération du CRUD pour `Categorie` avec `make:crud`
* création `CategorieController.php`, `CategorieForm.php` (ou `CategorieType.php`) 
* sécurisation des routes `categorie` pour `ROLE_ADMIN` ds `security.yaml`
* ajout du lien "gérer catégories" ds la barre de navigation pour l'admin
* fonctionnalité CRUD catégories (créer, voir, modifier, supprimer) testée et opérationnelle

### 8. CRUD Gestion des Statuts (Admin) 
* génération du CRUD pour l'entité `Statut` avec `make:crud`
* création `StatutController.php`, `StatutForm.php` 
* sécurisation des routes `statut` pour `ROLE_ADMIN` ds `security.yaml`
* ajout du lien "gérer statuts" ds la barre de navigation pour l'admin
* fonctionnalité CRUD statuts (créer, voir, modifier, supprimer) testée et opérationnelle

### 9. CRUD Gestion des Utilisateurs (Admin)
* génération du CRUD pour l'entité `Utilisateur` avec `make:crud`
* création `StatutController.php`, `StatutForm.php` 
* sécurisation des routes `utilisateur` pour `ROLE_ADMIN` ds `security.yaml`
* ajout du lien "gérer utilisateurs" ds la barre de navigation pour l'admin
* adaptation du formulaire `UtilisateurForm.php` pour gérer le champ plainPassword (non mappé, répété) et l'option is_new
* adaptation de `UtilisateurController.php` pour injecter *UserPasswordHasherInterface* et gérer le hashage du mot de passe à la création et à la modification
* fonctionnalité CRUD utilisateurs (créer, voir, modifier, supprimer - avec gestion du mot de passe) testée et opérationnelle

### 10. CRUD Gestion des Tickets (Admin) 
* génération du CRUD pour l'entité `Ticket` avec `make:crud`
* création `AdminTicketController.php`, `TicketForm.php` 
* sécurisation des routes `/admin/ticket` pour `ROLE_ADMIN` ds `security.yaml`
* ajout du lien "gérer tickets (admin)" ds la barre de navigation
* adaptation du formulaire `TicketForm.php` pour inclure les champs (auteur, description, catégorie, statut, responsable, dateOuverture, dateCloture) et l'option is_new_ticket_admin
* adaptation de `AdminTicketController.php` pour gérer la création, dateOuverture auto si non fournie et la modification, gestion dateCloture si statut "Fermé"

### 11. Validation des Données
* ajout des contraintes de validation (Asserts) sur l'entité Ticket pour les champs auteurEmail (NotBlank, Email) et description (NotBlank, Length min:20, max:250)
* ajout de contraintes NotNull sur les relations categorie et statut dans l'entité Ticket
* vérification de l'affichage des messages d'erreur de validation dans les formulaires
* validation back-end fonctionnelle
