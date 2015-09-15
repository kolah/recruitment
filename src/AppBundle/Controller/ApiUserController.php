<?php

namespace AppBundle\Controller;

use AppBundle\Messages\Command\ChangeUserEmail;
use AppBundle\Model\EmailAddress;
use AppBundle\Model\Exception\InvalidEmailAddressException;
use AppBundle\Model\Exception\UserNotFoundException;
use AppBundle\Model\UserId;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/api/user", service="api.controller.user")
 */
class ApiUserController
{
    private $commandBus;

    public function __construct(MessageBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/{user_id}/email", requirements={"user_id" = "\d+", "_format" = "json"})
     * @Method("PUT")
     *
     * @param Request $request
     */
    public function changeEmailAction(Request $request)
    {
        try {
            // NOTE: filtering user input handled internally by value objects
            //       and route requirements
            $userId = new UserId((int) $request->get('user_id'));
            $newEmail = new EmailAddress($request->request->get('email'));

            $command = new ChangeUserEmail($userId, $newEmail);
            $this->commandBus->handle($command);
        } catch (UserNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (InvalidEmailAddressException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
        // Gotta catch 'em all. Such exception should rather be handled by additional listener
        /* catch (\Exception $e) {
            return new JsonResponse(['message' => 'An unexpected error has occurred.', JsonResponse::HTTP_INTERNAL_SERVER_ERROR]);
        }*/

        return new JsonResponse(['message' => 'E-mail updated.'], JsonResponse::HTTP_CREATED);
    }
}
