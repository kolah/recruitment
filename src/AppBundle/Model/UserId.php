<?php

namespace AppBundle\Model;

use AppBundle\Model\Exception\InvalidValueForUserIdException;

/**
 * Value object for User ID.
 */
final class UserId
{
    /** @var int $id */
    private $id;

    public function id()
    {
        return $this->id;
    }

    public function __construct($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidValueForUserIdException(sprintf('User id should be a number, given "%s".', $id));
        }

        $this->id = (int) $id;
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    public function equals(UserId $userId)
    {
        return $this->id === $userId->id;
    }
}
