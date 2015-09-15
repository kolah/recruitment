<?php

namespace AppBundle\Tests\EventSubscriber;

use AppBundle\EventSubscriber\WhenChangedUserEmailLogChange;
use AppBundle\Messages\Events\ChangedUserEmail;
use AppBundle\Model\EmailAddress;
use AppBundle\Model\UserId;

class WhenChangedUserEmailLogChangeTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_logs_event()
    {
        $id = 50;
        $oldEmail = 'old@example.com';
        $newEmail = 'new@example.com';

        $event = new ChangedUserEmail(
            new UserId($id),
            new EmailAddress($oldEmail),
            new EmailAddress($newEmail)
        );

        $logger = $this->getMockBuilder('Psr\Log\LoggerInterface')
            ->setMethods(['notice'])
            ->getMockForAbstractClass();

        $logger->expects($this->once())
            ->method('notice')
            ->with(sprintf('Changed email address for UserId %d from %s to %s.', $id, $oldEmail, $newEmail));

        $handler = new WhenChangedUserEmailLogChange($logger);
        $handler->handle($event);
    }
}
