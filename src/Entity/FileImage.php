<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Superclass\File;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="images")
 * @ORM\Entity
 * @Gedmo\Uploadable(pathMethod="getPath", filenameGenerator="App\Uploadable\FilenameGenerator", allowOverwrite=true, appendNumber=true)
 */
class FileImage extends File
{

    const UPLOAD_DIR = 'uploads/images';

    /**
     * @Assert\NotBlank(groups={"new"})
     * @Assert\Image(allowSquare=true, allowLandscape=true, allowPortrait=true)
     */
    protected $file_path;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\FileImageCategory", cascade={"persist"})
     * @ORM\JoinTable(name="images_has_images_categories",
     *      joinColumns={@ORM\JoinColumn(name="file_image_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_image_category_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function addCategory(FileImageCategory $category) : FileImage
    {
        $this->categories[] = $category;

        return $this;
    }

    public function removeCategory(FileImageCategory $category) : bool
    {
        return $this->categories->removeElement($category);
    }

    public function getCategories()
    {
        return $this->categories;
    }

}
