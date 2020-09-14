<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{    
    /**
     * getEntity
     *
     * @return User
     */
    public function getEntity()
    {
        return (new User)
            ->setUsername('Geoffroy')
            ->setPassword('Hum123')
            ->setEmail('geoffroy@gmail.com')
        ;
    }
    
    /**
     * assertHasErrors
     *
     * @param  User $user
     * @param  Int $number
     * @return void
     */
    public function assertHasErrors(User $user, int $number = 0)
    {
        self::bootKernel();
        $error = self::$container->get('validator')->validate($user);

        $this->assertCount($number, $error);
    }
    
    /**
     * --------------------
     * Validité de l'entité
     * --------------------
     */

    /**
     * testValideEntityUser - Si l'entité est valide
     */
    public function testValideEntityUser()
    {
        $this->assertHasErrors($this->getEntity());
    }

    /**
     * --------
     * Username
     * --------
     */
    
    /**
     * testInvalideEntityUserBlankUsername - Si l'attribut username est vide
     */
    public function testInvalideEntityUserBlankUsername()
    {
        $this->assertHasErrors($this->getEntity()->setUsername(''), 1);
    }
    
    /**
     * testInvalideEntityUserLimitUsername - Si l'attribut username ne dépasse pas 25 caractères
     */
    public function testInvalideEntityUserLengthUsername()
    {
        $this->assertHasErrors($this->getEntity()->setUsername('abcdefghijklmnopqrstuvwxyz'), 1);
    }

    
    /**
     * -----
     * Email
     * -----
     */

    /**
     * testInvalideEntityUserBlankEmail - Si l'attribut email est vide
     */
    public function testInvalideEntityUserBlankEmail()
    {
        $this->assertHasErrors($this->getEntity()->setEmail(''), 1);
    }
    
    /**
     * testInvalideEntityUserFormatEmail - Si le format de l'email est correcte
     */
    public function testInvalideEntityUserFormatEmail()
    {
        $this->assertHasErrors($this->getEntity()->setEmail('geoffroy'), 1);
    }
    
    /**
     * testInvalideEntityUserUniqueEmail - Si l'email est unique
     */
    public function testInvalideEntityUserUniqueEmail()
    {
        $this->assertHasErrors($this->getEntity()->setEmail('user_1@gmail.com'), 1);
    }
    
    /**
     * testInvalideEntityUserLengthEmail - Limit le nombre de caractère de l'adresse email a 60 caractères
     */
    public function testInvalideEntityUserLengthEmail()
    {
        $this->assertHasErrors($this->getEntity()->setPassword('geoffroygggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg@gmail.com'), 1);
    }

    /**
     * --------
     * Password
     * --------
     */
    
    /**
     * testInvalideEntityUserFormatPassword - Si le mot de passe est au bon format, c'est a dire
     * Il doit contenir au moins une majuscule, une minuscule et un nombre et avoir six 6 caractères au minimum
     */
    public function testInvalideEntityUserFormatPassword()
    {
        $this->assertHasErrors($this->getEntity()->setPassword('123humd'), 1);
    }
    
    /**
     * testInvalideEntityUserBlankPassword - Si le mot de passe est vide
     */
    public function testInvalideEntityUserBlankPassword()
    {
        $this->assertHasErrors($this->getEntity()->setPassword(''), 1);
    }
}
