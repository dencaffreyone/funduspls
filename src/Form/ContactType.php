<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

class ContactType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('name', TextType::class, [
            'attr' => [
                'placeholder' => 'First, Lastname'
            ],
           'constraints' => [
                new NotNull()
            ]
        ]);

        $builder->add('email', EmailType::class, [
            'attr' => [
                'placeholder' => 'E-Mail'
            ],
            'constraints' => [
                new NotNull()
            ]
        ]);

        $builder->add('message', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Message'
            ],
            'constraints' => [
                new NotNull()
            ]
        ]);

        $builder->add('agree', CheckboxType::class, [
            'constraints' => [
                new NotNull()
            ]
        ]);
    }

}