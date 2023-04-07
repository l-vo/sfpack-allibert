<?php

namespace App\Security\Voter;

use App\Entity\Movie;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class OrderMovieVoter extends Voter
{
    private const ORDER_MOVIE = 'ORDER_MOVIE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::ORDER_MOVIE;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if (!$subject instanceof Movie) {
            return false;
        }

        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        $minAge = $subject->getMinAge();
        if (null === $minAge) {
            return true;
        }

        return $user->isOlderThan($minAge, new \DateTimeImmutable());
    }
}