<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<11; $i++) {
            $task = new Task;
            $task->setTitle('Tâche n° '. $i)
                ->setContent('Le contenue de la tâche numéro '. $i);
            
            $manager->persist($task);
        }

        $manager->flush();
    }
}
