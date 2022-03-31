<?php


namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;


class TaskFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $tasks = [
            ['Projekt jakis', 'cos fajnego', 1, 'Other'],
            ['Fajny projekt', 'cos ', 2, 'Bugs'],
            ['Drunk Machine', 'cos takiego', 3, 'NewFeature'],
            ['Kanban api', 'tak bylo', 4, 'Updates'],
            ['spanko', 'no', 5, 'Updates'],
            ['Mikrotik API', 'ma dzialac', 6, 'Other'],
            ['Projekcik 1', 'ma dzialac', 6, 'Bugs'],
            ['Projekt 2', 'ma dzialac', 2, 'Other'],
            ['Projekt 3', 'ma dzialac', 2, 'Bugs'],
            ['Projekt 444444', 'ma dzialac', 4, 'NewFeature']
        ];

        foreach($tasks as $key => $value){
            $task = new Task();
            $task->setTittle($value[0]);
            $task->setComment($value[1]);
            $task->setQueue($this->getReference("TaskQueue_".$value[2]));
            $task->setTaskGroup($this->getReference("TaskGroup_".$value[3]));
            $manager->persist($task);
            $this->addReference("Task_".$key, $task);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TaskQueueFixtures::class,
            TaskGroupFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return ['full'];
    }
}