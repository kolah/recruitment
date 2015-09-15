<?php

namespace AppBundle\Tests\Model;

use AppBundle\Model\UserId;

class UserIdTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_equal_to_other_instance_with_the_same_id()
    {
        $id1 = new UserId(1234);
        $id2 = new UserId(1234);

        $this->assertTrue($id1->equals($id2));
    }

    /** @test */
    public function it_can_be_casted_to_string()
    {
        $id = new UserId(1234);
        $this->assertEquals('1234', (string) $id);
    }

    /** @test */
    public function it_throws_exception_when_constructed_with_non_numeric_value()
    {
        $this->setExpectedException('AppBundle\Model\Exception\InvalidValueForUserIdException');
        new UserId('non');
    }
}
