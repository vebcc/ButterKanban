<?php

namespace App\Form\TaskQueueType;

use App\Services\TaskQueue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Services\TaskQueue\TaskQueueCollectionDTO;

class TaskQueueMultipleEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('taskQueues', CollectionType::class, [
            'entry_type' => TaskQueueMultipleType::class,
            'label' => false,
            'allow_delete' => true,
            'allow_add' => true,
            'by_reference' => false
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TaskQueueCollectionDTO::class,
        ]);
    }
}
