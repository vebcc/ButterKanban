<?php


namespace App\DataFixtures;

use App\Entity\TaskGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskGroupFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $group = new TaskGroup();
        $group->setName("Domyslna");
        $manager->persist($group);

        $manager->flush();
    }
}