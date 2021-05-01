<?php

namespace App\Form;

use App\Entity\Notification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;

class NotificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title', TextType::class, [
                    'label' => 'Titre',
                    'constraints' => [
                        new Required(),
                        new NotBlank()
                    ]
                ]
            )->add(
                'activation_date', DateType::class, [
                    'label' => 'Date d\'activation',
                    'required' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime_immutable'
                ]
            )->add(
                'notificationBlocks', CollectionType::class, [
                    'entry_type' => NotificationBlockType::class,
                    'entry_options' => ['label' => false],
                    'by_reference' => false,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            )->add(
                'save', SubmitType::class, [
                    'label' => 'Sauvegarder',
                    'attr' => [
                        'class' => 'btn btn-primary'
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Notification::class,
            ]
        );
    }
}
