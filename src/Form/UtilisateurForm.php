<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UtilisateurForm extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'adresse e-mail',
                'attr' => ['class' => 'form-control-lg']
            ])
            ->add('nom_complet', TextType::class, [
                'label' => 'nom complet',
                'required' => false, 
                'attr' => ['class' => 'form-control-lg']
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'rôles',
                'choices' => [
                    'personnel' => 'ROLE_PERSONNEL',
                    'administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true, 
                'expanded' => true,
                'attr' => ['class' => 'mb-3'],
                'label_attr' => ['class' => 'mb-1 fw-bold']
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => $options['is_new'], 
                'first_options'  => [
                    'label' => 'mot de passe',
                    'attr' => ['class' => 'form-control-lg'],
                ],
                'second_options' => [
                    'label' => 'répéter le mot de passe',
                    'attr' => ['class' => 'form-control-lg'],
                ],
                'invalid_message' => 'les champs du mot de passe doivent correspondre.',
                'constraints' => $options['is_new'] ? [
                    new NotBlank(['message' => 'veuillez entrer un mot de passe']),
                    new Length(['min' => 6, 'minMessage' => 'votre mot de passe doit comporter au moins {{ limit }} caractères', 'max' => 4096]),
                ] : [
                    new Length(['min' => 6, 'minMessage' => 'votre mot de passe doit comporter au moins {{ limit }} caractères', 'max' => 4096]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'is_new' => false, 
        ]);
        $resolver->setDefined(['is_new']); 
        $resolver->setAllowedTypes('is_new', 'bool'); 
    }
}
