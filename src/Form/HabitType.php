<?php

namespace App\Form;

use App\Entity\Habit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HabitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'habitude',
            ])
            ->add('Frequence', ChoiceType::class, [
                'label' => 'Fréquence',
                'choices' => [
                    'Quotidien' => 'quotidien',
                    'Hebdomadaire' => 'hebdomadaire',
                    'Mensuel' => 'mensuel',
                ],
            ])
            ->add('singleDate', DateType::class, [
                'label' => 'Ajouter une date de suivi',
                'widget' => 'single_text', // permet d'avoir <input type="date">
                'mapped' => false,         // non relié directement à l'entité
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Habit::class,
        ]);
    }
}
