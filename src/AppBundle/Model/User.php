<?php

namespace AppBundle\Model;

class User
{
    /** @var UserId $id */
    protected $id;

    /** @var Name $name */
    protected $name;

    /** @var EmailAddress $email */
    protected $email;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail(EmailAddress $email)
    {
        $this->email = $email;
    }

    public function __construct(UserId $id, Name $name, EmailAddress $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }
}
