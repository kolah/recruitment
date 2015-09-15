<?php

namespace AppBundle\Model;

/**
 * Value object representing user name.
 */
final class Name
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function name()
    {
        return $this->name;
    }

    public function equals(Name $other)
    {
        return $this->name() === $other->name();
    }
}
