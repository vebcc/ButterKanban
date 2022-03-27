<?php


namespace App\DataFixtures;

use App\Entity\TaskQueue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class TaskQueueFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $queues = [
            1 => 'Nowe',
            2 => 'Analiza wymagań',
            3 => 'Kodowanie',
            4 => 'Testy',
            5 => 'Wdrozenie',
            6 => 'Dostarczone'
        ];

        foreach($queues as $key => $value){
            $queue = new TaskQueue();
            $queue->setName($value);
            $queue->setPriority($key);
            $manager->persist($queue);
            $this->addReference("TaskQueue_".$key, $queue);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['default', 'full'];
    }
}