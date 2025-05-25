<?php

namespace App\DataFixtures;

use App\Entity\Categorie; // import entité categorie
use App\Entity\Statut;   // import entité statut
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // --- création des catégories ---
        $categoriesNoms = ["Incident", "Panne", "Évolution", "Anomalie", "Information"]; // noms des catégories

        // boucle pour chaque catégorie
        foreach ($categoriesNoms as $nom) {
            $categorie = new Categorie(); // nouvelle catégorie
            $categorie->setNom($nom);     // son nom
            $manager->persist($categorie); // on prépare la sauvegarde
        }

        // --- création des statuts ---
        $statutsNoms = ["Nouveau", "Ouvert", "Résolu", "Fermé"]; // noms des statuts

        // boucle pour chaque statut
        foreach ($statutsNoms as $nom) {
            $statut = new Statut(); // création objet statut
            $statut->setNom($nom);   // son nom
            $manager->persist($statut); // on prépare la sauvegarde
        }

        $manager->flush(); // enregistrement en bdd (catégories & statuts)
    }
}