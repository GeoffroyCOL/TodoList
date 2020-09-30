<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * @codeCoverageIgnore
 */
class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $u = 1;

        for ($i=1; $i<11; $i++) {
            $task = new Task;

            if ($u > 5) {
                $u = 1;
            }

            $task->setTitle('Tâche n° '. $i)
                ->setContent('Le contenue de la tâche numéro '. $i)
                ->setUser($this->getReference('user_'.$u))
            ;

            $u++;
            
            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
