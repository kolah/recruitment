<?php

namespace AppBundle\Tests\EventSubscriber;

use AppBundle\EventSubscriber\WhenChangedUserEmailNotifyMarketing;
use AppBundle\Messages\Events\ChangedUserEmail;
use AppBundle\Model\EmailAddress;
use AppBundle\Model\UserId;

class WhenChangedUserEmailNotifyMarketingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Frankly, with current implementation of MarketingSystem,
     * we're only testing if handler passes event object to MarketingSystem
     * and if it initializes correctly.
     *
     * @test
     */
    public function it_notifies_marketing_system()
    {
        $id = 50;
        $oldEmail = 'old@example.com';
        $newEmail = 'new@example.com';

        $event = new ChangedUserEmail(
            new UserId($id),
            new EmailAddress($oldEmail),
            new EmailAddress($newEmail)
        );

        $marketingSystem = $this->getMockBuilder('AppBundle\Service\MarketingSystem')
            ->setMethods(['postRequest'])
            ->getMock();

        $marketingSystem->expects($this->once())
            ->method('postRequest')
            ->with($event)
            ->willReturn(true);

        $handler = new WhenChangedUserEmailNotifyMarketing($marketingSystem);
        $handler->handle($event);
    }
}
