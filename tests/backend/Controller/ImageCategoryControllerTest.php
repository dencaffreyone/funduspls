<?php

namespace Tests\Backend\Controller;

use App\Entity\FileImageCategory;
use App\Test\CRUDControllerTestCase;

class ImageCategoryControllerTest extends CRUDControllerTestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->clearData();
    }

    public function clearData()
    {
        $this->getEm()->getConnection()->exec("delete from images_categories where name='test'");
    }

    protected function getCreateData($namespace = null)
    {
        return [
            'name' => 'test'
        ];
    }

    protected function getCreateWrongData($namespace = null)
    {
        $data = $this->getCreateData($namespace);
        $data['name'] = '';
        return $data;
    }

    protected function getUpdateWrongData($namespace = null)
    {
        return $this->getCreateWrongData($namespace);
    }

    protected function getUpdateData($namespace = null)
    {
        return $this->getCreateData($namespace);
    }

    protected function getRoutePrefix()
    {
        return 'admin_app_fileimagecategory_';
    }

    protected function getUpdateObject($namespace = null)
    {
        return $this->getEm()
            ->getRepository(FileImageCategory::class)
            ->createQueryBuilder('a')
            ->where('a.name = :name')
            ->setParameter('name', 'test')
            ->getQuery()
            ->getOneOrNullResult();
    }

}