<?php

namespace App\Entity;

use App\Entity\Interfaces\ContentWithImageInterface;
use App\Entity\Superclass\Content;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * @ORM\Table(name="contents_pages_translations")
 */
class ContentPageTranslation
{

    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $url;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $metaTitle = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $metaKeywords = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $metaDescription = '';

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $content = '';

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return ContentPageTranslation
     */
    public function setUrl($url) : ContentPageTranslation
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getMetaTitle() : string
    {
        return $this->metaTitle;
    }

    /**
     * @param string $metaTitle
     *
     * @return ContentPageTranslation
     */
    public function setMetaTitle($metaTitle) : ContentPageTranslation
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * @return string
     */
    public function getMetaKeywords() : string
    {
        return $this->metaKeywords;
    }

    /**
     * @param string $metaKeywords
     *
     * @return ContentPageTranslation
     */
    public function setMetaKeywords($metaKeywords) : ContentPageTranslation
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * @return string
     */
    public function getMetaDescription() : string
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     *
     * @return ContentPageTranslation
     */
    public function setMetaDescription($metaDescription) : ContentPageTranslation
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent() : ?string
    {
        return $this->content;
    }

    public function setContent($content) : ContentPageTranslation
    {
        $this->content = $content;

        return $this;
    }

    public function getFullUrl() : string
    {
        $parent = $this->getTranslatable()->getParent();

        return ($parent ? $parent->getTranslations()[$this->getLocale()]->getUrl() . '/' : '') . trim(ltrim($this->getUrl(), '/'));
    }

}
