<?php

namespace AppBundle\Command;

use AppBundle\Messages\Command\ChangeUserEmail;
use AppBundle\Model\EmailAddress;
use AppBundle\Model\Exception\InvalidEmailAddressException;
use AppBundle\Model\Exception\InvalidValueForUserIdException;
use AppBundle\Model\Exception\UserNotFoundException;
use AppBundle\Model\UserId;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserSetEmailCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('user:set-email')
            ->setDescription('Change user\'s email')
            ->addArgument(
                'id',
                InputArgument::REQUIRED,
                'Numeric user ID'
            )
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'Target e-mail address'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $userId = new UserId($input->getArgument('id'));
            $newEmail = new EmailAddress($input->getArgument('email'));

            $command = new ChangeUserEmail($userId, $newEmail);
            $this->getCommandBus()->handle($command);
        } catch (\Exception $e) {
            if ($e instanceof UserNotFoundException
                || $e instanceof InvalidEmailAddressException
                || $e instanceof InvalidValueForUserIdException
            ) {
                $output->writeln($e->getMessage());

                return 1;
            }
        }

        $output->writeln(sprintf('Change email command for user %d executed successfully.', $userId->id()));

        return 0;
    }

    /**
     * @return MessageBus
     */
    private function getCommandBus()
    {
        return $this->getContainer()->get('command_bus');
    }
}
