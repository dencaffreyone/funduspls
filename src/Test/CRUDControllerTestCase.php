<?php

namespace App\Test;

use App\Test\BootstrapTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class CRUDControllerTestCase extends BootstrapTestCase
{

    protected $admin_login = 'admin';
    protected $admin_password = 'admin';

    protected $checkCreateTests = true;
    protected $checkUpdateTests = true;
    protected $checkDeleteTests = true;

    protected $wrongCreateStatusCode = Response::HTTP_OK;
    protected $createStatusCode = Response::HTTP_FOUND;

    protected $wrongUpdateStatusCode = Response::HTTP_OK;
    protected $updateStatusCode = Response::HTTP_FOUND;

    protected function loginAsAdmin()
    {
        $this->getClientBrowser()->request(Request::METHOD_GET, $this->getRouter()->generate('login'));
        $this->getClientBrowser()->request(
            'POST',
            $this->getRouter()->generate('login_check'),
            [
                '_username' => $this->admin_login,
                '_password' => $this->admin_password
            ]
        );
    }

    public function setUp()
    {
        parent::setUp();

        $this->loginAsAdmin();
    }

    public function testList()
    {
        $client = $this->getClientBrowser();

        $client->request(
            Request::METHOD_GET,
            $this->getRouter()->generate($this->getRoutePrefix() . 'list')
        );
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testCreateUpdateDelete()
    {
        foreach ($this->getSubclasses() as $subclass) {
            $client = $this->getClientBrowser();

            if ($this->checkCreateTests) {
                $crawler = $client->request(
                    Request::METHOD_GET,
                    $this->getRouter()->generate($this->getRoutePrefix() . 'create') . ($subclass ? '?subclass=' . $subclass : '')
                );
                $csrfData = $crawler->filter('input')
                    ->extract(['value', 'name']);
                $csrfTokenData = $csrfData[count($csrfData) -1 ];
                $csrfToken = $csrfTokenData[0];
                $formName = substr($csrfTokenData[1], 0, strpos($csrfTokenData[1], '['));

                $wrongData = $this->getCreateWrongData($subclass);
                $wrongFileData = $this->getCreateWrongFileData($subclass);
                $wrongData['_token'] = $csrfToken;

                // create
                $client->request(
                    Request::METHOD_POST,
                    $this->getRouter()->generate($this->getRoutePrefix() . 'create')  . '?uniqid=' . $formName . ($subclass ? '&subclass=' . $subclass : ''), [
                        $formName => $wrongData
                    ], [
                        $formName => $wrongFileData
                    ]
                );
                $response = $client->getResponse();
                $this->assertEquals($this->wrongCreateStatusCode, $response->getStatusCode());

                $data = $this->getCreateData($subclass);
                $fileData = $this->getCreateFileData($subclass);
                $data['_token'] = $csrfToken;

                $client->request(
                    Request::METHOD_POST,
                    $this->getRouter()->generate($this->getRoutePrefix() . 'create')  . '?uniqid=' . $formName . ($subclass ? '&subclass=' . $subclass : ''), [
                        $formName => $data
                    ], [
                        $formName => $fileData
                    ]
                );
                $response = $client->getResponse();
                $this->assertEquals($this->createStatusCode, $response->getStatusCode());
            }

            if ($this->checkUpdateTests) {
                // update
                $object = $this->getUpdateObject($subclass);

                $client = $this->getClientBrowser();

                $crawler = $client->request(
                    Request::METHOD_GET,
                    $this->getRouter()->generate($this->getRoutePrefix() . 'edit', [
                        'id' => $object->getId()
                    ])
                );
                $csrfData = $crawler->filter('input')
                    ->extract(['value', 'name']);
                $csrfTokenData = $csrfData[count($csrfData) - 1];
                $csrfToken = $csrfTokenData[0];
                $formName = substr($csrfTokenData[1], 0, strpos($csrfTokenData[1], '['));

                $wrongData = $this->getUpdateWrongData($subclass);
                $wrongFileData = $this->getUpdateWrongFileData($subclass);
                $wrongData['_token'] = $csrfToken;

                $client->request(
                    Request::METHOD_POST,
                    $this->getRouter()->generate($this->getRoutePrefix() . 'edit', [
                        'id' => $object->getId()
                    ]) . '?uniqid=' . $formName, [
                        $formName => $wrongData
                    ], [
                        $formName => $wrongFileData
                    ]
                );
                $response = $client->getResponse();
                $this->assertEquals($this->wrongUpdateStatusCode, $response->getStatusCode());

                $data = $this->getUpdateData($subclass);
                $fileData = $this->getUpdateFileData($subclass);
                $data['_token'] = $csrfToken;

                $client->request(
                    Request::METHOD_POST,
                    $this->getRouter()->generate($this->getRoutePrefix() . 'edit', [
                        'id' => $object->getId()
                    ]) . '?uniqid=' . $formName, [
                        $formName => $data
                    ], [
                        $formName => $fileData
                    ]
                );
                $response = $client->getResponse();
                $this->assertEquals($this->updateStatusCode, $response->getStatusCode());
            }

            if ($this->checkDeleteTests) {
                // update
                $object = $this->getUpdateObject($subclass);

                $client = $this->getClientBrowser();

                $crawler = $client->request(
                    Request::METHOD_GET,
                    $this->getRouter()->generate($this->getRoutePrefix() . 'delete', [
                        'id' => $object->getId()
                    ])
                );

                $csrfData = $crawler->filter('input')
                    ->extract(['value']);
                if (count($csrfData) == 2) {
                    $method = $csrfData[0];
                    $token = $csrfData[1];
                } else {
                    $method = $csrfData[1];
                    $token = $csrfData[2];
                }

                $client->request(
                    Request::METHOD_POST,
                    $this->getRouter()->generate($this->getRoutePrefix() . 'delete', [
                        'id' => $object->getId()
                    ])
                );
                $response = $client->getResponse();
                $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

                $client->request(
                    Request::METHOD_POST,
                    $this->getRouter()->generate($this->getRoutePrefix() . 'delete', [
                        'id' => $object->getId()
                    ]), [
                        '_method' => $method,
                        '_sonata_csrf_token' => $token
                    ]
                );

                $response = $client->getResponse();
                $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
            }
        }

        if (!$this->checkCreateTests and !$this->checkUpdateTests and !$this->checkDeleteTests) {
            $this->assertEquals(true, true);
        }

    }

    abstract protected function getRoutePrefix();

    protected function getCreateWrongData($namespace = null)
    {
        return [];
    }

    protected function getCreateData($namespace = null)
    {
        return [];
    }

    protected function getUpdateWrongData($namespace = null)
    {
        return [];
    }

    protected function getUpdateData($namespace = null)
    {
        return [];
    }

    protected function getCreateWrongFileData($namespace = null)
    {
        return [];
    }

    protected function getCreateFileData($namespace = null)
    {
        return [];
    }

    protected function getUpdateWrongFileData($namespace = null)
    {
        return [];
    }

    protected function getUpdateFileData($namespace = null)
    {
        return [];
    }

    abstract protected function getUpdateObject($namespace = null);

    protected function getSubclasses()
    {
        return [null];
    }
}