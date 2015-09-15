<?php

namespace AppBundle\CommandHandler;

use AppBundle\Messages\Command\ChangeUserEmail;
use AppBundle\Messages\Events\ChangedUserEmail;
use AppBundle\Model\UserRepositoryInterface;
use SimpleBus\Message\Bus\MessageBus;

final class UserHandler
{
    /** @var UserRepositoryInterface */
    private $userManager;

    /** @var MessageBus $eventBus */
    private $eventBus;

    public function handleChangeUserEmail(ChangeUserEmail $changeUserEmail)
    {
        $user = $this->userManager->find($changeUserEmail->userId());
        $oldEmail = $user->getEmail();
        $newEmail = $changeUserEmail->newEmail();

        // perform action only if email address has changed
        if (false === $newEmail->equals($oldEmail)) {
            $user->setEmail($changeUserEmail->newEmail());
            // normally we would call something like:
            // $this->userManager->save($user);
            // but we are changing in-memory value

            // notify subscribers using specific event
            $changedUserEmailEvent = new ChangedUserEmail($changeUserEmail->userId(), $oldEmail, $newEmail);
            $this->eventBus->handle($changedUserEmailEvent);
        }
    }

    public function __construct(UserRepositoryInterface $userManager, MessageBus $eventBus)
    {
        $this->userManager = $userManager;
        $this->eventBus = $eventBus;
    }
}
