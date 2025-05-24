<?php

namespace App\DataFixtures;

use App\Entity\Categorie; // Import de l'entité Categorie
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Liste des noms de catégorie
        $categoriesNoms = ["Incident", "Panne", "Évolution", "Anomalie", "Information"];

        // Boucle persistante
        foreach ($categoriesNoms as $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);
            $manager->persist($categorie); // Prépare la catégorie pour la sauvegarde
        }

        // $product = new Product(); // Ligne d'exemple originale
        // $manager->persist($product); // Ligne d'exemple originale

        $manager->flush(); // Enregistre ttes les catégories préparées en bd
    }
}