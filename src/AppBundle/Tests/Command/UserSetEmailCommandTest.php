<?php

namespace AppBundle\Tests\Command;

use AppBundle\Command\UserSetEmailCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class UserSetEmailCommandTest extends KernelTestCase
{
    const commandName = 'user:set-email';

    /** @test */
    public function it_executes_change_user_email_command()
    {
        $commandTester = $this->createCommandTester();
        $commandTester->execute([
            'command' => self::commandName,
            'id' => '1037',
            'email' => 'new@example.com',
        ]);

        $this->assertRegExp('/successfully/', $commandTester->getDisplay());
        $this->assertEquals(0, $commandTester->getStatusCode());
    }

    /** @test */
    public function it_shows_error_on_invalid_email()
    {
        $commandTester = $this->createCommandTester();

        $commandTester->execute([
            'command' => self::commandName,
            'id' => '1037',
            'email' => 'invalid',
        ]);

        $this->assertRegExp('/not a valid email address/', $commandTester->getDisplay());
        $this->assertEquals(1, $commandTester->getStatusCode());
    }

    /** @test */
    public function it_shows_error_on_invalid_user_id_value()
    {
        $commandTester = $this->createCommandTester();

        $commandTester->execute([
            'command' => self::commandName,
            'id' => 'nom',
            'email' => 'new@example.com',
        ]);

        $this->assertRegExp('/should be a number/', $commandTester->getDisplay());
        $this->assertEquals(1, $commandTester->getStatusCode());
    }

    /** @test */
    public function it_shows_error_on_unexisting_user()
    {
        $commandTester = $this->createCommandTester();
        $commandTester->execute([
            'command' => self::commandName,
            'id' => '15',
            'email' => 'new@example.com',
        ]);

        $this->assertRegExp('/User(.*)not found/', $commandTester->getDisplay());
        $this->assertEquals(1, $commandTester->getStatusCode());
    }

    private function createCommandTester()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new UserSetEmailCommand());

        $command = $application->find(self::commandName);
        $commandTester = new CommandTester($command);

        return $commandTester;
    }
}
