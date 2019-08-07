<?php

namespace App\Routing;

use App\Entity\ContentPage;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class ContentPageLoader extends Loader
{

    private $loaded = false;

    /** @var EntityManager  */
    protected $entityManager;

    /** @var string  */
    protected $defaultControllerAction;

    /** @var string  */
    protected $defaultTemplate;

    public function __construct(EntityManager $entityManager, $defaultControllerAction, $defaultTemplate)
    {
        $this->entityManager = $entityManager;
        $this->defaultControllerAction = $defaultControllerAction;
        $this->defaultTemplate = $defaultTemplate;
    }

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "page content" loader twice');
        }

        $routes = new RouteCollection();

        /** @var ContentPage[] $pages */
        $pages = $this->entityManager->getRepository(ContentPage::class)->findAll();

        /** @var ContentPage $page */
        foreach ($pages as $page) {
            $defaults = [
                '_controller' =>
                    $page->getControllerAction() ? $page->getControllerAction() : $this->defaultControllerAction,
                'template' => $page->getTemplate() ? $page->getTemplate() : $this->defaultTemplate
            ];
            $requirements = [];

            foreach ($page->getTranslations() as $translation) {
                $locale = $translation->getLocale();

                $route = new Route($translation->getFullUrl(), $defaults, $requirements);
                $route->setDefault('_locale', $locale);
                $route->setDefault('_canonical_route', $page->getRoute());
                $routes->add($page->getRoute() . '.' . $locale, $route);
            }

        }

        $this->loaded = true;

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'content_page' === $type;
    }

}

