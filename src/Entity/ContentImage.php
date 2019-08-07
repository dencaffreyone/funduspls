<?php

namespace App\Entity;

use App\Entity\Superclass\Content;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="contents_images")
 */
class ContentImage extends Content
{
    protected $contentType = "Text block";

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    protected $uid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FileImage", cascade={"all"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $image;

    /**
     * @return string
     */
    public function getImage() :? FileImage
    {
        return $this->image;
    }

    /**
     * @param string $content
     *
     * @return ContentImage
     */
    public function setImage(FileImage $image = null) : ContentImage
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getUid() : string
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     *
     * @return ContentImage
     */
    public function setUid($uid) : ContentImage
    {
        $this->uid = $uid;

        return $this;
    }
    
}

