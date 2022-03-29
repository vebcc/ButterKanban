<?php


namespace App\DataFixtures;

use App\Entity\TaskUser;
use App\Entity\TaskUserType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;


class TaskUserFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $taskUsers = [
            [0, 'vebcc', "Zglaszajacy"],
            [1, 'vebcc', "Zglaszajacy"],
            [2, 'janusz', "Zglaszajacy"],
            [3, 'andrzej', "Zglaszajacy"],
            [4, 'vebcc', "Zglaszajacy"],
            [5, 'andrzej', "Zglaszajacy"],
            [6, 'janusz', "Zglaszajacy"],
            [7, 'janusz', "Zglaszajacy"],
            [8, 'andrzej', "Zglaszajacy"],
            [9, 'vebcc', "Zglaszajacy"],
            [0, 'andrzej', "Weryfikator"],
            [1, 'janusz', "Weryfikator"],
            [2, 'andrzej', "Weryfikator"],
            [3, 'vebcc', "Weryfikator"]
        ];

        foreach($taskUsers as $key => $value){
            $taskUser = new TaskUser();
            $taskUser->setTask($this->getReference("Task_".$value[0]));
            $taskUser->setUser($this->getReference("User_".$value[1]));
            $taskUser->setTaskUserType($this->getReference("TaskUserType_".$value[2]));
            $manager->persist($taskUser);
            $this->addReference("TaskUser_".$key, $taskUser);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TaskFixtures::class,
            UserFixtures::class,
            TaskUserTypeFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['full'];
    }
}