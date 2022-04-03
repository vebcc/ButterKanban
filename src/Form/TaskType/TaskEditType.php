<?php

namespace App\Form\TaskType;

use App\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tittle')
            ->add('comment')
            ->add('startData', DateTimeType::class, [
                'html5' => true,
                'row_attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('taskGroup')
            ->add('queue')
        ;

        $builder->add('taskUsers', CollectionType::class, [
            'entry_type' => TaskUserType::class,
            'label' => false,
            'allow_delete' => true,
            'allow_add' => true,
            'by_reference' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
