<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @codeCoverageIgnore
 */
class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder; 
    }

    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<6; $i++) {
            $user = new User;
            $user->setUsername('user_'. $i)
                ->setPassword($this->encoder->encodePassword($user, '1'))
                ->setEmail('user_'.$i.'@gmail.com');
                    
            $manager->persist($user);
            $this->addReference('user_'.$i, $user);
        }

        $manager->flush();

    }
}
