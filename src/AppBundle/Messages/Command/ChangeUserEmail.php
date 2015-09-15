<?php

namespace AppBundle\Messages\Command;

use AppBundle\Model\EmailAddress;
use AppBundle\Model\UserId;
use SimpleBus\Message\Name\NamedMessage;

class ChangeUserEmail implements NamedMessage
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var EmailAddress
     */
    private $newEmail;

    public function userId()
    {
        return $this->userId;
    }

    public function newEmail()
    {
        return $this->newEmail;
    }

    public function __construct(UserId $userId, EmailAddress $newEmail)
    {
        $this->userId = $userId;
        $this->newEmail = $newEmail;
    }

    public static function messageName()
    {
        return 'user.change_email';
    }
}
