<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'mon adresse mail'
            ])
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'label' => 'mon mot de passe actuel',
                'attr' => [
                    'placeholder' => 'veuillez saisir votre mot de passe actuel'
                ]
            ])

            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'le mot de passe et la confirmation doivent etre identiques ',
                
                'label' => 'mon nouveau mot de passe ',
                'required' => true,
                'first_options' => [ 
                    'label' => 'mon nouveau mot de passe ', 
                    'attr' => [
                        'placeholder'=> 'Merci de saisir votre nouveau mot de passe ',
                    ]
                    
                ],
                'second_options' => [ 'label' => 'Confirmez votre nouveau mot de passe  ' ],
                
            ])
            ->add('prenom', TextType::class, [
                'disabled' => true,
                'label' => 'mon prenom'
            ])
            ->add('nom' , TextType::class, [
                'disabled' => true,
                'label' => 'mon nom'
            ])

            ->add('submit' , SubmitType::class, [
                'label' => "Mettre à jour ",
                
               ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
