<?php

namespace App\DataFixtures;

use App\Entity\Categorie; // import entité categorie
use App\Entity\Statut;   // import entité statut
use App\Entity\Utilisateur; // import entité utilisateur
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; // pour hasher le mp

class AppFixtures extends Fixture
{
    // propriété pour stocker le hasher
    private UserPasswordHasherInterface $passwordHasher;

    // constructeur pour injecter le hasher
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // création des catégories
        $categoriesNoms = ["Incident", "Panne", "Évolution", "Anomalie", "Information"];

        foreach ($categoriesNoms as $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);
            $manager->persist($categorie);
        }

        // création des statuts 
        $statutsNoms = ["Nouveau", "Ouvert", "Résolu", "Fermé"];

        foreach ($statutsNoms as $nom) {
            $statut = new Statut();
            $statut->setNom($nom);
            $manager->persist($statut);
        }

        // création de l'utilisateur Admin
        $admin = new Utilisateur();
        $admin->setEmail('admin@agence.correcteur.fr'); // email du correcteur
        $admin->setRoles(['ROLE_ADMIN']); // attribution du rôle Admin
        $admin->setNomComplet('Administrateur Principal'); // en option = nom complet

        // hashage du mp
        $admin->setPassword(
            $this->passwordHasher->hashPassword(
                $admin,
                'correcteur' // mp en clair = sera hashé
            )
        );

        $manager->persist($admin); // admin pour la sauvegarde

        $manager->flush(); // enregistre les objets (catégories, statuts, admin) en bdd
    }
}