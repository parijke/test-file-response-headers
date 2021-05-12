<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserActivitySubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private TokenStorageInterface $tokenStorage
        )
    {
    }

    public static function getSubscribedEvents(): array
    {
    
        return [
            KernelEvents::CONTROLLER => [['onController']],
        ];
    }

    public function onController()
    {

        $user = $this->tokenStorage?->getToken()?->getUser();

        if (($user instanceof User)) {
            $user->setLastActivityAt(new \DateTime());
            $this->em->flush();
        }
    }
}
