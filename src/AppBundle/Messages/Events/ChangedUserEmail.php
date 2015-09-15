<?php

namespace AppBundle\Messages\Events;

use AppBundle\Model\EmailAddress;
use AppBundle\Model\UserId;
use SimpleBus\Message\Name\NamedMessage;

class ChangedUserEmail implements NamedMessage
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var EmailAddress
     */
    private $oldEmail;

    /**
     * @var EmailAddress
     */
    private $newEmail;

    public function userId()
    {
        return $this->userId;
    }

    public function oldEmail()
    {
        return $this->oldEmail;
    }

    public function newEmail()
    {
        return $this->newEmail;
    }

    public function __construct(UserId $userId, EmailAddress $oldEmail, EmailAddress $newEmail)
    {
        $this->userId = $userId;
        $this->oldEmail = $oldEmail;
        $this->newEmail = $newEmail;
    }

    public static function messageName()
    {
        return 'user.changed_email';
    }
}
