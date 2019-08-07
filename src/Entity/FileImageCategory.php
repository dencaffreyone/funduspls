<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="images_categories")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class FileImageCategory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="FileImageCategory", mappedBy="parent")
     */
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="FileImageCategory", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $level = 0;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function getId() :? int
    {
        return $this->id;
    }

    public function getName() :? string
    {
        return $this->name;
    }

    public function setName($name) : FileImageCategory
    {
        $this->name = $name;

        return $this;
    }

    public function getChildren() : PersistentCollection
    {
        return $this->children;
    }

    public function setChildren($children) : FileImageCategory
    {
        $this->children = $children;

        return $this;
    }

    public function getParent() : ?FileImageCategory
    {
        return $this->parent;
    }

    public function setParent(FileImageCategory $parent = null) : FileImageCategory
    {
        $this->parent = $parent;

        return $this;
    }

    public function getLevel() : int
    {
        return $this->level;
    }

    public function setLevel($level) : FileImageCategory
    {
        $this->level = $level;

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
        $level = ($this->getParent() instanceof FileImageCategory)? $this->getParent()->getLevel() + 1: 1;
        $this->setLevel($level);
    }

    public function __toString() : string
    {
        return (string) $this->getName();
    }

    public function levelOffset($delimiter) : string
    {
        return str_repeat($delimiter, ($this->getLevel() > 1) ? ($this->getLevel() - 1) : 0);
    }

}
