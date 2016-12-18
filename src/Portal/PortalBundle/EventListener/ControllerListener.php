<?php
/**
 * Created by PhpStorm.
 * User: Богдан
 * Date: 17.12.2016
 * Time: 20:55
 */
namespace Portal\PortalBundle\EventListener;

use Portal\PortalBundle\Controller\BackController;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ControllerListener {

    public  function onKernelController(FilterControllerEvent $event) {

        $controller = $event->getController();


        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof BackController) {

            $user = $controller[0]->getUser();

            if (!$user) {
                $url = $controller[0]->generateUrl('fos_user_security_login');

                $event->setController(function() use ($url) {
                    return new RedirectResponse($url);
                });
            }
        }
    }
}
