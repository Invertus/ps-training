<?php

namespace Invertus\PsTraining\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TrainingRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('training', ChoiceType::class, [
                'choices' => [
                    'Prestashop training using Symfony' => 1,
                    'PrestaShop integrator training' => 2,
                    'PrestaShop backend training' => 3,
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('number_of_attendees', IntegerType::class)
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('notes', TextType::class)
        ;
    }
}
