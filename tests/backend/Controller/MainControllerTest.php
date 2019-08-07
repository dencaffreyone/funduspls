<?php

namespace Tests\Backend\Controller;

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
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

}