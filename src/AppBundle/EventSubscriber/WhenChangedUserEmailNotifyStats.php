<?php

namespace AppBundle\EventSubscriber;

use AppBundle\Messages\Events\ChangedUserEmail;
use AppBundle\Service\StatsSystem;

final class WhenChangedUserEmailNotifyStats
{
    /** @var StatsSystem $statsSystem */
    private $statsSystem;

    public function handle(ChangedUserEmail $message)
    {
        // TODO: calling a stub function, considering it always succeeds
        $this->statsSystem->postRequest($message);
    }

    public function __construct(StatsSystem $statsSystem)
    {
        $this->statsSystem = $statsSystem;
    }
}
