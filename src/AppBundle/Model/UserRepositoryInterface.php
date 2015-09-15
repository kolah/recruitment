<?php

namespace AppBundle\Model;

use AppBundle\Model\Exception\UserNotFoundException;

interface UserRepositoryInterface
{
    /**
     * @param UserId $id
     *
     * @return User
     *
     * @throws UserNotFoundException
     */
    public function find(UserId $id);
}
