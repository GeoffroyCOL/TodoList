<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['TASK_EDIT', 'TASK_DELETE'])
            && $subject instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        //Si l'utilisateur est l'auteur de la tâche
        if ($subject->getUser() == $user && in_array($attribute, ['TASK_EDIT', 'TASK_DELETE'])) {
            return true;
        }

        //Si la tâche a un auteur anonyme et que l'utilisateur a un rôle ADMIN
        if ($subject->getUser()->getUsername() == 'Anonyme' && in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        return false;
    }
}
