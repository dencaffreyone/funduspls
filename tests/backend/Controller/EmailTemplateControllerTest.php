<?php

namespace Tests\Backend\Controller;

use App\Entity\EmailTemplate;
use App\Test\CRUDControllerTestCase;

class EmailTemplateControllerTest extends CRUDControllerTestCase
{

    protected $checkCreateTests = false;
    protected $checkDeleteTests = false;

    protected function getUpdateData($namespace = null)
    {
        return [
            'name' => 'Contact Form',
            'translations' => [
                'en' => [
                    'subject' => 'Contact from {siteName}',
                    'message' => '<p><b>Name</b>: {userName}</p><p><b>Email</b>: {userEmail}</p><p><b>Message</b>: {userMessage}</p>',
                ],
                'de' => [
                    'subject' => 'Contact from {siteName}',
                    'message' => '<p><b>Name</b>: {userName}</p><p><b>Email</b>: {userEmail}</p><p><b>Message</b>: {userMessage}</p>',
                ]
            ]
        ];
    }

    protected function getUpdateWrongData($namespace = null)
    {
        $data = $this->getCreateData($namespace);
        $data['name'] = '';
        return $data;
    }

    protected function getRoutePrefix()
    {
        return 'admin_app_emailtemplate_';
    }

    protected function getUpdateObject($namespace = null)
    {
        return $this->getEm()
            ->getRepository(EmailTemplate::class)
            ->createQueryBuilder('a')
            ->where('a.event = :name')
            ->setParameter('name', 'contact')
            ->getQuery()
            ->getOneOrNullResult();
    }

}