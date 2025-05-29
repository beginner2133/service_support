<?php

namespace App\Form;

use App\Entity\Categorie; 
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType; 
use Symfony\Component\Form\Extension\Core\Type\TextareaType; 
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('auteurEmail', EmailType::class, [ 
                'label' => 'Votre adresse e-mail',
                'attr' => ['placeholder' => 'vous@exemple.com']
            ])
            ->add('description', TextareaType::class, [ 
                'label' => 'Description de votre demande',
                'attr' => ['rows' => 6, 'placeholder' => 'Décrivez votre problème ou votre question (20 à 250 caractères).']
            ])
            ->add('categorie', EntityType::class, [ 
                'class' => Categorie::class, 
                'choice_label' => 'nom', 
                'label' => 'Catégorie de la demande',
                'placeholder' => 'Choisissez une catégorie', 
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
