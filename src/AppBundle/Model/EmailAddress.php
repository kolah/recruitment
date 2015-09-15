<?php

namespace AppBundle\Model;

use AppBundle\Model\Exception\InvalidEmailAddressException;

/**
 * Value object representing email address.
 */
final class EmailAddress
{
    private $host;

    private $username;

    public function __construct($address)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailAddressException(sprintf('"%s" is not a valid email address', $address));
        }

        list($this->username, $this->host) = explode('@', $address);
    }

    public function username()
    {
        return $this->username;
    }

    public function host()
    {
        return $this->host;
    }

    public function address()
    {
        return sprintf('%s@%s', $this->username, $this->host);
    }

    public function __toString()
    {
        return $this->address();
    }

    public function equals(EmailAddress $email)
    {
        return strtolower($this->address()) === strtolower($email->address());
    }
}
