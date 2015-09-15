<?php

namespace AppBundle\Request;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Listener which transforms JSON request contents as if they were
 * sent like POST data.
 */
class JsonRequestListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->isMasterRequest()) {
            $request = $event->getRequest();
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : []);
            }
        }
    }
}
