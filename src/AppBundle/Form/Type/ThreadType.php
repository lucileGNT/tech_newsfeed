<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ThreadType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('added_by', TextType::class)
            ->add('title', TextType::class)
            ->add('link', TextType::class)
            ->add('Save', SubmitType::class);
    }

}
