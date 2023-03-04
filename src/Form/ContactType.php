<?php

namespace App\Form;

use App\Entity\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('resivedFrom', EmailType::class, [
                    'label'=>"Adresse Email",
                    'attr' =>[
                        'class' => 'form-control'
                    ],
                    'label_attr' => [
                        'class' => 'form-label mt-2'
                    ]
                ])
            ->add('subject', TextTYpe::class, [
                    'label'=>"Sujet",
                    'attr' =>[
                        'class' => 'form-control'
                    ],
                    'label_attr' => [
                        'class' => 'form-label mt-2'
                    ]
                ])
            ->add('phone', TextType::class, [
                    'label'=>"Téléphone",
                    'attr' =>[
                        'class' => 'form-control'
                    ],
                    'label_attr' => [
                        'class' => 'form-label mt-2'
                    ]
                ])
            ->add('message', TextareaType::class, [
                    'label'=>"Message",
                    'attr' =>[
                        'class' => 'form-control'
                    ],
                    'label_attr' => [
                        'class' => 'form-label mt-2'
                    ]
                ])
            ->add('submit',SubmitType::class, [
                'attr' =>[
                    'class' => 'btn btn-primary mt-2'
                ],
                'label' => 'Envoyer '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Email::class,
        ]);
    }
}
