<?php

namespace AppBundle\EventSubscriber;

use AppBundle\Messages\Events\ChangedUserEmail;
use Psr\Log\LoggerInterface;

final class WhenChangedUserEmailLogChange
{
    /** @var LoggerInterface */
    private $logger;

    public function handle(ChangedUserEmail $message)
    {
        $this->logger->notice(
            sprintf('Changed email address for UserId %d from %s to %s.',
                $message->userId()->id(),
                $message->oldEmail()->address(),
                $message->newEmail()->address()
            )
        );
    }

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
