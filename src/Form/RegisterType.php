<?php

namespace App\Form;

use App\Entity\User;
use PhpParser\Node\Stmt\Label;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'votre email',
                'attr' => [
                   'placeholder'=> 'Merci de saisir votre adresse mail'
                ] 
            ])
            ->add('password', PasswordType::class, ['label' => 'Votre mot de passe ',
            'attr' => [
               'placeholder'=> 'Merci de saisir votre prénom'
                ]
            ])
            ->add('prenom', TextType::class, [
             'label' => 'Votre prenom',
             'attr' => [
                'placeholder'=> 'Merci de saisir votre prénom'
             ]
            ])
            ->add('nom' , TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                   'placeholder'=> 'Merci de saisir votre nom'
                ]
               ])
            
               ->add('password_confirm' , PasswordType::class, [
                'label' => 'Confirmez votre mot de passe ',
                'mapped' => false,
                'attr' => [
                   'placeholder'=> 'Confirmez votre mot de passe '
                ]
               ])
               ->add('submit' , SubmitType::class, [
                'label' => "s'inscrire",
                
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
