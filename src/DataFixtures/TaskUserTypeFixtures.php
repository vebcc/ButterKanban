<?php


namespace App\DataFixtures;

use App\Entity\TaskUserType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class TaskUserTypeFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $taskUserTypes = [
            1 => ['Wlasciciel', 'Wlasciciel'],
            2 => ['Weryfikator', 'Weryfikator'],
            3 => ['Zglaszajacy', 'Zglaszajacy'],
        ];

        foreach($taskUserTypes as $key => $value){
            $taskUserType = new TaskUserType();
            $taskUserType->setName($value[1]);
            $manager->persist($taskUserType);
            $this->addReference("TaskUserType_".$value[0], $taskUserType);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['default', 'full'];
    }
}