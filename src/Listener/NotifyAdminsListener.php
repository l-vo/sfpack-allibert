<?php

namespace App\Listener;

use App\Entity\User;
use App\Event\MoviePageViewedEvent;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(MoviePageViewedEvent::class, 'onMoviePageView')]
final class NotifyAdminsListener
{
    public function __construct(
        private Security $security,
        private UserRepository $userRepository,
    )
    {
    }

    public function onMoviePageView(MoviePageViewedEvent $moviePageViewEvent): void
    {
        $movie = $moviePageViewEvent->movie;

        $minAge = $movie->getMinAge();
        if ($minAge === null) {
            return;
        }

        $user = $this->security->getUser();
        if (!$user instanceof User) {
            return;
        }

        if (!$user->isOlderThan($minAge, new \DateTimeImmutable())) {
            dump($this->userRepository->findAllAdmins());
        }
    }
}