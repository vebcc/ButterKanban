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
        $group = new TaskGroup();
        $group->setName("Domyslna");
        $manager->persist($group);
        $this->addReference("TaskGroup_Default", $group);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['default', 'full'];
    }

}