<?php

namespace App\Security\TwoFactor\Listener;

use App\Security\TwoFactor\Email\Helper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class RequestListener
{
    /**
     * @var \App\Security\TwoFactor\Email\Helper $helper
     */
    protected $helper;

    /**
     * @var \Symfony\Component\Security\Core\TokenStorageInterface  $tokenStorage
     */
    protected $tokenStorage;

    /**
     * @var \Twig_Environment $templating
     */
    protected $templating;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router $router
     */
    protected $router;

    /**
     * Construct the listener
     * @param \App\Security\TwoFactor\Email\Helper $helper
     * @param \Symfony\Component\Security\Core\TokenStorage  $tokenStorage
     * @param \Twig_Environment $templating
     * @param \Symfony\Bundle\FrameworkBundle\Routing\Router $router
     */
    public function __construct(Helper $helper, TokenStorageInterface $tokenStorage, \Twig_Environment $templating, Router $router) {
        $this->helper = $helper;
        $this->tokenStorage = $tokenStorage;
        $this->templating = $templating;
        $this->router = $router;
    }

    /**
     * Listen for request events
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onCoreRequest(GetResponseEvent $event) {
        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return;
        }
        if (!$token instanceof UsernamePasswordToken) {
            return;
        }

        $key = $this->helper->getSessionKey($this->tokenStorage->getToken());
        $request = $event->getRequest();
        $session = $event->getRequest()->getSession();
        $user = $this->tokenStorage->getToken()->getUser();

        //Check if user has to do two-factor authentication
        if (!$session->has($key)) {
            return;
        }
        if ($session->get($key) === true) {
            return;
        }

        if ($request->getMethod() == 'POST') {
            //Check the authentication code
            if ($this->helper->checkCode($user, $request->get('_auth_code')) == true) {
                //Flag authentication complete
                $session->set($key, true);

                //Redirect to user's dashboard
                $redirect = new RedirectResponse($this->router->generate("dashboard"));
                $event->setResponse($redirect);
                return;
            } else {
                $session->getFlashBag()->set("error", "The verification code is not valid.");
            }
        }

        //Force authentication code dialog
        $content = $this->templating->render('TwoFactor/email.html.twig');
        $response = new Response($content);
        $event->setResponse($response);
    }
}