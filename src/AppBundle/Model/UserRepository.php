<?php

namespace AppBundle\Model;

use AppBundle\Model\Exception\UserNotFoundException;
use SplObjectStorage;

/**
 * Created by PhpStorm.
 * User: Radek
 * Date: 31/12/14
 * Time: 12:46.
 */
class UserRepository implements UserRepositoryInterface
{
    /** @var \SplObjectStorage|User[] */
    protected $users;

    /**
     * Iterates through user storage until certain $id is found.
     *
     * @param $id
     *
     * @return User
     *
     * @throws UserNotFoundException
     */
    public function find(UserId $id)
    {
        $this->users->rewind();

        while ($this->users->valid()) {
            $user = $this->users->current();

            if ($user->getId()->equals($id)) {
                return $user;
            }

            $this->users->next();
        }

        throw new UserNotFoundException(sprintf('User with id %d not found.', $id->id()));
    }

    public function __construct(array $users = array())
    {
        $this->users = new SplObjectStorage();

        foreach ($users as $user) {
            $this->users->attach(
                new User(
                    new UserId($user['id']),
                    new Name($user['name']),
                    new EmailAddress($user['email'])
                )
            );
        }
    }
}
