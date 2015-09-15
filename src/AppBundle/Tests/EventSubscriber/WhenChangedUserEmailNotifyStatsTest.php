<?php

namespace AppBundle\Tests\EventSubscriber;

use AppBundle\EventSubscriber\WhenChangedUserEmailNotifyStats;
use AppBundle\Messages\Events\ChangedUserEmail;
use AppBundle\Model\EmailAddress;
use AppBundle\Model\UserId;

class WhenChangedUserEmailNotifyStatsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Frankly, with current implementation of StatsSystem,
     * we're only testing if handler passes event object to StatSystem
     * and if it initializes correctly.
     *
     * @test
     */
    public function it_notifies_stats_system()
    {
        $id = 50;
        $oldEmail = 'old@example.com';
        $newEmail = 'new@example.com';

        $event = new ChangedUserEmail(
            new UserId($id),
            new EmailAddress($oldEmail),
            new EmailAddress($newEmail)
        );

        $statSystem = $this->getMockBuilder('AppBundle\Service\StatsSystem')
            ->setMethods(['postRequest'])
            ->getMock();

        $statSystem->expects($this->once())
            ->method('postRequest')
            ->with($event)
            ->willReturn(true);

        $handler = new WhenChangedUserEmailNotifyStats($statSystem);
        $handler->handle($event);
    }
}
