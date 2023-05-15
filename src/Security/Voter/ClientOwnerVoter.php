<?php

namespace App\Security\Voter;

use App\Loans\Domain\Model\Client;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ClientOwnerVoter extends Voter
{
    public const VIEW = 'OWNER_VIEW';

    public function __construct(
        private Security $security
    ){}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW])
            && $subject instanceof Client;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        return $subject->getEmail() === $user->getUserIdentifier() || ($this->security->isGranted('ROLE_ADMIN'));
    }
}
