<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{

    private function getUser()
    {
        return (new User)
            ->setUsername('Geoffroy')
            ->setPassword('Hum123')
            ->setEmail('geoffroy@gmail.com')
        ;
    }

    public function getEntity()
    {
        return (new Task)
            ->setTitle('Tâche')
            ->setContent('Le contenue de la tâche')
            ->setUser($this->getUser())
        ;
    }

    public function assertHasErrors(Task $task, int $number = 0)
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($task);

        $messages = [];

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }

        $this->assertCount($number, $errors, implode(', ', $messages));
    }
    
    /**
     * testValideEntity - Test pour savoir si une entité est valide
     */
    public function testValideEntityTask()
    {
        $this->assertHasErrors($this->getEntity());
    }
    
    /**
     * -----
     * Title
     * -----
     */

    /**
     * testInvalideBlankTitle - Test si le titre de la tâche est vide
     */
    public function testInvalideBlankTitle()
    {
        $this->assertHasErrors($this->getEntity()->setTitle(''), 1);
    }

    /**
     * testInvalideUniqueTitle - Teste si la tâche est unique
     */
    public function testInvalideUniqueTitle()
    {
        $this->assertHasErrors($this->getEntity()->setTitle('Tâche n° 10'), 1);
    }

    /**
     * -------
     * Content
     * -------
     */

    /**
     * testInvalideBlankContent - Test si le contenue de la tâche est vide
     */
    public function testInvalideBlankContent()
    {
        $this->assertHasErrors($this->getEntity()->setContent(''), 1);
    }
}