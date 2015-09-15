<?php

namespace AppBundle\Tests\Model;

use AppBundle\Model\EmailAddress;

/**
 * Immutable value object representing email address.
 */
class EmailAddressTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_instantiates_with_valid_email_address()
    {
        $email = new EmailAddress('leonardo@example.com');
        $this->assertInstanceOf('AppBundle\Model\EmailAddress', $email);
    }

    /** @test */
    public function it_returns_email_address_when_casted_to_string()
    {
        $email = new EmailAddress('leonardo@example.com');
        $this->assertEquals('leonardo@example.com', (string) $email);
    }

    /** @test */
    public function it_extracts_username_and_host()
    {
        $email = new EmailAddress('leonardo@example.com');
        $this->assertEquals('example.com', $email->host());
        $this->assertEquals('leonardo', $email->username());
    }

    /** @test */
    public function it_is_equal_to_other_instance_with_the_same_address()
    {
        $email1 = new EmailAddress('leonardo@example.com');
        $email2 = new EmailAddress('leonardo@example.com');
        $this->assertTrue($email1->equals($email2));

        $email3 = new EmailAddress('LeOnArDo@eXaMpLe.com');
        $email4 = new EmailAddress('leonardo@example.com');
        $this->assertTrue($email3->equals($email4));
    }
}
