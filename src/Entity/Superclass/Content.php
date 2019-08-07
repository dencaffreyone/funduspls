<?php

namespace App\Entity\Superclass;

use App\Entity\ContentImage;
use App\Entity\ContentPage;
use App\Entity\ContentTextBlock;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="contents",indexes={@ORM\Index(name="type_idx", columns={"content_type"})})
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(
 *     name="content_type",
 *     type="string",
 *     columnDefinition="ENUM('page','text_block', 'image') DEFAULT 'page'"
 * )
 * @ORM\DiscriminatorMap({"page" = "App\Entity\ContentPage", "text_block" = "App\Entity\ContentTextBlock", "image" = "App\Entity\ContentImage"})
 * @ORM\HasLifecycleCallbacks
 */
abstract class Content
{
    use TimestampableEntity;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Content", mappedBy="parent")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="Content", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $level = 0;

    protected $contentType;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Content
     */
    public function setName($name) : Content
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChildren() :? PersistentCollection
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     *
     * @return Content
     */
    public function setChildren($children) : Content
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent() :? Content
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     *
     * @return Content
     */
    public function setParent($parent) : Content
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLevel() : int
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     *
     * @return Content
     */
    public function setLevel($level) : Content
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentType() : string
    {
        return $this->contentType;
    }

    /**
     * @param mixed $contentType
     *
     * @return Content
     */
    public function setContentType($contentType) : Content
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function calculateLevelPrePersist() : void
    {
        $this->calculateLevel();
    }

    /**
     * @ORM\PreUpdate
     */
    public function calculateLevelPreUpdate() : void
    {
        $this->calculateLevel();
    }

    protected function calculateLevel() : void
    {
        $level = ($this->getParent() instanceof Content)? $this->getParent()->getLevel() + 1: 1;
        $this->setLevel($level);
    }

    public function __toString() : string
    {
        return $this->getContentType() . ' ' . $this->getName();
    }

    public function isPage() : bool
    {
        return $this instanceof ContentPage;
    }

    public function isTextBlock() : bool
    {
        return $this instanceof ContentTextBlock;
    }

    public function isImage() : bool
    {
        return $this instanceof ContentImage;
    }

    public function levelOffset($delimiter) : string
    {
        return str_repeat($delimiter, ($this->getLevel() > 1) ? $this->getLevel() : 0);
    }

}

