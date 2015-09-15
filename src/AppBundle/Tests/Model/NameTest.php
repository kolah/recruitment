<?php

namespace AppBundle\Tests\Model;

use AppBundle\Model\Name;

class NameTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_equal_to_other_instance_with_the_same_name()
    {
        $name1 = new Name('Rafaello');
        $name2 = new Name('Rafaello');

        $this->assertTrue($name1->equals($name2));
    }

    /** @test */
    public function it_converts_to_string()
    {
        $name = new Name('Leonardo');
        $this->assertEquals('Leonardo', (string) $name);
    }
}
