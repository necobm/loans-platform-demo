<?php

namespace App\Security\Voter;

use App\Loans\Domain\Model\ClientFinancialPreferences;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ClientPreferencesOwnerVoter extends Voter
{
    public const VIEW = 'OWNER_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW])
            && $subject instanceof ClientFinancialPreferences;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        return $subject->getClient()->getEmail() === $user->getUserIdentifier();
    }
}
