<?php

namespace App\Uploadable;

use Gedmo\Uploadable\FileInfo\FileInfoInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedFileInfo implements FileInfoInterface
{

    private $uploadedFile;

    public function __construct(UploadedFile $uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
    }

    public function getTmpName()
    {
        return $this->uploadedFile->getPathname();
    }

    public function getName()
    {
        $ext = $this->uploadedFile->guessExtension();
        if (!$ext) {
            $ext = 'txt';
        }
        return $this->uploadedFile->getClientOriginalName() . '.' . $ext;
    }

    public function getClientOriginalName()
    {
        return $this->uploadedFile->getClientOriginalName();
    }

    public function getSize()
    {
        return $this->uploadedFile->getClientSize();
    }

    public function getType()
    {
        return $this->uploadedFile->getMimeType();
    }

    public function getError()
    {
        return $this->uploadedFile->getError();
    }

    /**
     * {@inheritDoc}
     */
    public function isUploadedFile()
    {
        return is_uploaded_file($this->uploadedFile->getPathname());
    }

}