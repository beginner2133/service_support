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







