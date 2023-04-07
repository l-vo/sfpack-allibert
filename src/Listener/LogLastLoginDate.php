<?php

namespace App\Listener;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

#[AsEventListener(LoginSuccessEvent::class, 'onLoginSuccess')]
final class LogLastLoginDate
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function onLoginSuccess(LoginSuccessEvent $loginSuccessEvent): void
    {
        $user = $loginSuccessEvent->getUser();

        if (!$user instanceof User) {
            return;
        }

        $user->setLastLogin(new \DateTimeImmutable());

        $this->userRepository->save($user, true);
    }
}