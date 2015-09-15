<?php

namespace AppBundle\Tests\Model;

use AppBundle\Model\UserId;
use AppBundle\Model\UserRepository;

class UserRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    protected function setUp()
    {
        $initialUsers = [
            ['id' => 1038, 'name' => 'Splinter', 'email' => 'splinter@example.com'],
        ];

        $this->userRepository = new UserRepository($initialUsers);
    }

    /** @test */
    public function it_finds_user_in_repository()
    {
        $id = new UserId(1038);
        $user = $this->userRepository->find($id);

        $this->assertTrue($id->equals($user->getId()));
        $this->assertEquals('Splinter', $user->getName());
    }

    /** @test */
    public function it_throws_exception_when_user_not_found()
    {
        $this->setExpectedException('AppBundle\Model\Exception\UserNotFoundException');
        $id = new UserId(33);
        $this->userRepository->find($id);
    }
}
