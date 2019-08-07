<?php
/**
 * Created by PhpStorm.
 * User: maxik
 * Date: 11/13/13
 * Time: 12:34 PM
 */

namespace App\Test;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;

abstract class BootstrapTestCase extends WebTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();

        $this->router = static::$kernel->getContainer()->get('router');
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();

        parent::setUp();
    }

    /**
     * @return RouterInterface
     */
    protected function getRouter()
    {
        return $this->router;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEm()
    {
        return $this->em;
    }

    /**
     * @return Client
     */
    protected function getClientBrowser()
    {
        return $this->client;
    }

    protected function generateCsrfToken($intention)
    {
        $csrf = $this->getClientBrowser()->getContainer()->get('security.csrf.token_manager');
        return $csrf->refreshToken($intention);
    }

}
