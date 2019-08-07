<?php

namespace Tests\Backend\Controller;

use App\Entity\Admin;
use App\Test\CRUDControllerTestCase;

class AdminAdminControllerTest extends CRUDControllerTestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->clearData();
    }

    public function clearData()
    {
        $this->getEm()->getConnection()->exec("delete from admins where username='test'");
    }

    protected function getCreateData($namespace = null)
    {
        return [
            'username' => 'test',
            'password' => 'test',
            'repeat_password' => 'test'
        ];
    }

    protected function getCreateWrongData($namespace = null)
    {
        $data = $this->getCreateData($namespace);
        $data['username'] = '';
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
        return 'admin_app_admin_';
    }

    protected function getUpdateObject($namespace = null)
    {
        return $this->getEm()
            ->getRepository(Admin::class)
            ->createQueryBuilder('a')
            ->where('a.username = :username')
            ->setParameter('username', 'test')
            ->getQuery()
            ->getOneOrNullResult();
    }

}