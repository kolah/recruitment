<?php

namespace AppBundle\EventSubscriber;

use AppBundle\Messages\Events\ChangedUserEmail;
use AppBundle\Service\MarketingSystem;

final class WhenChangedUserEmailNotifyMarketing
{
    /** @var MarketingSystem $marketingSystem */
    private $marketingSystem;

    public function handle(ChangedUserEmail $message)
    {
        // TODO: calling a stub function, considering it always succeeds
        $this->marketingSystem->postRequest($message);
    }

    public function __construct(MarketingSystem $marketingSystem)
    {
        $this->marketingSystem = $marketingSystem;
    }
}
