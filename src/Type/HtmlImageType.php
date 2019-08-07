<?php

namespace App\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HtmlImageType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('src');
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['src'] = $options['src'];
    }

}
