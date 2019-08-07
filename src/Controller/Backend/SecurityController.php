<?php

namespace App\Controller\Backend;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sonata\AdminBundle\Admin\Pool;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Sonata\AdminBundle\Controller\CoreController as SonataCoreController;

class SecurityController extends SonataCoreController
{

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils, Pool $adminPool, Environment $twig)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return new Response($twig->render(
            'Security/login.html.twig',
            [
                'last_username'     => $lastUsername,
                'error'             => $error,
                'admin_pool'        => $adminPool
            ]
        ));
    }

    /**
     * @Route("/login-check", name="login_check")
     */
    public function loginCheckAction()
    {

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction()
    {
        return parent::dashboardAction();
    }

}
