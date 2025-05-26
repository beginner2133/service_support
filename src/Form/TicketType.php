<?php

namespace App\Form;

use App\Entity\Categorie; // import entity categorie
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // champ categorie
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType; // champ email
use Symfony\Component\Form\Extension\Core\Type\TextareaType; // champ description
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('auteurEmail', EmailType::class, [ // champ email de l'auteur
                'label' => 'Votre adresse e-mail',
                'attr' => ['placeholder' => 'vous@exemple.com']
            ])
            ->add('description', TextareaType::class, [ // champ description
                'label' => 'Description de votre demande',
                'attr' => ['rows' => 6, 'placeholder' => 'Décrivez votre problème ou votre question en détail (20 à 250 caractères).']
            ])
            ->add('categorie', EntityType::class, [ // champ pour la catégorie 
                'class' => Categorie::class, // entité à utiliser pour la liste
                'choice_label' => 'nom', // propriété de categorie à afficher
                'label' => 'Catégorie de la demande',
                'placeholder' => 'Choisissez une catégorie', // option vide par défaut
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
