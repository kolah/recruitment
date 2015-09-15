<?php

namespace AppBundle\Tests\CommandHandler;

use AppBundle\CommandHandler\UserHandler;
use AppBundle\Messages\Command\ChangeUserEmail;
use AppBundle\Model\EmailAddress;
use AppBundle\Model\Name;
use AppBundle\Model\User;
use AppBundle\Model\UserId;
use AppBundle\Model\UserRepositoryInterface;
use SimpleBus\Message\Bus\MessageBus;

class UserHandlerTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_handles_email_address_change()
    {
        $userId = new UserId(11);
        $oldEmail = new EmailAddress('splinter@example.com');
        $newEmail = new EmailAddress('new@example.com');

        $user = new User(
            $userId,
            new Name('Splinter'),
            $oldEmail
        );

        $command = new ChangeUserEmail($userId, $newEmail);

        $repository = $this->getUserRepositoryMock();

        $repository->expects($this->once())
            ->method('find')
            ->willReturn($user);

        $interceptedMessage = null;

        $eventBus = $this->getEventBusMock();
        $eventBus->expects($this->once())
            ->method('handle')
            ->willReturnCallback(
                function ($message) use (&$interceptedMessage) {
                    $interceptedMessage = $message;
                }
            );
        $commandHandler = new UserHandler($repository, $eventBus);
        $commandHandler->handleChangeUserEmail($command);

        // change should trigger event
        $this->assertInstanceOf('AppBundle\Messages\Events\ChangedUserEmail', $interceptedMessage);
        $this->assertTrue($userId->equals($interceptedMessage->userId()));

        // finally check if address changed
        $this->assertTrue($user->getEmail()->equals($newEmail));
    }

    /** @test */
    public function it_does_not_trigger_event_when_email_not_changed()
    {
        $userId = new UserId(11);
        $email = new EmailAddress('splinter@example.com');

        $user = new User(
            $userId,
            new Name('Splinter'),
            $email
        );

        $command = new ChangeUserEmail($userId, $email);
        $repository = $this->getUserRepositoryMock();

        $repository->expects($this->once())
            ->method('find')
            ->willReturn($user);

        $eventBus = $this->getEventBusMock();
        $eventBus->expects($this->never())
            ->method('handle');

        $commandHandler = new UserHandler($repository, $eventBus);
        $commandHandler->handleChangeUserEmail($command);
    }

    /**
     * @return MessageBus|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getEventBusMock()
    {
        return $this->getMockBuilder('SimpleBus\Message\Bus\MessageBus')
            ->setMethods(['handle'])
            ->getMockForAbstractClass();
    }

    /**
     * @return UserRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getUserRepositoryMock()
    {
        return $this->getMockBuilder('AppBundle\Model\UserRepositoryInterface')
            ->setMethods(['find'])
            ->getMockForAbstractClass();
    }
}
