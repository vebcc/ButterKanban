<?php

namespace App\Form\TaskType;

use App\Entity\Task;
use App\Services\TaskQueue\TaskQueueToIdTransformer;
use App\Services\TaskQueue\TaskQueueProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    private $taskQueue;

    public function __construct(TaskQueueProvider $taskQueueProvider, private TaskQueueToIdTransformer $taskQueueToIdTransformer){
        $this->taskQueue = $taskQueueProvider->getTaskByName("Nowe");
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tittle')
            ->add('comment')
            ->add('taskGroup')
            ->add('queue', HiddenType::class, [
                'label' => false,
                'data' => $this->taskQueue,
            ])
        ;

        $builder->add('taskUsers', CollectionType::class, [
            'entry_type' => TaskUserType::class,
            'label' => false,
            'allow_delete' => true,
            'allow_add' => true,
            'by_reference' => false,
        ]);

        $builder->get('queue')->addModelTransformer($this->taskQueueToIdTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
