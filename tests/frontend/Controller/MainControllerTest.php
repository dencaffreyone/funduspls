<?php

namespace Tests\Frontend\Controller;

use App\Test\BootstrapTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainControllerTest extends BootstrapTestCase
{

    public function testHomepage()
    {
        $client = $this->getClientBrowser();

        $client->request(
            Request::METHOD_GET,
            '/'
        );

        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_MOVED_PERMANENTLY, $response->getStatusCode());
        $this->assertEquals('/de', $response->headers->get('location'));

        $client->request(
            Request::METHOD_GET,
            '/de'
        );

        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

}