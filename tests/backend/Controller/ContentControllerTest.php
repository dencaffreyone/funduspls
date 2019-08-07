<?php

namespace Tests\Backend\Controller;

use App\Entity\ContentPage;
use App\Test\CRUDControllerTestCase;

class ContentControllerTest extends CRUDControllerTestCase
{

    protected $checkCreateTests = false;
    protected $checkDeleteTests = false;

    protected function getUpdateData($namespace = null)
    {
        return [
            'name' => 'Homepage',
            'translations' => [
                'en' => [
                    'url' => '/en',
                    'metaTitle' => 'meta title homepage',
                    'metaKeywords' => 'meta keywords homepage',
                    'metaDescription' => 'meta description homepage',
                ],
                'de' => [
                    'url' => '/de',
                    'metaTitle' => 'meta title homepage',
                    'metaKeywords' => 'meta keywords homepage',
                    'metaDescription' => 'meta description homepage',
                ],
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
        return 'admin_app_superclass_content_';
    }

    protected function getUpdateObject($namespace = null)
    {
        return $this->getEm()
            ->getRepository(ContentPage::class)
            ->createQueryBuilder('a')
            ->where('a.route = :name')
            ->setParameter('name', 'homepage')
            ->getQuery()
            ->getOneOrNullResult();
    }

}