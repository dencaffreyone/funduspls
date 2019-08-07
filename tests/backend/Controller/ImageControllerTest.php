<?php

namespace Tests\Backend\Controller;

use App\Entity\FileImage;
use App\Test\CRUDControllerTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class ImageControllerTest extends CRUDControllerTestCase
{

    protected $wrongUpdateStatusCode = Response::HTTP_FOUND;

    public function setUp()
    {
        parent::setUp();

        $this->clearData();
    }

    public function clearData()
    {
        $image = $this->getEm()->getRepository(FileImage::class)->findOneBy([
            'real_file_name' => 'test.jpeg'
        ]);
        if ($image) {
            $this->getEm()->remove($image);
            $this->getEm()->flush($image);
        }
    }

    protected function getCreateData($namespace = null)
    {
        return [];
    }

    protected function getCreateWrongData($namespace = null)
    {
        return [];
    }

    protected function getUpdateData($namespace = null)
    {
        return [];
    }

    protected function getUpdateWrongData($namespace = null)
    {
        return [];
    }

    protected function getCreateFileData($namespace = null)
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'Tmp');
        copy(dirname(__FILE__) . '/../../data/test.jpeg', $tempFile);

        return [
            'file_path' => new UploadedFile($tempFile, 'test.jpeg')
        ];
    }

    protected function getCreateWrongFileData($namespace = null)
    {
        $data = $this->getCreateData($namespace);
        $data['file_path'] = '';
        return $data;
    }

    protected function getUpdateWrongFileData($namespace = null)
    {
        return $this->getCreateWrongFileData($namespace);
    }

    protected function getUpdateFileData($namespace = null)
    {
        return $this->getCreateFileData($namespace);
    }

    protected function getRoutePrefix()
    {
        return 'admin_app_fileimage_';
    }

    protected function getUpdateObject($namespace = null)
    {
        return $this->getEm()
            ->getRepository(FileImage::class)
            ->createQueryBuilder('a')
            ->where('a.real_file_name = :name')
            ->setParameter('name', 'test.jpeg')
            ->getQuery()
            ->getOneOrNullResult();
    }

}