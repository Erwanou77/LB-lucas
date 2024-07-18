<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de famille',
                'constraints' => [
                    new NotBlank(message: 'Veuillez entrer votre nom de famille')
                ],
                'attr' => [
                    'placeholder' => 'Votre nom de famille',
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank(message: 'Veuillez entrer votre prénom')
                ],
                'attr' => [
                    'placeholder' => 'Votre prénom',
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Votre email',
                ],
                'constraints' => [
                    new NotBlank(message: 'Veuillez entrer une adresse mail'),
                    new Email(),
                ],
            ])
            ->add('company', TextType::class, [
                'label' => 'Entreprise',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre entreprise',
                ]
            ])
            ->add('job', TextType::class, [
                'label' => 'Poste occupé',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre titre de poste occupé'
                ]
            ])
            ->add('linkedin', UrlType::class, [
                'label' => 'Avez-vous un profil linkedin ?',
                'required' => false,
                'attr' => [
                    'placeholder' => 'URL (Si vous n\'en avez pas, laissez ce champ vide)'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Une remarque à apporter ?',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre message',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Je souhaite recevoir le livre blanc',
                'attr' => [
                    'class' => 'buttons'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
