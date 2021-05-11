<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class UserActivitySubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $em, private Security $security)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // must be registered before (i.e. with a higher priority than) the default Locale listener
            KernelEvents::TERMINATE => [['onTerminate', 20]],
        ];
    }

    public function onTerminate()
    {
        $user = $this->security->getUser();
        if (($user instanceof User) && !($user->isActiveNow())) {
            $user->setLastActivityAt(new \DateTime());
            $this->em->flush();
        }
    }
}
