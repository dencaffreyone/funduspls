<?php

namespace App\EventListener;

use App\Manager\ContentPageManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;

class ContentPageListener
{
    /** @var ContentPageManager  */
    protected $pageContentManager;

    /** @var RouterInterface */
    private $router;

    public function __construct(ContentPageManager $pageContentManager, RouterInterface $router)
    {
        $this->pageContentManager = $pageContentManager;
        $this->router = $router;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }
        $request = $event->getRequest();

        $route = $request->attributes->get('_route');

        // temp locale redirect
        $locale = $request->attributes->get('_locale');
        if ($locale === 'de') {
            $redirect = new RedirectResponse($this->router->generate($route, ['_locale' => 'en']), Response::HTTP_TEMPORARY_REDIRECT);
            $event->setResponse($redirect);
        }

        if (($page = $this->pageContentManager->findPageByRoute($route))) {
            $this->pageContentManager->generateCacheForPage($page);

            $request->attributes->set('meta_title', $page->getMetaTitle());
            $request->attributes->set('meta_keywords', $page->getMetaKeywords());
            $request->attributes->set('meta_description', $page->getMetaDescription());
            $request->attributes->set('content', $page->getContent());
        }
    }
}

