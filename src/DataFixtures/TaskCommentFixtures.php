<?php


namespace App\DataFixtures;

use App\Entity\TaskComment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class TaskCommentFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $taskComments = [
            1 => [1, 'vebcc', 0, 'cos tam zrobiono'],
            2 => [2, 'vebcc', 0, 'cos sie zepsulo'],
            3 => [3, 'janusz', 0, 'nie ma kawy nie ma efektow'],
            4 => [5, 'andrzej', 0, 'nie chce mi sie'],
            5 => [7, 'andrzej', 0, 'to w poniedzialek'],
            6 => [2, 'janusz', 0, 'dziwne u mnie dziala'],
            7 => [3, 'janusz', 0, 'powinno dzialac'],
            8 => [4, 'vebcc', 0, 'zaraz wracam'],
            9 => [4, 'vebcc', 0, 'sam se napraw'],
            10 => [8, 'vebcc', 0, 'ide spac'],
        ];

        foreach($taskComments as $key => $value){
            $taskComment = new TaskComment();
            $taskComment->setTask($this->getReference("Task_".$value[0]));
            $taskComment->setUser($this->getReference("User_".$value[1]));
            $taskComment->setType($value[2]);
            $taskComment->setComment($value[3]);
            $manager->persist($taskComment);
            $this->addReference("TaskComment_".$key, $taskComment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TaskFixtures::class,
            UserFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['full'];
    }
}