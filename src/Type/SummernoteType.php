<?php

namespace App\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SummernoteType extends AbstractType
{

    public function getParent()
    {
        return TextareaType::class;
    }

}
