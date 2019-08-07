<?php

namespace Tests\Backend\Controller;

use App\Entity\Admin;
use App\Test\BootstrapTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginControllerTest extends BootstrapTestCase
{

    public function testAuth()
    {
        // login with incorrect password
        $this->getClientBrowser()->request(
            'POST',
            $this->getRouter()->generate('login_check'),
            [
                '_username' => 'admin',
                '_password' => 'test'
            ]
        );

        $response = $this->getClientBrowser()->getResponse();
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertRegExp('/\/login$/', $response->headers->get('location'));
        $this->getClientBrowser()->followRedirect();
        $response = $this->getClientBrowser()->getResponse();
        $this->assertContains('Invalid credentials.', $response->getContent());

        // login with correct password
        $this->getClientBrowser()->request(
            'POST',
            $this->getRouter()->generate('login_check'),
            [
                '_username' => 'admin',
                '_password' => 'admin'
            ]
        );

        $response = $this->getClientBrowser()->getResponse();
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertRegExp('/\/dashboard/', $response->headers->get('location'));
        $this->getClientBrowser()->followRedirect();
        $response = $this->getClientBrowser()->getResponse();
        $this->assertNotContains('Invalid credentials.', $response->getContent());

        // logout
        $this->getClientBrowser()->request('GET', $this->getRouter()->generate('logout'));
        $response = $this->getClientBrowser()->getResponse();
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertRegExp('/\/login/', $response->headers->get('location'));
    }

    public function testAuthTwoFactor()
    {
        $this->getClientBrowser()->request(
            'POST',
            $this->getRouter()->generate('login_check'),
            [
                '_username' => 'admin2',
                '_password' => 'admin2'
            ]
        );

        $response = $this->getClientBrowser()->getResponse();
        $this->assertRegExp('/\/dashboard/', $response->headers->get('location'));

        $crawler = $this->getClientBrowser()->followRedirect();

        // login with wrong auth code
        $form = $crawler->selectButton('_submit')->form();
        $form['_auth_code'] = 'wrong_code';

        $crawler = $this->getClientBrowser()->submit($form);

        $response = $this->getClientBrowser()->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertContains('The verification code is not valid.', $response->getContent());

        $admin = $this->getEm()->getRepository(Admin::class)->findOneBy([
            'username' => 'admin2'
        ]);

        $form = $crawler->selectButton('_submit')->form();
        $form['_auth_code'] = $admin->getTwoFactorCode();

        $crawler = $this->getClientBrowser()->submit($form);

        $response = $this->getClientBrowser()->getResponse();
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertRegExp('/\//', $response->headers->get('location'));

        // logout
        $this->getClientBrowser()->request('GET', $this->getRouter()->generate('logout'));
        $response = $this->getClientBrowser()->getResponse();
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertRegExp('/\/login/', $response->headers->get('location'));
    }

}