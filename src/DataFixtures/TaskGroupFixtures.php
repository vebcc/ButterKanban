<?php


namespace App\DataFixtures;

use App\Entity\TaskGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class TaskGroupFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $groups = [
            ['Domyslna', 'Default'],
            ['Inne', 'Other'],
            ['Błedy', 'Bugs'],
            ['Aktualizacje', 'Updates'],
            ['Nowa Funkcjonalnosc', 'NewFeature']
        ];

        foreach($groups as $key => $value){
            $group = new TaskGroup();
            $group->setName($value[0]);
            $manager->persist($group);
            $this->addReference("TaskGroup_".$value[1], $group);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['default', 'full'];
    }

}