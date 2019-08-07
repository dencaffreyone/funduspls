<?php

namespace App\Entity\Superclass;

use App\Uploadable\RealFileNameInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use phpDocumentor\Reflection\Types\Mixed_;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 *
 * @Gedmo\Uploadable(pathMethod="getPath", filenameGenerator="App\Uploadable\FilenameGenerator", allowOverwrite=true, appendNumber=true)
 */
abstract class File implements RealFileNameInterface
{

    const UPLOAD_DIR = 'uploads/files';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Gedmo\UploadableFileName()
     */
    protected $real_file_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Gedmo\UploadableFileName()
     */
    protected $file_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Gedmo\UploadableFileMimeType()
     */
    protected $mime_type;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     * @Gedmo\UploadableFileSize()
     */
    protected $size = 0;

    protected $file_path;

    public function __toString()
    {
        return (string) $this->getRealFileName();
    }

    public function getUploadRootDir() : string
    {
        return __DIR__ . '/../../../public/';
    }

    public function getWebUploadDir() : string
    {
        return static::UPLOAD_DIR;
    }

    public function getAbsolutePath() : string
    {
        return realpath($this->getPath() . '/' . $this->getFileName());
    }

    public function getPath() : string
    {
        return $this->getUploadRootDir() . $this->getWebUploadDir();
    }

    public function getWebPath() : string
    {
        return $this->getWebUploadDir() . $this->getFileName();
    }

    public function getId() :? int
    {
        return $this->id;
    }

    public function setFileName($fileName = null) : File
    {
        $this->file_name = $fileName;

        return $this;
    }

    public function setFilePath($filePath) : File
    {
        $this->file_path = $filePath;

        return $this;
    }

    public function getFilePath()
    {
        return $this->file_path;
    }

    public function getFileName() : ? string
    {
        return $this->file_name;
    }

    public function setMimeType($mimeType = null) : File
    {
        $this->mime_type = $mimeType;

        return $this;
    }

    public function getMimeType() : string
    {
        return $this->mime_type;
    }

    public function setSize($size) : File
    {
        $this->size = $size ?: 0;

        return $this;
    }

    public function getSize() : int
    {
        return $this->size;
    }

    public function hasFile() : bool
    {
        return (bool) $this->getFileName();
    }

    public function getRealFileName() :? string
    {
        return $this->real_file_name;
    }

    public function setRealFileName($realFileName) : File
    {
        $this->real_file_name = $realFileName;

        return $this;
    }

}
