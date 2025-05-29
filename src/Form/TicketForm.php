<?php

namespace App\Form;

use App\Entity\Ticket;
use App\Entity\Categorie;
use App\Entity\Statut;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketForm extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('auteurEmail', EmailType::class, [
                'label' => 'Email de l\'auteur',
                'attr' => ['class' => 'form-control-lg']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['rows' => 5, 'class' => 'form-control-lg']
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'placeholder' => 'Choisissez une catégorie',
                'attr' => ['class' => 'form-select-lg']
            ])
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'nom',
                'label' => 'Statut',
                'placeholder' => 'Choisissez un statut',
                'attr' => ['class' => 'form-select-lg']
            ])
            ->add('responsable', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'email', 
                'label' => 'Responsable',
                'placeholder' => 'Aucun responsable',
                'required' => false, 
                'attr' => ['class' => 'form-select-lg']
            ])
            ->add('dateOuverture', DateTimeType::class, [
                'label' => 'Date d\'ouverture',
                'widget' => 'single_text', 
                'html5' => true, 
                'required' => false, 
                'disabled' => !$options['is_new_ticket_admin'],
                'attr' => ['class' => 'form-control-lg']
            ])
            ->add('dateCloture', DateTimeType::class, [
                'label' => 'Date de clôture',
                'widget' => 'single_text',
                'html5' => true,
                'required' => false, 
                'attr' => ['class' => 'form-control-lg']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
            'is_new_ticket_admin' => false, 
        ]);
        $resolver->setAllowedTypes('is_new_ticket_admin', 'bool');
    }
}
