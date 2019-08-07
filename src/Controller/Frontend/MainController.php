<?php

namespace App\Controller\Frontend;

use App\Form\ContactType;
use App\Manager\NotificationManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class MainController
{

    /**
     * @Route("/", name="homepage_redirect")
     */
    public function indexRedirect(UrlGeneratorInterface $router)
    {
        return new RedirectResponse($router->generate('homepage'), Response::HTTP_MOVED_PERMANENTLY);
    }

    public function index(Environment $twig)
    {
        return new Response($twig->render('Main/index.html.twig'));
    }

    public function page(Environment $twig)
    {
        return new Response($twig->render('Main/page.html.twig'));
    }

    /**
     * @Route("/{_locale}/contact", name="contact")
     */
    public function contact(Environment $twig, FormFactoryInterface $formFactory, Request $request, NotificationManager $notificationService)
    {
        $form = $formFactory->create(ContactType::class);

        if ($request->isMethod(Request::METHOD_POST)) {
            $messageSent = false;
            $form->handleRequest($request);

            if ($form->isSubmitted() and $form->isValid()) {
                $data = $form->getData();
                $messageSent = $notificationService->notifyByContactForm($request->getHost(), $data['name'], $data['email'], $data['message']);

                if ($messageSent) {
                    $form = $formFactory->create(ContactType::class);
                }
            }
        }

        return new Response($twig->render('Main/contact_form.html.twig', [
            'form' => $form->createView(),
            'message_sent' => isset($messageSent) ? $messageSent : null
        ]));
    }

}