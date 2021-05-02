<?php

namespace App\Form;

use App\Entity\NotificationBlock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotificationBlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'user_validation', ChoiceType::class, [
                    'label' => 'Ce bloc doit-il être validé par l\'utilisateur ?',
                    'choices'  => [
                        'Oui' => true,
                        'Non' => false
                    ],
                    'expanded' => true,
                    'required' => true
                ]
            )->add(
                'notificationBlockContents', CollectionType::class, [
                    'entry_type' => NotificationBlockContentType::class,
                    'entry_options' => ['label' => false],
                    'by_reference' => false,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => NotificationBlock::class,
            ]
        );
    }
}
