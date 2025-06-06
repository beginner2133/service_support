<?php

namespace App\Form;

use App\Entity\Statut; 
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statut', EntityType::class, [
                'class' => Statut::class, 
                'choice_label' => 'nom',  
                'label' => 'Nouveau statut du ticket', 
                'placeholder' => 'Sélectionnez un statut', 
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
